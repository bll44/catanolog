<?php

namespace App;

use App\User;
use App\Score;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['maximum_victory_points'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'int',
    ];

    /**
     * Get the user that owns the match.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the scores for a match.
     */
    public function scores()
    {
        return $this->hasMany(Score::class)->orderBy('victory_points', 'desc');
    }

    public function photo()
    {
        return $this->hasOne(Photo::class);
    }
}
