<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\User;

class Ropa extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'Pending';
    const STATUS_REVIEWED = 'Reviewed';

    protected $fillable = [
        'user_id',
        'status',
        'organisation_name',
        'other_organisation_name',
        'department',
        'other_department',
        'processes',
        'data_sources',
        'data_sources_other',
        'data_formats',
        'data_formats_other',
        'information_nature',
        'personal_data_categories',
        'personal_data_categories_other',
        'records_count',
        'data_volume',
        'retention_period_years',
        'access_estimate',
        'retention_rationale',
        'information_shared',
        'sharing_local',
        'sharing_transborder',
        'local_organizations',
        'transborder_countries',
        'sharing_comment',
        'access_control',
        'access_measures',
        'technical_measures',
        'organisational_measures',
        'lawful_basis',
        'risk_report',

        // Add if you want to use risk scoring
        // 'risk_level',
    ];

    protected $casts = [
        'processes' => 'array',
        'data_sources' => 'array',
        'data_sources_other' => 'array',
        'data_formats' => 'array',
        'data_formats_other' => 'array',
        'information_nature' => 'array',
        'personal_data_categories' => 'array',
        'personal_data_categories_other' => 'array',
        'records_count' => 'array',
        'data_volume' => 'array',
        'retention_period_years' => 'array',
        'access_estimate' => 'array',
        'retention_rationale' => 'array',
        'local_organizations' => 'array',
        'transborder_countries' => 'array',
        'access_measures' => 'array',
        'technical_measures' => 'array',
        'organisational_measures' => 'array',
        'lawful_basis' => 'array',
        'risk_report' => 'array',
        'information_shared' => 'boolean',
        'sharing_local' => 'boolean',
        'sharing_transborder' => 'boolean',
        'access_control' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function isReviewed(): bool
    {
        return $this->status === self::STATUS_REVIEWED;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public static function sections()
    {
        return [
            'organisation_name',
            'department',
            'processes',
            'data_sources',
            'data_formats',
            'information_nature',
            'personal_data_categories',
            'records_count',
            'data_volume',
            'retention_period_years',
            'access_estimate',
            'retention_rationale',
            'information_shared',
            'local_organizations',
            'transborder_countries',
            'access_control',
            'access_measures',
            'technical_measures',
            'organisational_measures',
            'lawful_basis',
            'risk_report',
        ];
    }

    // Safe version — no recursion
    public function calculateRiskScore()
    {
        if (!property_exists($this, 'risk_level') || !$this->risk_level) {
            return 0;
        }

        return match ($this->risk_level) {
            'Critical' => 4,
            'High' => 3,
            'Medium' => 2,
            'Low' => 1,
            default => 0,
        };
    }
}
