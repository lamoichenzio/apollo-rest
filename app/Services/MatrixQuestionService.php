<?php


namespace App\Services;


use App\Helpers\DataHelper;
use App\ImageFile;
use App\MatrixQuestion;
use App\MatrixQuestionElement;
use App\QuestionGroup;
use App\QuestionOption;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MatrixQuestionService
{

    /**
     * @param QuestionGroup $questionGroup
     * @param MatrixQuestion $question
     * @param Collection $elements
     * @param Collection $options
     * @return array
     */
    public function create(QuestionGroup $questionGroup, MatrixQuestion $question, Collection $elements, Collection $options)
    {
        DB::transaction(function () use ($question, $questionGroup, $elements, $options) {
            $questionGroup->matrixQuestions()->save($question);
            $elements->each(function ($element) use ($question) {
                $question->elements()->save(new MatrixQuestionElement(['title' => $element]));
            });
            $options->each(function ($option) use ($question) {
                $question->options()->save(new QuestionOption(['option' => $option]));
            });
        });
        return DataHelper::creationDataResponse($question);
    }

    /**
     * @param MatrixQuestion $question
     * @param array $data
     * @param bool $deleteFile
     * @param Collection|null $elements
     * @param Collection|null $options
     */
    public function update(MatrixQuestion $question, array $data, bool $deleteFile, Collection $elements = null, Collection $options = null)
    {
        if ($question->icon && $deleteFile) {
            ImageFile::destroy($question->icon);
            $question->icon = null;
        }
        DB::transaction(function () use ($question, $data, $elements, $options) {
            $question->update($data);
            if ($elements) {
                $question->deleteElements();
                $elements->each(function ($element) use ($question) {
                    $question->elements()->save(new MatrixQuestionElement(['title' => $element]));
                });
            }
            if ($options) {
                $question->deleteOptions();
                $options->each(function ($option) use ($question) {
                    $question->options()->save(new QuestionOption(['option' => $option]));
                });
            }
        });
    }

    /**
     * @param MatrixQuestion $question
     * @throws \Exception
     */
    public function delete(MatrixQuestion $question)
    {
        if ($question->icon) {
            ImageFileService::deleteFile($question->icon);
        }
        $question->delete();
    }

}