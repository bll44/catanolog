<?php

namespace App\Repositories;

use App\User;
use App\Player;

class PlayerRepository
{
    /**
     * Get all of the players for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function forUser(User $user)
    {
      return Player::where('user_id', $user->id)
        ->orderBy('created_at', 'asc')
        ->get();
    }

    /**
     * Get all of the player details.
     *
     * @param  User  $user
     * @return Collection
     */
    public function playerDetails($name, User $user)
    {
      return Player::where('user_id', $user->id)
        ->where('name', $name)
        ->first();
    }

}
