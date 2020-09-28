<?php

namespace App\Policies;

use App\Survey;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SurveyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User $user
     * @param \App\Survey $survey
     * @return mixed
     */
    public function update(User $user, Survey $survey)
    {
        return $survey->user->id === $user->id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User $user
     * @param \App\Survey $survey
     * @return mixed
     */
    public function delete(User $user, Survey $survey)
    {
        return $survey->user->id === $user->id || $user->isAdmin();
    }

    public function publish(User $user, Survey $survey)
    {
        return $survey->user->id === $user->id || $user->isAdmin();
    }

}
