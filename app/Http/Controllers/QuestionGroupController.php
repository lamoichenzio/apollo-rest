<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionGroupCreationRequest;
use App\Http\Requests\QuestionGroupUpdateRequest;
use App\Http\Resources\QuestionGroupResource;
use App\QuestionGroup;
use App\Services\QuestionGroupService;
use App\Survey;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class QuestionGroupController extends Controller
{

    protected $questionGroupService;

    public function __construct(QuestionGroupService $service)
    {
        $this->questionGroupService = $service;
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Survey $survey
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Survey $survey)
    {
        \request()->validate([
            'pag_size' => 'numeric',
            'title' => 'string',
            'order' => Rule::in(Schema::getColumnListing((new QuestionGroup)->getTable())),
            'order_dir' => Rule::in(['asc', 'desc'])
        ]);

        return QuestionGroupResource::collection($this->questionGroupService->getQuestionGroups(
            $survey, request('pag_size'), request('title'),
            request('order'), request('orderDir'))
        )->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuestionGroupCreationRequest $request
     * @param Survey $survey
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(QuestionGroupCreationRequest $request, Survey $survey)
    {
        $questionGroup = new QuestionGroup($request->all());
        return response()->json(
            $this->questionGroupService->create($survey, $questionGroup),
            201, ['Location' => $questionGroup->path()]);
    }

    /**
     * Display the specified resource.
     *
     * @param Survey $survey
     * @param \App\QuestionGroup $questionGroup
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Survey $survey, QuestionGroup $questionGroup)
    {
        $questionGroup = $survey->questionGroups->find($questionGroup);
        return QuestionGroupResource::make($questionGroup)->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuestionGroupUpdateRequest $request
     * @param Survey $survey
     * @param \App\QuestionGroup $questionGroup
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(QuestionGroupUpdateRequest $request, Survey $survey, QuestionGroup $questionGroup)
    {
        $this->questionGroupService->update($questionGroup, $request->all());
        return response()->json("", 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Survey $survey
     * @param \App\QuestionGroup $questionGroup
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Survey $survey, QuestionGroup $questionGroup)
    {
        $this->authorize('delete', $questionGroup);
        $this->questionGroupService->delete($questionGroup);
        return response()->json("", 204);
    }

    public function listQuestions(Survey $survey, QuestionGroup $questionGroup)
    {
        return \response()->json($questionGroup->questions());
    }
}
