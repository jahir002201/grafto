<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public const PENDING = 'PENDING';
    public const SUCCESS = 'SUCCESS';
    public const FAILED = 'FAILED';
    
    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'status',
        'transaction_id',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
