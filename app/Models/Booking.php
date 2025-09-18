<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'event_id',
        'package_id',
        'plan_type',
        'group_size',
        'price',
        'team_lead_name',
        'team_lead_email',
        'team_lead_phone',
        'members',
        'payment_status',
        'mpesa_code',
        'confirmed_by_manager'
    ];

    protected $casts = [
        'members' => 'array',
        'confirmed_by_manager' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}