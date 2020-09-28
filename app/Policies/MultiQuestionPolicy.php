<?php

namespace App\Policies;

use App\MultiQuestion;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MultiQuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        $survey = request()->route('survey');
        return $survey && $survey->user->id === $user->id || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User $user
     * @param \App\MultiQuestion $multiQuestion
     * @return mixed
     */
    public function update(User $user, MultiQuestion $multiQuestion)
    {
        return $multiQuestion->questionGroup->survey->user->id == $user->id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User $user
     * @param \App\MultiQuestion $multiQuestion
     * @return mixed
     */
    public function delete(User $user, MultiQuestion $multiQuestion)
    {
        return $multiQuestion->questionGroup->survey->user->id == $user->id || $user->isAdmin();
    }

}
