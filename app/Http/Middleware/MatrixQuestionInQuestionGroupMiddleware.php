<?php

namespace App\Http\Middleware;

use Closure;

class MatrixQuestionInQuestionGroupMiddleware
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
        $questionGroup = $request->route('question_group');
        $question = $request->route('matrixQuestion');
        if ($questionGroup && $question && $question->questionGroup->id != $questionGroup->id) {
            return response()->json(['error' => 'Question not in Question Group'], 422);
        }

        return $next($request);
    }
}
