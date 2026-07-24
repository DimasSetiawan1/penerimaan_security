<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculationResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'smart_score',
        'swot_score',
        'final_score',
        'rank',
        'recommendation_status',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
