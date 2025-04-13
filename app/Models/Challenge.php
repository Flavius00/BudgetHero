<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        return $this->badge ? Storage::disk('public')->url($this->badge) : null;
    }
}
