<?php

namespace App\Http\Middleware;

use Closure;

class EmailInInvitationPool
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
        $email = $request->route('email');
        $invitationPool = $request->route('invitationPool');
        if ($email && $invitationPool && $email->invitationPool->id != $invitationPool->id) {
            return response()->json(['error' => 'Email not in Invitation Pool'], 422);
        }

        return $next($request);
    }
}
