<?php

namespace App\Policies;

use App\MatrixQuestion;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MatrixQuestionPolicy
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
        return $survey->user->id == $user->id || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User $user
     * @param \App\MatrixQuestion $matrixQuestion
     * @return mixed
     */
    public function update(User $user, MatrixQuestion $matrixQuestion)
    {
        $survey = request()->route('survey');
        return $survey->user->id == $user->id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User $user
     * @param \App\MatrixQuestion $matrixQuestion
     * @return mixed
     */
    public function delete(User $user, MatrixQuestion $matrixQuestion)
    {
        $survey = request()->route('survey');
        return $survey->user->id == $user->id || $user->isAdmin();
    }

}
