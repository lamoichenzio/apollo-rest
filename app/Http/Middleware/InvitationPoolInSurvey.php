<?php

namespace App\Http\Middleware;

use Closure;

class InvitationPoolInSurvey
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
        $survey = request()->route('survey');
        $invitationPool = request()->route('invitationPool');
        if ($survey && $invitationPool && $survey->private && $survey->id != $invitationPool->survey->id) {
            return response()->json(['error' => 'Invitation Pool not in Survey'], 422);
        }
        return $next($request);
    }
}
