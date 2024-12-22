<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Order\Models\Order;
use Modules\Payment\Database\Factories\PaymentFactory;
use Modules\Payment\Database\Factories\PaymentFactoryFactory;

// use Modules\Payment\Database\Factories\PaymentFactory;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

     protected static function newFactory()
     {
          return PaymentFactory::new();
     }
}
