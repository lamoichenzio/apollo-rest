<?php

namespace App\Http\Controllers;

use App\Helpers\DataHelper;
use App\Http\Requests\questions\MultiQuestionCreationRequest;
use App\Http\Requests\questions\MultiQuestionUpdateRequest;
use App\Http\Resources\questions\MultiQuestionResource;
use App\MultiQuestion;
use App\QuestionGroup;
use App\QuestionOption;
use App\Services\ImageFileService;
use App\Services\MultiQuestionService;
use App\Survey;
use Illuminate\Http\Request;

class MultiQuestionController extends Controller
{
    protected $service;

    public function __construct(MultiQuestionService $questionService)
    {
        $this->service = $questionService;
        $this->middleware('auth:api');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MultiQuestionCreationRequest $request
     * @param Survey $survey
     * @param \App\QuestionGroup $questionGroup
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MultiQuestionCreationRequest $request, Survey $survey, QuestionGroup $questionGroup)
    {
        $questionGroup = $survey->questionGroups->find($questionGroup);
        $question = new MultiQuestion($request->all());
        if ($icon = $request['icon']) {
            $icon = ImageFileService::createImageFile($request['icon']);
            $question->icon = $icon->id;
        }
        $response = $this->service->create($questionGroup, $question, collect($request['options']));
        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\QuestionGroup $questionGroup
     * @param Survey $survey
     * @param \App\MultiQuestion $multiQuestion
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Survey $survey, QuestionGroup $questionGroup, MultiQuestion $multiQuestion)
    {
        return MultiQuestionResource::make($multiQuestion)->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MultiQuestionUpdateRequest $request
     * @param Survey $survey
     * @param \App\QuestionGroup $questionGroup
     * @param \App\MultiQuestion $multiQuestion
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MultiQuestionUpdateRequest $request, Survey $survey, QuestionGroup $questionGroup, MultiQuestion $multiQuestion)
    {
        if ($icon = $request['icon'] && $request['icon'] != 'delete') {
            $icon = ImageFileService::updateImageFile($multiQuestion->icon, $request['icon']);
            $multiQuestion->icon = $icon->id;
        }
        $this->service->update($multiQuestion, $request->all(),
            $request['icon'] == 'delete', collect($request['options']));
        return response()->json("", 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Survey $survey
     * @param \App\QuestionGroup $questionGroup
     * @param \App\MultiQuestion $multiQuestion
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Survey $survey, QuestionGroup $questionGroup, MultiQuestion $multiQuestion)
    {
        $this->authorize('delete', $multiQuestion);
        $this->service->delete($multiQuestion);
        return response()->json("", 204);
    }

    /**
     * @param Survey $survey
     * @param QuestionGroup $questionGroup
     * @param MultiQuestion $multiQuestion
     * @return \Illuminate\Http\JsonResponse
     */
    public function listOptions(Survey $survey, QuestionGroup $questionGroup, MultiQuestion $multiQuestion)
    {
        $message = $multiQuestion->options->map(function ($option) {
            return [
                'id' => $option->id,
                'option' => $option->option
            ];
        });
        return response()->json(DataHelper::listDataResponse($message));
    }

    /**
     * @param Request $request
     * @param Survey $survey
     * @param QuestionGroup $questionGroup
     * @param MultiQuestion $multiQuestion
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function storeOption(Request $request, Survey $survey, QuestionGroup $questionGroup, MultiQuestion $multiQuestion)
    {
        $this->authorize('create', QuestionOption::class);
        $request->validate([
            'option' => 'required'
        ]);
        $multiQuestion->options()->save(new QuestionOption(['option' => $request['option']]));
        return response()->json(DataHelper::creationDataResponse($multiQuestion), 201);
    }

    /**
     * @param Request $request
     * @param Survey $survey
     * @param QuestionGroup $questionGroup
     * @param MultiQuestion $multiQuestion
     * @param QuestionOption $option
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateOption(Request $request, Survey $survey, QuestionGroup $questionGroup, MultiQuestion $multiQuestion, QuestionOption $option)
    {
        $this->authorize('update', $option);
        $request->validate([
            'option' => 'required'
        ]);
        $option->update(['option' => $request['option']]);
        return response()->json("", 204);
    }

    /**
     * @param Survey $survey
     * @param QuestionGroup $questionGroup
     * @param MultiQuestion $multiQuestion
     * @param QuestionOption $option
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroyOption(Survey $survey, QuestionGroup $questionGroup, MultiQuestion $multiQuestion, QuestionOption $option)
    {
        $this->authorize('delete', $option);
        $option->delete();
        return response()->json("", 204);
    }
}
