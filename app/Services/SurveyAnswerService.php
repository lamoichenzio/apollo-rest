<?php


namespace App\Services;


use App\MultiAnswer;
use App\MultiAnswerElement;
use App\Survey;
use App\SurveyAnswer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SurveyAnswerService
{

    public function create(Survey $survey, SurveyAnswer $surveyAnswer, Collection $answers)
    {
        DB::transaction(function () use ($survey, $surveyAnswer, $answers) {
            $surveyAnswer->totAnswers = 0;
            $survey->answers()->save($surveyAnswer);
            $answers->each(function ($answer) use ($surveyAnswer) {
                if (key_exists('answer', $answer)) {
                    $this->createSingleAnswer($surveyAnswer, $answer);
                }
                if (key_exists('answers', $answer)) {
                    $this->createMultiAnswer($surveyAnswer, $answer);
                }
                if (key_exists('answer_pair', $answer)) {
                    $this->createSingleMatrixAnswer($surveyAnswer, $answer);
                }
                if (key_exists('answers_pair', $answer)) {
                    $this->createMultiMatrixAnswer($surveyAnswer, $answer);
                }
            });
            $surveyAnswer->totAnswers = count($surveyAnswer->singleAnswers)
                + count($surveyAnswer->multiAnswers) + count($surveyAnswer->singleChoiceMatrixAnswers) + count($surveyAnswer->multiChoiceMatrixAnswers);
            $surveyAnswer->update();
        });
    }

    private function createSingleAnswer(SurveyAnswer $surveyAnswer, $answer)
    {
        $surveyAnswer->singleAnswers()->create([
            'answer' => $answer['answer'],
            'question_id' => $answer['question_id'],
            'question_type' => $answer['question_type']
        ]);
    }

    private function createMultiAnswer(SurveyAnswer $surveyAnswer, $answer)
    {
        $multiAnswer = new MultiAnswer(['multi_question_id' => $answer['question_id']]);
        $surveyAnswer->multiAnswers()->save($multiAnswer);
        foreach ($answer['answers'] as $element) {
            $multiAnswer->answers()->save(new MultiAnswerElement(['answer' => $element]));
        }
    }

    private function createSingleMatrixAnswer(SurveyAnswer $surveyAnswer, $answer)
    {
        // TODO
    }

    private function createMultiMatrixAnswer(SurveyAnswer $surveyAnswer, $answer)
    {
        // TODO
    }
}