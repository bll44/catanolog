<?php

namespace App\Policies;

use App\User;
use App\Match;
use Illuminate\Auth\Access\HandlesAuthorization;

class MatchPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can delete the given match.
     *
     * @param  User  $user
     * @param  Match  $match
     * @return bool
     */
    public function destroy(User $user, Match $match)
    {
        return $user->id === $match->user_id;
    }
}
