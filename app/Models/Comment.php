<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- Add this

class Comment extends Model
{
    use HasFactory, SoftDeletes; // <-- SoftDeletes

    protected $fillable = [
        'review_id',
        'user_id',
        'content',
    ];

    /** Comment belongs to a review */
    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    /** Comment belongs to a user */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
