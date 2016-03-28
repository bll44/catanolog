<?php

namespace App;

use App\Match;
use App\Player;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get all of the matches for the acount.
     */
    public function matches()
    {
        return $this->hasMany(Match::class);
    }

    /**
     * Get all of the players for the account.
     */
    public function players()
    {
        return $this->hasMany(Player::class);
    }
}
