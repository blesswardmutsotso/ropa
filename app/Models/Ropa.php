<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RiskWeightSetting;
use App\Models\Review;
use App\Models\RiskScore;
use App\Models\User;

class Ropa extends Model
{
    use HasFactory;

    // Define possible status values as constants
    const STATUS_PENDING = 'Pending';
    const STATUS_REVIEWED = 'Reviewed';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'status',       // Table column
        'ropa_create',  // JSON column
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date_submitted' => 'datetime',
        'ropa_create' => 'array', 
         // nested JSON
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

   

    public function riskScores()
    {
        return $this->hasMany(RiskScore::class);
    }

    public function riskWeightSettings()
    {
        return $this->hasMany(RiskWeightSetting::class);
    }

    /**
     * Calculate total risk score for this ROPA record
     */
    public function calculateRiskScore()
    {
        $weights = $this->riskWeightSettings()->pluck('weight', 'field_name')->toArray();

        $totalWeight = array_sum($weights);
        if ($totalWeight <= 0) {
            return 0;
        }

        $score = 0;
        foreach ($weights as $field => $weight) {
            if (isset($this->ropa_create[$field]) && !empty($this->ropa_create[$field])) {
                $score += $weight;
            }
        }

        return round(($score / $totalWeight) * 100, 2);
    }

    /**
     * Check if the ROPA is reviewed
     */
    public function isReviewed(): bool
    {
        return ($this->ropa_create['status'] ?? null) === self::STATUS_REVIEWED;
    }

    /**
     * Check if the ROPA is pending
     */
    public function isPending(): bool
    {
        return ($this->ropa_create['status'] ?? null) === self::STATUS_PENDING;
    }
}
