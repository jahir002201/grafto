<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plant extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image',
        'category_id',
        'scientific_name',
        'price',
        'stock',
        'height',
        'age',
        'watering',
        'sunlight',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
