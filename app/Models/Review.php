<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'ropa_id',
        'review_status',
        'remarks',
        'risk_score',
        'reviewed_by',
    ];

    public function ropa()
    {
        return $this->belongsTo(Ropa::class);
    }
}
