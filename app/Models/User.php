<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'shift', // Added shift
        'google_id',
        'email_verified_at',
    ];

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isBidan(): bool
    {
        return $this->hasRole('bidan');
    }

    public function isDokter(): bool
    {
        return $this->hasRole('dokter');
    }

    public function isOwner(): bool
    {
        return $this->hasRole('owner');
    }



    public function isApoteker(): bool
    {
        return $this->hasRole('apoteker');
    }

    /**
     * Determine if the user has verified their email address.
     * Override to automatically verify non-user roles (Admin, Dokter, Bidan, dll).
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        if ($this->role !== 'user') {
            return true;
        }
        return !is_null($this->email_verified_at);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function userPatient()
    {
        return $this->hasOne(UserPatient::class);
    }

    public function handledQueues()
    {
        return $this->hasMany(Queue::class, 'handled_by');
    }

    public function assignedQueues()
    {
        return $this->hasMany(Queue::class, 'assigned_practitioner_id');
    }

    public function processedTransactions()
    {
        return $this->hasMany(Transaction::class, 'processed_by');
    }

    public function handledTransactions()
    {
        return $this->hasMany(Transaction::class, 'handled_by');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
