<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'plant_id',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }
}
