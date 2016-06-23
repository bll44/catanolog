<?php

namespace App\Repositories;

use App\User;
use App\Match;
use DB;

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
      ->orderBy('id', 'desc')
      // ->get();
      ->simplePaginate(10);
  }

  public function all()
  {
    return Match::orderBy('id', 'desc')->simplePaginate(10);
  }

  /**
   * Get all of the match details.
   *
   * @param  User  $user
   * @return Collection
   */
  public function matchDetails($id, User $user)
  {
    // return Match::where('user_id', $user->id)
    //   ->where('id', $id)
    //   ->first();
    return Match::where('id', $id)
      ->first();
  }

}
