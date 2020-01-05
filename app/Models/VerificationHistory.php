<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationHistory extends Model
{
    public function vote()
    {
        return $this->belongsTo(Vote::class, 'vote_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected $fillable = [
        'vote_id',
        'user_id',
        'prev_state',
        'new_state',
    ];

    protected $table = "h_verification";

    public static function addEntry(Vote $vote, User $user)
    {
        $entry = new VerificationHistory();
        $entry->state = $vote->state;
        $entry->user_id = $user->id;
        $entry->vote_id = $vote->id;
        $entry->save();
    }
}
