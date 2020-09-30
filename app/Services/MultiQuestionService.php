<?php


namespace App\Services;


use App\Helpers\DataHelper;
use App\ImageFile;
use App\MultiQuestion;
use App\QuestionGroup;
use App\QuestionOption;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MultiQuestionService
{

    /**
     * @param QuestionGroup $group
     * @param MultiQuestion $question
     * @param Collection $options
     * @return array
     */
    public function create(QuestionGroup $group, MultiQuestion $question, Collection $options)
    {
        DB::transaction(function () use ($options, $question, $group) {
            $group->multiQuestions()->save($question);
            $options->each(function ($option) use ($question) {
                $question->options()->save(new QuestionOption(['option' => $option]));
            });
        });
        return DataHelper::creationDataResponse($question);
    }

    public function update(MultiQuestion $question, array $data, bool $deleteFile, Collection $options = null)
    {
        DB::transaction(function () use ($data, $options, $deleteFile, $question) {
            if ($question->icon && $deleteFile) {
                ImageFile::destroy($question->icon);
                $question->id = null;
            }
            if ($options) {
                $question->deleteOptions();
                $options->each(function ($option) use ($question) {
                    $question->options()->save(new QuestionOption(['option' => $option]));
                });
            }
            $question->update($data);
        });
    }

    /**
     * @param MultiQuestion $question
     * @throws \Exception
     */
    public function delete(MultiQuestion $question)
    {
        if ($question->icon) {
            ImageFileService::deleteFile($question->icon);
        }
        $question->delete();
    }

}