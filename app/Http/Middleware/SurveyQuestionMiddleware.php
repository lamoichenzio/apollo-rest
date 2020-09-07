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
        if ($request['survey'] && $request['question_group']) {
            if ($request['survey']->id != $request['question_group']->survey_id) {
                return response()->json(['error' => 'Question Group not in Survey'],
                    \Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return $next($request);
    }
}
