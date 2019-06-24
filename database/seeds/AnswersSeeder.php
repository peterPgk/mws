<?php

use App\Answer;
use App\Question;
use Illuminate\Database\Seeder;

class AnswersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = Question::all();

        foreach ($questions as $question) {
            factory(Answer::class, rand(2, 5))->create(['question_id' => $question->id]);
        }
    }
}
