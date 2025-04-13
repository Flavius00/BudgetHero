<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CsvSave extends Model
{
    protected $table = 'csv_saves';

    protected $fillable = [
        'transaction_date',
        'amount',
        'is_income',
        'store_id',
        'user_id', // ✅ Add this line to fix the error
        'category_id', // Add any other fields you're assigning in bulk
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
