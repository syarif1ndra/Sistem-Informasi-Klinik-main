<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPatient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'nik',
        'dob',
        'gender',
        'phone',
        'address',
    ];

    protected $appends = [
        'gender_label',
    ];

    /**
     * Interact with the patients's gender.
     */
    protected function gender(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn (?string $value) => $value ? strtoupper($value) : null,
            set: fn (?string $value) => $value === null ? null : match (strtolower($value)) {
                'male', 'l' => 'L',
                'female', 'p' => 'P',
                default => null,
            },
        );
    }

    public function getGenderLabelAttribute(): ?string
    {
        return $this->gender === 'L' ? 'Laki-laki' : ($this->gender === 'P' ? 'Perempuan' : null);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }
}
