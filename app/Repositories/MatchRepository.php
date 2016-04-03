<?php

namespace App\Repositories;

use App\User;
use App\Match;

class MatchRepository
{
  /**
   * Get all of the matches for a given user.
   *
   * @param  User  $user
   * @return Collection
   */
  public function forUser(User $user)
  {
    return Match::where('user_id', $user->id)
      ->orderBy('created_at', 'asc')
      ->get();
  }

  /**
   * Get all of the match details.
   *
   * @param  User  $user
   * @return Collection
   */
  public function matchDetails($id, User $user)
  {
    return Match::where('user_id', $user->id)
      ->where('id', $id)
      ->first();
  }
}
