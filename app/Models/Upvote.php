<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Upvote extends Model
{
    use HasFactory;
    protected $fillable = ['feature_id', 'user_id', 'upvote'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($upvote) {
            // Vérifier l'unicité avant la création
            $existingUpvote = self::where('feature_id', $upvote->feature_id)
                ->where('user_id', $upvote->user_id)
                ->exists();

            if ($existingUpvote) {
                throw new \Exception('Un utilisateur ne peut upvoter une feature qu\'une seule fois.');
            }
        });
    }
}
