<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Câmpuri ce pot fi completate în masă
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'path',
        'quiz_path',
    ];

    // Conversia automată a datelor în tipuri PHP (ex: pentru date)
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Exemplu de metodă custom (durata cursului în zile)
    public function getDurationInDays(): ?int
    {
        if (!$this->start_date || !$this->end_date) {
            return null;
        }

        return $this->end_date->diffInDays($this->start_date);
    }
}
