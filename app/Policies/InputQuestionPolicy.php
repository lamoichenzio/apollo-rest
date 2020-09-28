<?php

namespace App\Policies;

use App\InputQuestion;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InputQuestionPolicy
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
     * @param InputQuestion $inputQuestion
     * @return mixed
     */
    public function update(User $user, InputQuestion $inputQuestion)
    {
        return $inputQuestion &&
            ($inputQuestion->questionGroup->survey->user->id == $user->id || $user->isAdmin());
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User $user
     * @param InputQuestion $inputQuestion
     * @return mixed
     */
    public function delete(User $user, InputQuestion $inputQuestion)
    {
        return $inputQuestion &&
            ($inputQuestion->questionGroup->survey->user->id == $user->id || $user->isAdmin());
    }
}
