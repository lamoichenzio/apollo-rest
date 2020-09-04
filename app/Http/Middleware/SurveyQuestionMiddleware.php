<?php

namespace App\Http\Middleware;

use App\QuestionGroup;
use App\Survey;
use Closure;

class SurveyQuestionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(\Illuminate\Http\Request $request, Closure $next)
    {
        if ($request['survey'] && $request['question_group']) {
            $survey = Survey::find($request['survey']);
            $questionGroup = QuestionGroup::find($request['question_group']);
            dd($survey);
            if (!$survey || !$questionGroup || $survey->id != $questionGroup->survey_id) {
                return response()->json(['error' => 'Question Group not in Survey'],
                    \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
        return $next($request);
    }
}
