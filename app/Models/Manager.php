<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'password_changed_at',
    ];

    protected $casts = [
        'password_changed_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Check if this is the manager's first login (password not changed yet)
     */
    public function isFirstLogin()
    {
        return is_null($this->password_changed_at);
    }

    /**
     * Mark password as changed
     */
    public function markPasswordAsChanged()
    {
        $this->password_changed_at = now();
        $this->save();
    }

    /**
     * Relationship with events
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}