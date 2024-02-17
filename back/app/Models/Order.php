<?php

namespace App\Models;

use App\Enums\ObtainingMethodEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'cost',
        'receipt_time',
        'can_earlier',
        'customer_id',
        'payment_method_id',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function pivot()
    {
        return $this->hasOne(ObtainingMethodOrder::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    protected function cost(): Attribute
    {
        return Attribute::make(
            get: fn(int $value) => $value / 100,
            set: fn(int $value) => $value * 100
        );
    }
}
