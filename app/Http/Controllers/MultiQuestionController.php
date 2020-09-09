<?php

namespace App\Http\Controllers;

use App\Http\Requests\questions\MultiQuestionCreationRequest;
use App\Http\Requests\questions\MultiQuestionUpdateRequest;
use App\Http\Resources\questions\MultiQuestionResource;
use App\MultiQuestion;
use App\QuestionGroup;
use App\Services\ImageFileService;
use App\Services\MultiQuestionService;
use App\Survey;

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
        $question = $survey->questionGroups->find($questionGroup)->multiQuestions->find($multiQuestion);
        if ($question) {
            return MultiQuestionResource::make($question)->response();
        }
        return response()->json(['error' => 'Resource not found'], 404);
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
        $question = $survey->questionGroups->find($questionGroup)->multiQuestions->find($multiQuestion);
        if ($question) {
            if ($icon = $request['icon'] && $request['icon'] != 'delete') {
                $icon = ImageFileService::updateImageFile($question->icon, $request['icon']);
                $question->icon = $icon->id;
            }
            $this->service->update(
                $question, $request->all(), $request['icon'] == 'delete', collect($request['options']));
            return response()->json("", 204);
        }
        return response()->json(["error" => "Question not found"], 404);
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
        $question = $survey->questionGroups->find($questionGroup)->multiQuestions->find($multiQuestion);
        $this->authorize('delete', $question);
        if ($question) {
            $this->service->delete($question);
            return response()->json("", 204);
        }
        return response()->json(["error" => "Question not found"], 404);
    }
}
