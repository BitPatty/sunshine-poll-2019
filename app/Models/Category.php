<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'game_id', 'category_id', 'game_name', 'category_name'
    ];

    protected $table = "t_category";
}
