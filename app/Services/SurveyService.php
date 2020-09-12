<?php


namespace App\Services;


use App\Helpers\DataHelper;
use App\ImageFile;
use App\Mail\SurveyActivation;
use App\Survey;
use Illuminate\Support\Facades\Mail;

class SurveyService
{

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

    public function getSurveys(int $pagSize = null, string $user_id = null, string $name = null,
                               string $order = null, string $orderDir = null)
    {
        $params = [];
        if ($user_id != null) {
            array_push($params, ['user_id', $user_id]);
        }
        if ($name != null) {
            array_push($params, ['name', 'like', '%' . $name . '%']);
        }
        $query = Survey::where($params);
        if ($order != null && $orderDir != null) {
            $query = $query->orderBy($order, $orderDir);
        }
        if ($pagSize) {
            return $query->paginate($pagSize)->withQueryString();
        }
        return $query->get();
    }

    public function activateSurveys(string $start_date, string $end_date)
    {
        Survey
            ::where('start_date', $start_date)
            ->orWhere('end_date', $end_date)
            ->get()->each(
                function ($survey) use ($end_date, $start_date) {
                    if ($survey->start_date->toDateString() == $start_date && !$survey->active) {
                        $survey->update(['active' => true]);
                    } elseif ($survey->end_date->toDateString() == $end_date && $survey->active) {
                        $survey->update(['active' => false]);
                    }
                    Mail::to($survey->user)->send(new SurveyActivation($survey));
                }
            );
    }

}