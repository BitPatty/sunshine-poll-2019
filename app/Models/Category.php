<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $fillable = [
    'src_id',
    'src_name',
    'src_game_id',
    'src_game_name'
  ];
  protected $table = 't_category';
  protected $primaryKey = 'id';
}
