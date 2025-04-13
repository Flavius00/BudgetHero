<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Challenge extends Model
{
    use HasFactory;

    protected $table = 'user__challenges';

    protected $fillable = [
        'user_id',
        'challenge_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
