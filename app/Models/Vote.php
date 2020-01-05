<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected $fillable = [
        'user_id',
        'custom_run_url',
        'v_timing_method_a',
        'v_timing_method_b',
        'v_timing_method_c',
        'v_timing_method_d',
        'v_hide_timings',
        'state'
    ];

    protected $table = "t_vote";
}
