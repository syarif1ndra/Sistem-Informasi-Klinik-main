<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    protected $fillable = [
        'medicine_id',
        'type',
        'quantity',
        'description',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
