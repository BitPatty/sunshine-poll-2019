<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlagHistory extends Model
{
    protected $fillable = [
        'key', 'value', 'modified_by'
    ];

    protected $table = "h_application_flag";

    public static function addEntry(Flag $flag)
    {
        $h = new FlagHistory();
        $h->key = $flag->key;
        $h->value = $flag->value;
        $h->modified_by = $flag->modified_by;
        $h->save();
    }
}
