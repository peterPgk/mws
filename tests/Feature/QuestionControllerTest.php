<?php
/**
 * Created by PhpStorm.
 * User: pgk
 * Date: 6/26/19
 * Time: 5:19 PM
 */

namespace Tests\Feature;

use App\Answer;
use App\Question;
use App\UserAnswer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionControllerTest extends TestCase
{

    use RefreshDatabase;

    public function test_user_not_logged_in_has_no_access()
    {
        $this->get('/questions')->assertRedirect('/login');
        $this->post('/questions', [])->assertRedirect('/login');
        $this->get('/questions/create')->assertRedirect('/login');
        $this->put('/questions/1')->assertRedirect('/login');
        $this->delete('/questions/1')->assertRedirect('/login');
        $this->get('/questions/1/edit')->assertRedirect('/login');
    }

    public function test_user_cannot_delete_question_already_answered()
    {
        $user = $this->loginWithFakeUser();

        $questions = factory(Question::class, 3)->create()->each(function (Question $question) {
            $question->setRelation('answers', factory(Answer::class, 3)->create(['question_id' => $question->id]));
        });

        $answers = $questions->first()->answers->pluck('id');
        $user->answers()->sync($answers);

        $userAnswers = UserAnswer::where('user_id', $user->id)->whereIn('answer_id', $answers)->count();

        $this->assertEquals(3, $userAnswers);

        $response = $this->delete('/questions/'. $questions->first()->id);
        $response->assertStatus(302);

        //check data still persist into database
        $userAnswers = UserAnswer::where('user_id', $user->id)->whereIn('answer_id', $answers)->get();
        $this->assertCount(3, $userAnswers);
    }

}
