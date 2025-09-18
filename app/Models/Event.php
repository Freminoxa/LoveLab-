<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'date',
        'location',
        'poster',
        'manager_id',
        'payment_confirmed',
        'description',
    ];

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
