<?php

namespace App\Policies;

use App\User;
use App\Player;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlayerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can delete the given player.
     *
     * @param  User  $user
     * @param  Player  $player
     * @return bool
     */
    public function destroy(User $user, Player $player)
    {
        return $user->id === $player->user_id;
    }
}
