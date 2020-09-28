<?php


namespace App\Services;


use App\Helpers\DataHelper;
use App\ImageFile;
use App\InputQuestion;
use App\QuestionGroup;

class InputQuestionService
{

    /**
     * @param QuestionGroup $group
     * @param InputQuestion $question
     * @return array
     */
    public function create(QuestionGroup $group, InputQuestion $question)
    {
        $group->inputQuestions()->save($question);
        return DataHelper::creationDataResponse($question);
    }

    /**
     * @param InputQuestion $question
     * @param array $data
     * @param bool $deleteFile
     */
    public function update(InputQuestion $question, array $data, bool $deleteFile)
    {
        if ($deleteFile && $question->icon) {
            ImageFile::destroy($question->icon);
            $question->icon = null;
        }
        $question->update($data);
    }

    /**
     * @param InputQuestion $question
     * @throws \Exception
     */
    public function delete(InputQuestion $question)
    {
        if ($question->icon) {
            ImageFile::destroy($question->icon);
        }
        $question->delete();
    }

}