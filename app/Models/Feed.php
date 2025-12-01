<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    //
    protected $fillable = [
        'token',
        'signature',
    ];

    public function sources()
    {
        return $this->belongsToMany(CalendarSource::class, 'feed_calendar_source');
    }
}
