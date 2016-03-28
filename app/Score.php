<?php

namespace App;

use App\Match;
use App\Player;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = ['victory_points', 'player_id', 'match_id'];

    public function match()
    {
      return $this->belongsTo(Match::class);
    }

    public function player()
    {
      return $this->belongsTo(Player::class);
    }
}
