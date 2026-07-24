<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $table = 'criterias';

    protected $fillable = [
        'code',
        'name',
        'type',
        'weight',
        'min_val',
        'max_val',
    ];

    public function subCriterias()
    {
        return $this->hasMany(SubCriteria::class)->orderBy('value', 'asc');
    }

    public function candidateScores()
    {
        return $this->hasMany(CandidateScore::class);
    }
}
