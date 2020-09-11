<?php

namespace App\Http\Controllers;

use App\Helpers\DataHelper;
use App\MatrixQuestion;
use App\MatrixQuestionElement;
use App\QuestionGroup;
use App\Survey;
use Illuminate\Http\Request;

class MatrixQuestionElementController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Survey $survey
     * @param QuestionGroup $questionGroup
     * @param \App\MatrixQuestion $matrixQuestion
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Survey $survey, QuestionGroup $questionGroup, MatrixQuestion $matrixQuestion)
    {
        $response = $matrixQuestion->elements->map(function ($element) {
            return [
                'id' => $element->id,
                'title' => $element->title
            ];
        });
        return response()->json(DataHelper::listDataResponse($response));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Survey $survey
     * @param QuestionGroup $questionGroup
     * @param \App\MatrixQuestion $matrixQuestion
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Survey $survey, QuestionGroup $questionGroup, MatrixQuestion $matrixQuestion)
    {
        $params = $request->validate([
            'title' => 'required'
        ]);
        $matrixQuestion->elements()->save(new MatrixQuestionElement(['title' => $params['title']]));
        return response()->json(DataHelper::creationDataResponse($matrixQuestion), 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Survey $survey
     * @param QuestionGroup $questionGroup
     * @param \App\MatrixQuestion $matrixQuestion
     * @param MatrixQuestionElement $element
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Survey $survey,
                           QuestionGroup $questionGroup, MatrixQuestion $matrixQuestion, MatrixQuestionElement $element)
    {
        $params = $request->validate([
            'title' => 'required'
        ]);
        $element->update($params);
        return response()->json("", 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Survey $survey
     * @param QuestionGroup $questionGroup
     * @param \App\MatrixQuestion $matrixQuestion
     * @param MatrixQuestionElement $element
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Survey $survey, QuestionGroup $questionGroup,
                            MatrixQuestion $matrixQuestion, MatrixQuestionElement $element)
    {
        $element->delete();
        return response()->json("", 204);
    }
}
