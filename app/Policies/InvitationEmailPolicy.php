<?php

namespace App\Policies;

use App\InvitationEmail;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitationEmailPolicy
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
        return $survey && ($survey->user->id == $user->id || $user->isAdmin());
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User $user
     * @param \App\InvitationEmail $invitationEmail
     * @return mixed
     */
    public function update(User $user, InvitationEmail $invitationEmail)
    {
        $survey = request()->route('survey');
        return $survey && ($survey->user->id == $user->id || $user->isAdmin());
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User $user
     * @param \App\InvitationEmail $invitationEmail
     * @return mixed
     */
    public function delete(User $user, InvitationEmail $invitationEmail)
    {
        $survey = request()->route('survey');
        return $survey && ($survey->user->id == $user->id || $user->isAdmin());
    }

}
