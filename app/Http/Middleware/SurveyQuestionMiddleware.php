<?php

namespace App\Http\Middleware;

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
        $survey = $request->route('survey');
        $questionGroup = $request->route('question_group');
        if ($survey && $questionGroup && $survey->id != $questionGroup->survey_id) {
            return response()->json(['error' => 'Question Group not in Survey'],
                \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $next($request);
    }
}
