<?php

namespace App\Http\Controllers;

use App\Http\Requests\questions\MultiQuestionCreationRequest;
use App\Http\Requests\questions\MultiQuestionUpdateRequest;
use App\MultiQuestion;
use App\QuestionGroup;
use App\Survey;

class MultiQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Survey $survey
     * @param \App\QuestionGroup $questionGroup
     * @return void
     */
    public function index(Survey $survey, QuestionGroup $questionGroup)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MultiQuestionCreationRequest $request
     * @param Survey $survey
     * @param \App\QuestionGroup $questionGroup
     * @return void
     */
    public function store(MultiQuestionCreationRequest $request, Survey $survey, QuestionGroup $questionGroup)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\QuestionGroup $questionGroup
     * @param Survey $survey
     * @param \App\MultiQuestion $multiQuestion
     * @return void
     */
    public function show(QuestionGroup $questionGroup, Survey $survey, MultiQuestion $multiQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MultiQuestionUpdateRequest $request
     * @param Survey $survey
     * @param \App\QuestionGroup $questionGroup
     * @param \App\MultiQuestion $multiQuestion
     * @return void
     */
    public function update(MultiQuestionUpdateRequest $request, Survey $survey, QuestionGroup $questionGroup, MultiQuestion $multiQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Survey $survey
     * @param \App\QuestionGroup $questionGroup
     * @param \App\MultiQuestion $multiQuestion
     * @return void
     */
    public function destroy(Survey $survey, QuestionGroup $questionGroup, MultiQuestion $multiQuestion)
    {
        //
    }
}
