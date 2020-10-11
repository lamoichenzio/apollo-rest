<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurveyCreationRequest;
use App\Http\Requests\SurveyUpdateRequest;
use App\Http\Resources\SurveyResource;
use App\Services\ImageFileService;
use App\Services\SurveyService;
use App\Survey;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

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
            'end_date' => 'date',
            'order' => Rule::in(Schema::getColumnListing((new Survey)->getTable())),
            'order_dir' => Rule::in(['asc', 'desc'])
        ]);

        if (count($params) == 0) {
            return response()->json($this->surveyService->getSurveyLinks());
        }

        return SurveyResource::collection($this->surveyService->getSurveys(
            request('pag_size'), request('user_id'), request('name'),
            request('order'), request('order_dir')))->response();
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
        $survey->start_date = request('startDate');
        $survey->end_date = request('endDate');
        $survey->url_id = uniqid();

        //Create icon
        if ($icon = $request['icon']) {
            $icon = ImageFileService::createImageFile($icon);
            $survey->icon = $icon->id;
        }
        $data = $this->surveyService->createSurvey($survey);
        return response()->json(
            $data, 201, ['Location' => $survey->path()]
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
        //UPDATE ICON
        if ($request['icon'] && $request['icon'] != 'delete') {
            $image = ImageFileService::updateImageFile($survey->icon, $request['icon']);
            $survey->icon = $image->id;
        }

        //DEACTIVATE SURVEY IF NEEDED
        if ($request->has('active') && $request['active'] == false) {
            $survey->active = false;
        }
        if ($request->has('startDate')) {
            $survey->start_date = $request['startDate'];
        }
        if ($request->has('endDate')) {
            $survey->end_date = $request['endDate'];
        }

        $this->surveyService->updateSurvey($survey, $request->all(), $request['icon'] == 'delete');
        return response()->json("", 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Survey $survey
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Survey $survey)
    {
        $this->authorize('delete', $survey);
        $this->surveyService->deleteSurvey($survey);
        return response()->json("", 204);
    }

    /**
     * Return the number of surveys stored
     * @return JsonResponse
     */
    public function count()
    {
        $params = \request()->validate([
            'user_id' => 'string',
            'active' => 'boolean'
        ]);

        return response()->json(
            $this->surveyService->count($params)
        );
    }

    /**
     * Publish a private survey and sends email to the invitation pool
     * @param Request $request
     * @param Survey $survey
     * @return JsonResponse
     */
    public function publish(Request $request, Survey $survey)
    {
        $request->validate([
            'surveyUrl' => 'string|url|' . Rule::requiredIf(function () use ($survey) {
                    return $survey->secret;
                })
        ]);
        $this->surveyService->publish($survey, $request['surveyUrl']);
        return response()->json(['message' => 'Survey published']);
    }

}
