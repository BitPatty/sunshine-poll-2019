<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Run extends Model
{
  protected $fillable = [
    'src_id',
    'fk_t_vote',
    'fk_t_category',
    'personal_best',
    'run_date'
  ];

  protected $table = 't_run';
  protected $primaryKey = 'id';
}
