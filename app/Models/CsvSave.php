<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CsvSave extends Model
{
    protected $table = 'csv_saves'; // Only needed if your table name is not the default

    
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');  // Adjust the foreign key if needed
    }
}
