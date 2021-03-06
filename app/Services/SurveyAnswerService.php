<?php


namespace App\Services;


use App\Helpers\DataHelper;
use App\MultiAnswer;
use App\MultiAnswerElement;
use App\MultiMatrixAnswer;
use App\MultiMatrixAnswerPair;
use App\SingleMatrixAnswer;
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
                if (key_exists('answerPair', $answer)) {
                    $this->createSingleMatrixAnswer($surveyAnswer, $answer);
                }
                if (key_exists('answersPair', $answer)) {
                    $this->createMultiMatrixAnswer($surveyAnswer, $answer);
                }
            });
            $surveyAnswer->totAnswers = count($surveyAnswer->singleAnswers)
                + count($surveyAnswer->multiAnswers) + count($surveyAnswer->singleChoiceMatrixAnswers) + count($surveyAnswer->multiChoiceMatrixAnswers);
            $surveyAnswer->update();
        });
        return DataHelper::creationDataResponse($surveyAnswer);
    }

    private function createSingleAnswer(SurveyAnswer $surveyAnswer, $answer)
    {
        $surveyAnswer->singleAnswers()->create([
            'answer' => $answer['answer'],
            'question_id' => $answer['questionId'],
            'question_type' => $answer['questionType']
        ]);
    }

    private function createMultiAnswer(SurveyAnswer $surveyAnswer, $answer)
    {
        $multiAnswer = new MultiAnswer(['multi_question_id' => $answer['questionId']]);
        $surveyAnswer->multiAnswers()->save($multiAnswer);
        foreach ($answer['answers'] as $element) {
            $multiAnswer->answers()->save(new MultiAnswerElement(['answer' => $element]));
        }
    }

    private function createSingleMatrixAnswer(SurveyAnswer $surveyAnswer, $answer)
    {
        $matrixAnswer = new SingleMatrixAnswer(['matrix_question_id' => $answer['questionId']]);
        $surveyAnswer->singleChoiceMatrixAnswers()->save($matrixAnswer);
        foreach ($answer['answerPair'] as $pair) {
            $matrixAnswer->pairs()->create([
                'element_id' => $pair['element'],
                'answer' => $pair['answer']
            ]);
        }
    }

    private function createMultiMatrixAnswer(SurveyAnswer $surveyAnswer, $answer)
    {
        $matrixAnswer = new MultiMatrixAnswer(['matrix_question_id' => $answer['questionId']]);
        $surveyAnswer->multiChoiceMatrixAnswers()->save($matrixAnswer);
        foreach ($answer['answersPair'] as $pair) {
            $singleAnswer = new MultiMatrixAnswerPair(['element_id' => $pair['element']]);
            $matrixAnswer->answers()->save($singleAnswer);
            foreach ($pair['answers'] as $pair_answer) {
                $singleAnswer->answers()->create(['answer' => $pair_answer]);
            }
        }
    }

    public function getAll(Survey $survey, int $pag_size = null, string $order = null, string $orderDir = null)
    {
        $query = SurveyAnswer::where('survey_id', $survey->id);
        if ($order != null && $orderDir != null) {
            $query = $query->orderBy($order, $orderDir);
        }
        if ($pag_size) {
            return $query->paginate($pag_size)->withQueryString();
        }
        return $query->get();
    }
}