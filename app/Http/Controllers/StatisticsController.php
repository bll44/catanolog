<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use App\Match;
use App\Player;
use App\Score;
use App\Repositories\MatchRepository;
use App\Repositories\PlayerRepository;

class StatisticsController extends Controller
{
  /**
  * The match repository instance.
  *
  * @var MatchRepository
  */
  protected $matches;
  protected $players;

  /**
  * Create a new controller instance.
  *
  * @param  MatchRepository  $matches
  * @return void
  */
  public function __construct(MatchRepository $matches, PlayerRepository $players)
  {
    $this->middleware('auth');

    $this->matches = $matches;
    $this->players = $players;
  }

  /**
  * Display a list of all of the user's match.
  *
  * @param  Request  $request
  * @return Response
  */
  public function index(Request $request)
  {
    $stats = new \stdClass;

    $stats->mostPlayed = DB::table('scores')
                ->join('players', 'players.id', '=', 'scores.player_id')
                ->select(DB::raw('players.name AS Player_Most_Games, count(scores.match_id) AS Most_Games_Played'))
                ->groupBy('Player_Most_Games')
                ->orderBy('Most_Games_Played', 'desc')
                ->take(6)
                ->get();

    $stats->mostVP = DB::table('scores')
                ->join('players', 'players.id', '=', 'scores.player_id')
                ->select(DB::raw('players.name AS Player_Most_Vp, sum(scores.victory_points) AS Most_Total_Vp'))
                ->groupBy('Player_Most_Vp')
                ->orderBy('Most_Total_Vp', 'desc')
                ->take(6)
                ->get();

    $stats->avgVP10 = DB::table('scores')
                ->join('matches', 'matches.id', '=', 'scores.match_id')
                ->where('matches.maximum_victory_points', '=', 10)
                ->avg('victory_points');

    // dd($stats->avgVP10);

    $stats->avgFractionVP10 = $this->decToFraction($stats->avgVP10);

    return view('statistics', compact('stats'));
  }

  public function decToFraction($float) {
    // 1/2, 1/4, 1/8, 1/16, 1/3 ,2/3, 3/4, 3/8, 5/8, 7/8, 3/16, 5/16, 7/16,
    // 9/16, 11/16, 13/16, 15/16
    $whole = floor ( $float );
    $decimal = $float - $whole;
    $leastCommonDenom = 48; // 16 * 3;
    $denominators = array (2, 3, 4, 8, 16, 24, 48 );
    $roundedDecimal = round ( $decimal * $leastCommonDenom ) / $leastCommonDenom;

    if ($roundedDecimal == 0)
      return $whole;

    if ($roundedDecimal == 1)
      return $whole + 1;

    foreach ( $denominators as $d ) {
      if ($roundedDecimal * $d == floor ( $roundedDecimal * $d )) {
        $denom = $d;
        break;
      }
    }
    return ($whole == 0 ? '' : $whole) . " " . ($roundedDecimal * $denom) . "/" . $denom;
  }

}
