<?php

namespace App\Http\Middleware;

use Closure;

class ElementInMatrixQuestionMiddleware
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
        $element = $request->route('element');
        $question = $request->route('matrixQuestion');
        $option = $request->route('option');
        if (($element && $question && $element->matrixQuestion->id != $question->id)
            || ($question && $option && $option->question->id != $question->id)) {
            return response()->json(['error' => 'Element not in Matrix Question'], 422);
        }
        return $next($request);
    }
}
