<?php
// app/Models/Booking.php - Corrected for Endroid v6.0

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class Booking extends Model
{
    protected $fillable = [
        'ticket_number',
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
        'qr_code',
        'confirmed_by_manager',
        'is_verified',
        'verified_at',
        'verified_by',
        'verification_count',
        'has_attended',
        'attended_at',
        'attended_by'
    ];

    protected $casts = [
        'members' => 'array',
        'confirmed_by_manager' => 'boolean',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'has_attended' => 'boolean',
        'attended_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->ticket_number = static::generateTicketNumber();
        });
    }

    public static function generateTicketNumber()
    {
        do {
            $number = 'TIK-' . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8));
        } while (static::where('ticket_number', $number)->exists());

        return $number;
    }

    public function generateQRCode()
    {
        $data = json_encode([
            'ticket_number' => $this->ticket_number,
            'event_id' => $this->event_id,
            'booking_id' => $this->id,
            'team_lead_name' => $this->team_lead_name,
            'group_size' => $this->group_size,
        ]);

        try {
            // Endroid v6.0 syntax - NO Builder::create()
            $qrCode = new QrCode($data);
            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            // Store as base64
            $this->qr_code = base64_encode($result->getString());
            $this->save();

            return $this->qr_code;
        } catch (\Exception $e) {
            \Log::error('QR Code generation failed: ' . $e->getMessage());
            
            $this->qr_code = null;
            $this->save();
            
            return null;
        }
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(Manager::class, 'verified_by');
    }

    public function markAsVerified($managerId)
    {
        $this->update([
            'is_verified' => true,
            'verified_at' => now(),
            'verified_by' => $managerId,
            'verification_count' => $this->verification_count + 1
        ]);
    }

    public function canBeVerified()
    {
        return $this->payment_status === 'confirmed' && $this->confirmed_by_manager;
    }
}