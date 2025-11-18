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
    ];

    /**
     * Each review belongs to a ROPA record
     */
    public function ropa()
    {
        return $this->belongsTo(Ropa::class);
    }

    /**
     * Optionally, track the user who made the review
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
