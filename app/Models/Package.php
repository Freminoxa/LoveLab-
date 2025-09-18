<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'price',
        'group_size',
        'description',
        'available_tickets',
        'icon'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'group_size' => 'integer',
        'available_tickets' => 'integer',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Check if tickets are available
    public function hasAvailableTickets()
    {
        if ($this->available_tickets === null) {
            return true; // Unlimited tickets
        }
        
        $soldTickets = $this->bookings()
            ->where('payment_status', 'confirmed')
            ->count();
        
        return $soldTickets < $this->available_tickets;
    }
}