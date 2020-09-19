<?php

namespace App\Http\Middleware;

use Closure;

class AnswerInSurvey
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $survey = $request->route('survey');
        $answer = $request->route('surveyAnswer');
        if ($survey && $answer && $answer->survey->id != $survey->id) {
            return response()->json(['error' => 'Answers not belonging to Survey'], 422);
        }
        return $next($request);
    }
}
