<?php

namespace App\Http\Middleware;

use Closure;

class InputQuestionMiddleware
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
        $question = $request->route('question');
        if (!$survey->questionGroups->find($questionGroup)->inputQuestions->find($question)) {
            return response()->json(['error' => 'Question not in Question Group'], 422);
        }
        return $next($request);
    }
}
