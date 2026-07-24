<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwotEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'strengths_score',
        'weaknesses_score',
        'opportunities_score',
        'threats_score',
        'ifas_score',
        'efas_score',
        'quadrant',
        'strategy_recommendation',
        'notes',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
