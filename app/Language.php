<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'code',
    ];

    public function __toString()
    {
        return sprintf('Language "%s"', $this->title);
    }

    public function memberships()
    {
        return $this->belongsToMany(\App\Membership::class);
    }

    public static function getListOfLanguages()
    {
        return include(resource_path('lang/codes.php'));
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($language)
        {
            if ($language->isForceDeleting())
            {
                $language->memberships()->detach();
            }
        });
    }
}
