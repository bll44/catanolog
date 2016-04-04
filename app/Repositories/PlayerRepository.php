<?php

namespace App\Repositories;

use App\User;
use App\Player;
use App\Score;
use App\Repositories\MathRepository;

class PlayerRepository
{
  /**
  * The math repository instance.
  *
  * @var MathRepository
  */
  protected $math;

  /**
  * Create a new controller instance.
  *
  * @param  MathRepository $math
  * @return void
  */
  public function __construct(MathRepository $math)
  {
    $this->math = $math;
  }

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
      // ->get();
      ->simplePaginate(10);
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

  /**
   * Get the player scorecard.
   *
   * @param  $player
   * @return Collection
   */
  public function playerScorecard($player)
  {
    for ($i = 3; $i <= 6; $i++) {
      $scoreCheck[$i] = Score::join('scores as compared', 'scores.match_id', '=', 'compared.match_id')
      ->whereNotNull('compared.match_id')
      ->where('compared.player_id', '=', $player->id)
      ->groupBy('compared.match_id')
      ->havingRaw('COUNT(compared.match_id) = ' . $i)
      ->pluck('compared.victory_points');
    }

    foreach ($scoreCheck as $key => $value) {

      if (count($value)) {

        $scorecard[$key]['match_size'] = $key;

        $decToFraction = $this->math->decToFraction(array_sum($value->toArray()) / count($value));

        if (strstr($decToFraction, '/')) {

          $pieces = explode(" ", $decToFraction);
          $fraction_pieces = explode("/", $pieces[1]);

          $scorecard[$key]['average_score']['whole'] = $pieces[0];;
          $scorecard[$key]['average_score']['numerator'] = $fraction_pieces[0];
          $scorecard[$key]['average_score']['denominator'] = $fraction_pieces[1];

        } else {

          $scorecard[$key]['average_score'] = $decToFraction;

        }
      }
    }

    return $scorecard = (isset($scorecard) ? array_chunk($scorecard, 2) : false);
  }

  /**
   * Get the wins of the player.
   *
   * @param  $player
   * @return Collection
   */
  public function playerWins($player)
  {
    return Score::join('matches', 'scores.match_id', '=', 'matches.id')
      ->where('scores.player_id', '=', $player->id)
      ->havingRaw('scores.victory_points >= matches.maximum_victory_points')
      ->get();
  }

}
