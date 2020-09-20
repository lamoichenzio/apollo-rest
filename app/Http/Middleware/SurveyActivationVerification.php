<?php

namespace App\Http\Middleware;

use Closure;

class SurveyActivationVerification
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
        if (!$survey->secret) {
            return response()->json(['error' =>
                'The survey is not private and do not need to be published, use update instead'],
                422);
        }
        if ($survey->active) {
            return response()->json(['error' =>
                'The survey has already been published'],
                422);
        }
        if (!$survey->invitationPool) {
            return response()->json(['error' =>
                'There is no email associated to this survey, add some emails before activate it'],
                422);
        }
        return $next($request);
    }
}
