<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObtainingMethodOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'obtaining_method_id',
        'order_id',
        'address_id',
    ];

        public function obtainingMethod()
    {
        return $this->belongsTo(ObtainingMethod::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
