<?php

namespace App\Http\Middleware;

use Closure;

class OptionInMultiQuestionMiddleware
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
        $question = $request->route('multiQuestion');
        $option = $request->route('option');
        if (!$survey->questionGroups->find($questionGroup)->multiQuestions->find($question)->options->find($option)) {
            return response()->json(['error' => 'Option not in Question'], 422);
        }
        return $next($request);
    }
}
