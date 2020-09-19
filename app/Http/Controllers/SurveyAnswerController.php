<?php

namespace App\Http\Controllers;

use App\Survey;
use App\SurveyAnswer;
use Illuminate\Http\Request;

class SurveyAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function index(Survey $survey)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Survey $survey)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Survey  $survey
     * @param  \App\SurveyAnswer  $surveyAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey, SurveyAnswer $surveyAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Survey  $survey
     * @param  \App\SurveyAnswer  $surveyAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Survey $survey, SurveyAnswer $surveyAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Survey  $survey
     * @param  \App\SurveyAnswer  $surveyAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey, SurveyAnswer $surveyAnswer)
    {
        //
    }
}
