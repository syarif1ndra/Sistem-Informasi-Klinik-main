<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icd10Code extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];

    public function screenings()
    {
        return $this->belongsToMany(Screening::class, 'screening_icd10', 'icd10_code_id', 'screening_id');
    }
}
