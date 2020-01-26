<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
    public function modifiedBy()
    {
        return $this->belongsTo(User::class, 'modified_by', 'id');
    }


    protected $fillable = [
        'key', 'value', 'last_modified_by'
    ];

    protected $table = "t_application_flag";

    public function getValueAttribute()
    {
        return $this->attributes['value'] ? true : false;
    }

    public static function getByKey(string $key)
    {
        return Flag::where(['key' => $key])->first();
    }
}
