<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'ropa_id',
        'risk_level',
        'category',
        'factors_considered',
        'assessed_by',
        'assessment_date',
    ];

    protected $casts = [
        'assessment_date' => 'date',
        'risk_level' => 'integer',
    ];

    // Relationships
    public function ropa()
    {
        return $this->belongsTo(Ropa::class);
    }
}
