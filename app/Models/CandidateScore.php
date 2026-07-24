<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'criteria_id',
        'score_val',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
