<?php

namespace App\Http\Middleware;

use Closure;

class MultiQuestionMiddleware
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
        $questionGroup = $request->route('question_group');
        $multiQuestion = $request->route('multiQuestion');
        if (!$survey->questionGroups->find($questionGroup)->multiQuestions->find($multiQuestion)) {
            return response()->json(['error' => 'Question not in Question Group'], 422);
        }
        return $next($request);
    }
}
