<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use App\User;
use App\Player;
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
  public function __construct(PlayerRepository $players)
  {
    $this->middleware('auth');

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

    $wins = DB::table('scores')
                ->join('matches', 'scores.match_id', '=', 'matches.id')
                ->where('scores.player_id', '=', $player->id)
                ->havingRaw('scores.victory_points >= matches.maximum_victory_points')
                ->get();

    return view('players.view', compact('player', 'wins'));
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
