<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarSource extends Model
{
    //
    protected $fillable = [
        'name',
        'ics_url',
        'is_protected',
        'access_token',
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
