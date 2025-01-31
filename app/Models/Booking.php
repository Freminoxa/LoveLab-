<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'plan_type',
        'group_size',
        'price',
        'team_lead_name',
        'team_lead_email',
        'team_lead_phone',
        'members',
        'payment_status',
        'mpesa_code'
    ];

    protected $casts = [
        'members' => 'array'
    ];
}