<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use DB;
use App\Match;
use App\Player;
use App\Score;
use App\Repositories\MatchRepository;
use App\Repositories\PlayerRepository;
use App\Photo;

class MatchController extends Controller
{
  /**
  * The match repository instance.
  *
  * @var MatchRepository
  */
  protected $matches;

  /**
  * The player repository instance.
  *
  * @var PlayerRepository
  */
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
  	$matches = $this->matches->forUser($request->user());

  	return view('matches.index', compact('matches'));
  }

  /**
  * Begin creating a new match.
  *
  * @param  Request  $request
  * @return Response
  */
  public function store(Request $request)
  {
  	$this->validate($request, [
  		'maximum_victory_points' => 'required|numeric',
  		'total_players' => 'required|numeric|between:3,6',
  		]);

  	$players = $this->players->forUser($request->user());

  	return view('matches.create_player_details', compact('players', 'request'));
  }

  /**
  * Complete creating a new match.
  *
  * @param  Request  $request
  * @return Response
  */
  public function storeComplete(Request $request)
  {

  	$this->validate($request, [
  		'maximum_victory_points' => 'required|numeric',
  		]);

  	$match = $request->user()->matches()->create([
  		'maximum_victory_points' => $request->maximum_victory_points,
  		]);

  	for ($i = 0; $i < $request->total_players; $i++)
  	{
  		$score = new Score;
  		$score->victory_points = $request->player_score[$i];
  		$score->player_id = $request->player[$i];
  		$score->color = $request->color[$i];
  		$score->match_id = $match->id;
  		$score->save();
  	}

    // uploaded photo of Catan final board
    // check that a file (photo) has been included as well as if it's valid
  	if($request->hasFile('match_photo') 
  		&& $request->file('match_photo')->isValid())
  	{
  		$photo = new Photo($request->file('match_photo'));
  		$photo->setAttributes($match);
  		$photo->moveFile();
      $photo->save();
  		// $photo->create([
  		// 	'match_id' => $photo->match_id,
  		// 	'filename' => $photo->filename,
    //     'url' => $photo->url
  		// 	]);
  	}

  	return redirect('/matches');
  }

  /**
  * Display a specific user's match.
  *
  * @param  $id, Request  $request
  * @return Response
  */
  public function view($id, Request $request)
  {
  	$match = $this->matches->matchDetails($id, $request->user());
    if(is_null($match)) return redirect('/matches');

  	return view('matches.view', compact('match'));
  }

  /**
  * Destroy the given match.
  *
  * @param  Request  $request, Match  $match
  * @return Response
  */
  public function destroy(Request $request, Match $match)
  {
  	$this->authorize('destroy', $match);

  	$match->delete();
    if($match->photo->removeFile()) $match->photo->delete();

  	return redirect('/matches');
  }
}
