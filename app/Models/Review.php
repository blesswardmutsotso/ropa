<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ropa;
use App\Models\User;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'ropa_id',
        'user_id',
        'comment',
        'score',
        'section_scores',
        'data_processing_agreement',
        'data_protection_impact_assessment',
    ];

    protected $casts = [
        'section_scores' => 'array',
        'data_processing_agreement' => 'boolean',
        'data_protection_impact_assessment' => 'boolean',
    ];

    /** Review belongs to a ROPA */
    public function ropa()
    {
        return $this->belongsTo(Ropa::class);
    }

    /** Review belongs to a user (admin reviewer) */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Total Score = sum of all section scores */
    public function getTotalScoreAttribute()
    {
        if (!$this->section_scores) {
            return 0;
        }

        return array_sum($this->section_scores);
    }

    /** Average Score = mean of section scores */
    public function getAverageScoreAttribute()
    {
        if (!$this->section_scores || !is_array($this->section_scores)) {
            return null;
        }

        $scores = array_filter($this->section_scores, 'is_numeric');

        if (count($scores) === 0) {
            return 0;
        }

        return round(array_sum($scores) / count($scores), 2);
    }
}
