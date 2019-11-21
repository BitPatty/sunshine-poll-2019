<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
  protected $fillable = [
    'src_id',
    'src_name',
    'has_voted',
    'custom_run_url',
    'v_hide_timings',
    'v_option_a',
    'v_option_b',
    'v_option_c',
    'v_option_d',
    'v_option_e',
    'comment',
    'has_voted',
    'has_src_run',
    'is_verified'
  ];
  protected $table = 't_vote';
  protected $primaryKey = 'id';
}
