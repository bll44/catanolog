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
use App\Repositories\MathRepository;
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
  public function __construct(MatchRepository $matches, MathRepository $math, PlayerRepository $players)
  {
    $this->middleware('auth');

    $this->matches = $matches;
    $this->math = $math;
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

    $stats->totalMatches = DB::table('matches')->count();

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

    $stats->avgFractionVP10 = $this->math->decToFraction($stats->avgVP10);

    return view('statistics', compact('stats'));
  }

}
