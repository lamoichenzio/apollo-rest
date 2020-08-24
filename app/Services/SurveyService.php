<?php


namespace App\Services;


use App\Helpers\DataHelper;
use App\ImageFile;
use App\Survey;

class SurveyService
{
    public function createSurveyWithIcon(Survey $survey, ImageFile $file)
    {
        $file->save();
        $survey->icon = $file->id;
        return $this->createSurvey($survey);
    }

    public function createSurvey(Survey $survey)
    {
        auth()->user()->surveys()->save($survey);
        return DataHelper::creationDataResponse($survey);
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

    public function count(array $params = null)
    {
        return [
            "count" => Survey::where($params)->count()
        ];
    }

    public function getSurveyLinks()
    {
        $links = Survey::all()->map(function ($survey) {
            return $survey->path();
        });
        return DataHelper::listDataResponse($links);
    }

    public function getSurveys(int $pagSize = null, string $user_id = null, string $name = null)
    {
        $params = [];
        if ($user_id != null) {
            array_push($params, ['user_id', $user_id]);
        }
        if ($name != null) {
            array_push($params, ['name', 'like', '%' . $name . '%']);
        }
        $query = Survey::where($params);
        if ($pagSize) {
            return $query->paginate($pagSize);
        }
        return $query->get();
    }

}