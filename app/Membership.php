<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
        'type', 
        'begin',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($membership)
        {
            $membership->languages()->detach();
        });
    }

    public function languages()
    {
        return $this->belongsToMany(\App\Language::class);
    }
}
