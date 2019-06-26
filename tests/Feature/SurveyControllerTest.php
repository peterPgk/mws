<?php
/**
 * Created by PhpStorm.
 * User: pgk
 * Date: 6/26/19
 * Time: 2:05 PM
 */

namespace Tests\Feature;

use App\Answer;
use App\Question;
use App\UserAnswer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class SurveyControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @var Collection
     */
    private $questions;

    protected function setUp(): void
    {
        parent::setUp();

        // Create sample questions with answers and set relation
        $this->questions = factory(Question::class, 3)->create()->each(function (Question $question) {
            $question->setRelation('answers', factory(Answer::class, 3)->create(['question_id' => $question->id]));
        });
    }

    public function test_user_not_logged_in_has_no_access()
    {
        $this->get('/survey/create')->assertRedirect('/login');
        $this->post('/survey', [])->assertRedirect('/login');
    }

    /** @test */
    public function only_logged_in_user_can_take_survey()
    {
        //Pre check
        $this->assertCount(0, UserAnswer::get());

        //User not logged in can not see questions
        $this->get('/survey')->assertStatus(405);

        //Simulate user choice
        $userChoice = $this->takeQuestions();

        $this->post('/survey', $userChoice)->assertStatus(302);

        //No answers stored in the database
        $this->assertCount(0, UserAnswer::get());
    }

    /** @test */
    public function user_can_store_and_edit_answers()
    {
        // Create logged in user
        $user = $this->loginWithFakeUser([]);

        //Check that we dont have data for this user;
        $this->assertCount(0, UserAnswer::where('user_id', $user->id)->get());

        //Fake user choice
        $userChoice = $this->takeQuestions(2);

        $this->post('/survey', $userChoice)->assertStatus(200);

        /** @var Collection $answers */
        $answers = UserAnswer::where('user_id', $user->id)->get();

        //user has stored 6 answers
        $this->assertCount($this->questions->count() * 2, $answers);

        $chosenAnswers = [];
        foreach ($userChoice['questions'] as $question) {
            array_push($chosenAnswers, ...$question['answers']);
        }

        // Stored answers are the same as these that user choose
        $this->assertEmpty(array_diff($chosenAnswers, $answers->pluck('answer_id')->toArray()));


        //We decided to change user choice
        $newUserChoice = $this->takeQuestions(-1);

        //Store newly selected answers
        $this->post('/survey', $newUserChoice)->assertStatus(200);

        $answers = UserAnswer::where('user_id', $user->id)->get();

        //user has stored 3 answers
        $this->assertCount($this->questions->count(), $answers);

        $newlyChosenAnswers = [];
        foreach ($newUserChoice['questions'] as $question) {
            array_push($newlyChosenAnswers, ...$question['answers']);
        }

        // Stored answers are the same as these that user choose
        $this->assertEmpty(array_diff($newlyChosenAnswers, $answers->pluck('answer_id')->toArray()));

        //Old chosen answers are not in the database anymore
        $this->assertEmpty(UserAnswer::where('user_id', $user->id)->whereIn('answer_id', $chosenAnswers)->get());
    }

    /** @test */
    public function user_need_to_answer_to_all_questions()
    {
        // Create logged in user
        $this->loginWithFakeUser([]);

        //Fake user choice
        $userChoice = $this->takeQuestions();

        //Clean one of selected answers
        $userChoice['questions']['question_1']['answers'] = [];

        $response = $this->post('/survey', $userChoice)->assertStatus(302);
        $response->assertSessionHasErrors('questions.question_1.answers');

        array_shift($userChoice['questions']);

        $response = $this->post('/survey', $userChoice)->assertStatus(302);
        $response->assertSessionHasErrors('questions.question_1.answers');
    }


    /**
     * Grab num answers as user choice
     *
     * @param int $num
     * @return array
     */
    private function takeQuestions(int $num = 1)
    {
        return ['questions' => $this->questions->mapWithKeys(function (Question $question) use ($num) {
            return ['question_'. $question->id => [
                'id' => $question->id,
                'answers' => $question->answers->take($num)->pluck('id')->toArray()
            ]];
        })->toArray()];
    }
}
