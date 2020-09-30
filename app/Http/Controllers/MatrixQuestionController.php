<?php

namespace App\Http\Controllers;

use App\Http\Requests\questions\MatrixQuestionCreationRequest;
use App\Http\Requests\questions\MatrixQuestionUpdateRequest;
use App\Http\Resources\questions\MatrixQuestionResource;
use App\MatrixQuestion;
use App\QuestionGroup;
use App\Services\ImageFileService;
use App\Services\MatrixQuestionService;
use App\Survey;

class MatrixQuestionController extends Controller
{

    protected $service;

    public function __construct(MatrixQuestionService $service)
    {
        $this->service = $service;
        $this->middleware('auth:api');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MatrixQuestionCreationRequest $request
     * @param Survey $survey
     * @param \App\QuestionGroup $questionGroup
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MatrixQuestionCreationRequest $request, Survey $survey, QuestionGroup $questionGroup)
    {
        $question = new MatrixQuestion($request->all());
        if ($icon = $request['icon']) {
            $icon = ImageFileService::createImageFile($icon);
            $question->icon = $icon->id;
        }
        $data = $this->service->create($questionGroup, $question,
            collect($request['elements']), collect($request['options']));
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Survey $survey
     * @param \App\QuestionGroup $questionGroup
     * @param \App\MatrixQuestion $matrixQuestion
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Survey $survey, QuestionGroup $questionGroup, MatrixQuestion $matrixQuestion)
    {
        return MatrixQuestionResource::make($matrixQuestion)->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MatrixQuestionUpdateRequest $request
     * @param Survey $survey
     * @param \App\QuestionGroup $questionGroup
     * @param \App\MatrixQuestion $matrixQuestion
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MatrixQuestionUpdateRequest $request, Survey $survey, QuestionGroup $questionGroup, MatrixQuestion $matrixQuestion)
    {
        if ($icon = $request['icon'] && $request['icon'] != 'delete') {
            $icon = ImageFileService::updateImageFile($matrixQuestion->icon, $request['icon']);
            $matrixQuestion->icon = $icon->id;
        }
        $this->service->update($matrixQuestion, $request->all(),
            $request['icon'] == 'delete', collect($request['elements']), collect($request['options']));
        return response()->json("", 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Survey $survey
     * @param \App\QuestionGroup $questionGroup
     * @param \App\MatrixQuestion $matrixQuestion
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Survey $survey, QuestionGroup $questionGroup, MatrixQuestion $matrixQuestion)
    {
        $this->authorize('delete', $matrixQuestion);
        $this->service->delete($matrixQuestion);
        return response()->json("", 204);
    }
}
