<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $table = 'challenges';

    protected $fillable = [
        'name',
        'description',
        'badge',
    ];

    protected $casts = [];

    public function getBadgeUrlAttribute(): ?string
    {
        return $this->badge ? asset('storage/' . $this->badge) : null;
    }
}
