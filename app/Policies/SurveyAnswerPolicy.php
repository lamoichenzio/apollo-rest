<?php

namespace App\Policies;

use App\SurveyAnswer;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SurveyAnswerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $survey = request()->route('survey');
        return $survey && ($survey->user->id == $user->id || $user->isAdmin());
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\User $user
     * @param \App\SurveyAnswer $surveyAnswer
     * @return mixed
     */
    public function view(User $user, SurveyAnswer $surveyAnswer)
    {
        $survey = request()->route('survey');
        return $survey && ($survey->user->id == $user->id || $user->isAdmin());
    }

}
