<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'nik',
        'name',
        'gender',
        'phone',
        'address',
        'status',
    ];

    public function scores()
    {
        return $this->hasMany(CandidateScore::class);
    }

    public function swotEvaluation()
    {
        return $this->hasOne(SwotEvaluation::class);
    }

    public function calculationResult()
    {
        return $this->hasOne(CalculationResult::class);
    }
}
