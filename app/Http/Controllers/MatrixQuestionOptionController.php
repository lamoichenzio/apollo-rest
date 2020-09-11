<?php

namespace App\Http\Controllers;

use App\Helpers\DataHelper;
use App\MatrixQuestion;
use App\QuestionGroup;
use App\QuestionOption;
use App\Survey;
use Illuminate\Http\Request;

class MatrixQuestionOptionController extends Controller
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
        $options = $matrixQuestion->options->map(function ($option) {
            return [
                'id' => $option->id,
                'option' => $option->option
            ];
        });
        return response()->json(DataHelper::listDataResponse($options));
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
        $request->validate([
            'option' => 'required'
        ]);
        $matrixQuestion->options()->save(new QuestionOption(['option' => $request['option']]));
        return response()->json(DataHelper::creationDataResponse($matrixQuestion), 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Survey $survey
     * @param QuestionGroup $questionGroup
     * @param \App\MatrixQuestion $matrixQuestion
     * @param QuestionOption $option
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Survey $survey, QuestionGroup $questionGroup, MatrixQuestion $matrixQuestion, QuestionOption $option)
    {
        $request->validate([
            'option' => 'required'
        ]);
        $option->update(['option' => $request['option']]);
        return response()->json("", 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Survey $survey
     * @param QuestionGroup $questionGroup
     * @param \App\MatrixQuestion $matrixQuestion
     * @param QuestionOption $option
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Survey $survey, QuestionGroup $questionGroup, MatrixQuestion $matrixQuestion, QuestionOption $option)
    {
        $option->delete();
        return response()->json("", 204);
    }
}
