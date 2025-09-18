<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'price',
        // Add other package fields as needed
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
