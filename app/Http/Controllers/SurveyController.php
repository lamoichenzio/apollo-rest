<?php

namespace App\Http\Controllers;

use App\Helpers\DataHelper;
use App\Http\Requests\SurveyCreationRequest;
use App\Http\Requests\SurveyUpdateRequest;
use App\Http\Resources\SurveyResource;
use App\Services\ImageFileService;
use App\Services\SurveyService;
use App\Survey;
use Illuminate\Http\JsonResponse;

class SurveyController extends Controller
{
    protected $surveyService;

    public function __construct(SurveyService $service)
    {
        $this->surveyService = $service;
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $params = request()->validate([
            'pag_size' => 'numeric',
            'user_id' => 'string',
            'name' => 'string',
            'start_date' => 'date',
            'end_date' => 'date'
        ]);

        if (count($params) == 0) {
            $links = Survey::all()->map(function ($survey) {
                return $survey->path();
            });
            return response()->json(DataHelper::listDataResponse($links));
        }

        if ($pagSize = \request('pag_size')) {
            unset($params['pag_size']);
            return SurveyResource::collection(Survey::where($params)->paginate($pagSize))->response();
        }
        return SurveyResource::collection(Survey::where($params)->get())->response();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SurveyCreationRequest $request
     * @return JsonResponse
     */
    public function store(SurveyCreationRequest $request)
    {
        $survey = new Survey($request->all());
        if ($icon = $request['icon']) {
            $icon = ImageFileService::createImageFile($icon);
            $this->surveyService->createSurveyWithIcon($survey, $icon);
        } else {
            $this->surveyService->createSurvey($survey);
        }
        return response()->json(
            DataHelper::creationDataResponse($survey), 201, ['Location' => $survey->path()]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Survey $survey
     * @return JsonResponse
     */
    public function show(Survey $survey)
    {
        return SurveyResource::make($survey)->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SurveyUpdateRequest $request
     * @param Survey $survey
     * @return JsonResponse
     */
    public function update(SurveyUpdateRequest $request, Survey $survey)
    {
        if ($request['icon'] && $request['icon'] != 'delete') {
            $image = ImageFileService::updateImageFile($survey->icon, $request['icon']);
            $survey->icon = $image->id;
        }
        $this->surveyService->updateSurvey($survey, $request->all(), $request['icon'] == 'delete');
        return response()->json("", 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Survey $survey
     * @return JsonResponse
     */
    public function destroy(Survey $survey)
    {
        $this->surveyService->deleteSurvey($survey);
        return response()->json("", 204);
    }

    public function count()
    {
        $params = \request()->validate([
            'user' => 'string',
            'active' => 'boolean'
        ]);
        return Survey::where($params)->count();
    }

}
