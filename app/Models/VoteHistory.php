<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoteHistory extends Model
{
    public function vote()
    {
        return $this->belongsTo(Vote::class, 'vote_id', 'id');
    }

    protected $fillable = [
        'custom_run_url',
        'v_timing_method_a',
        'v_timing_method_b',
        'v_timing_method_c',
        'v_timing_method_d',
        'v_hide_timings',
    ];

    protected $table = "h_vote";

    public static function addEntry(Vote $vote)
    {
        $entry = new VoteHistory();
        $entry->vote_id = $vote->id;
        $entry->v_timing_method_a = $vote->v_timing_method_a;
        $entry->v_timing_method_b = $vote->v_timing_method_b;
        $entry->v_timing_method_c = $vote->v_timing_method_c;
        $entry->v_timing_method_d = $vote->v_timing_method_d;
        $entry->v_hide_timings = $vote->v_hide_timings;
        $entry->custom_run_url = $vote->custom_run_url;
        $entry->state = $vote->state;
        $entry->comment = $vote->comment;
        $entry->save();
    }
}
