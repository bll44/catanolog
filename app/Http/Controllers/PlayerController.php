<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use App\User;
use App\Player;
use App\Repositories\MathRepository;
use App\Repositories\PlayerRepository;

class PlayerController extends Controller
{
  /**
  * The player repository instance.
  *
  * @var PlayerRepository
  */
  protected $players;

  /**
  * Create a new controller instance.
  *
  * @param  PlayerRepository  $players
  * @return void
  */
  public function __construct(PlayerRepository $players, MathRepository $math)
  {
    $this->middleware('auth');

    $this->math = $math;
    $this->players = $players;
  }

  /**
  * Display a list of all of the user's player.
  *
  * @param  Request  $request
  * @return Response
  */
  public function index(Request $request)
  {
    $players = $this->players->forUser($request->user());

    return view('players.index', compact('players'));
  }

  /**
  * Create a new player.
  *
  * @param  Request  $request
  * @return Response
  */
  public function store(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|max:255',
    ]);

    $player = new Player;
    $player->user_id = $request->user()->id;
    $player->name = $request->name;
    $player->save();

    return redirect('/players');
  }

  /**
  * Display a specific user's player.
  *
  * @param  Request  $request
  * @return Response
  */
  public function view($name, Request $request)
  {
    $player = $this->players->playerDetails($name, $request->user());

    $player->wins = DB::table('scores')
      ->join('matches', 'scores.match_id', '=', 'matches.id')
      ->where('scores.player_id', '=', $player->id)
      ->havingRaw('scores.victory_points >= matches.maximum_victory_points')
      ->get();

    // for ($i = 3; $i <= 6; $i++) {
    //   $playerCountAllMatches[$i] = DB::table('matches')
    //     ->select(DB::raw('matches.id, count(scores.match_id) as player_count'))
    //     ->leftJoin('scores', 'matches.id', '=', 'scores.match_id')
    //     ->groupBy('matches.id')
    //     ->having('player_count', '=', $i)
    //     ->get();
    // }

    for ($i = 3; $i <= 6; $i++) {
      $scoreCheck[$i] = DB::table('scores')
      ->join('scores as compared', 'scores.match_id', '=', 'compared.match_id')
      ->whereNotNull('compared.match_id')
      ->where('compared.player_id', '=', $player->id)
      ->groupBy('compared.match_id')
      ->havingRaw('COUNT(compared.match_id) = ' . $i)
      ->pluck('compared.victory_points');
    }

    foreach ($scoreCheck as $key => $value) {
      if (count($value)) {

        $scorecard[$key]['match_size'] = $key;

        $decToFraction = $this->math->decToFraction(array_sum($value) / count($value));

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

    // $scorecard = array_chunk(array_filter($scorecard), 2, true);

    // $scorecard = array_chunk($scorecard, 2);
    $scorecard = (isset($scorecard) ? array_chunk($scorecard, 2) : false);

    // return $scorecard;

    return view('players.view', compact('player', 'scorecard'));
  }

  /**
  * Destroy the given player.
  *
  * @param  Request  $request
  * @param  Player  $player
  * @return Response
  */
  public function destroy(Request $request, Player $player)
  {
    $this->authorize('destroy', $player);

    $player->delete();

    return redirect('/players');
  }
}
