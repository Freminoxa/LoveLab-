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
        'status', // active, completed, cancelled
    ];

    protected $casts = [
        'date' => 'datetime',
        'payment_confirmed' => 'boolean',
    ];

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Calculate total revenue for this event
    public function getTotalRevenueAttribute()
    {
        return $this->bookings()
            ->where('payment_status', 'confirmed')
            ->sum('price');
    }

    // Get total tickets sold
    public function getTotalTicketsSoldAttribute()
    {
        return $this->bookings()
            ->where('payment_status', 'confirmed')
            ->sum('group_size');
    }

    // Check if event is upcoming
    public function getIsUpcomingAttribute()
    {
        return $this->date->isFuture();
    }
}