<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'periode_start',
        'periode_end',
        'total_gaji',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'periode_start' => 'date',
        'periode_end' => 'date',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
