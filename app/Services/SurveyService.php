<?php


namespace App\Services;


use App\ImageFile;
use App\Survey;

class SurveyService
{
    public function createSurveyWithIcon(Survey $survey, ImageFile $file)
    {
        $file->save();
        $survey->icon = $file->id;
        $this->createSurvey($survey);
    }

    public function createSurvey(Survey $survey)
    {
        auth()->user()->surveys()->save($survey);
    }

    public function updateSurvey(Survey $survey, $data, bool $deleteFile)
    {
        if ($deleteFile && $survey->icon) {
            ImageFile::destroy($survey->icon);
            $survey->icon = null;
        }
        $survey->update($data);
    }

    public function deleteSurvey(Survey $survey)
    {
        if ($survey->icon) {
            ImageFile::destroy($survey->icon);
        }
        $survey->delete();
    }
}