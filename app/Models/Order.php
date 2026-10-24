<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const NOT_PAID = 'Not Paid';
    public const READY_TO_SHIP = 'Ready To Ship';
    public const SHIPPED = 'Shipped';
    public const DELIVERED = 'Delivered';
    public const CANCELED = 'Canceled';

    public const STATUS_CHOICES = [
        self::NOT_PAID,
        self::READY_TO_SHIP,
        self::SHIPPED,
        self::DELIVERED,
        self::CANCELED,
    ];

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'shipping_address',
        'shipping_phone',
        'shipping_name',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
        ];
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
