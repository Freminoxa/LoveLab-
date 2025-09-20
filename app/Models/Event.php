<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'name',
        'date',
        'location',
        'till_number',
        'poster',
        'manager_id',
        'payment_confirmed',
        'description',
        'status', // draft, published, cancelled
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

    // Generate URL-friendly slug from event name
    public function getSlugAttribute()
    {
        return Str::slug($this->name);
    }

    // Get event URL
    public function getUrlAttribute()
    {
        return url('/' . $this->slug);
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

    // Get formatted date
    public function getFormattedDateAttribute()
    {
        return $this->date->format('l, F j, Y - g:i A');
    }
}