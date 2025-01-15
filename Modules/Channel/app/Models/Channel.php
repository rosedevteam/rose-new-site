<?php

namespace Modules\Channel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Channel\Database\Factories\ChannelFactory;
use Modules\Product\Models\Product;
use Modules\User\Models\User;

// use Modules\Channel\Database\Factories\ChannelFactory;

class Channel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded;

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

     protected static function newFactory(): ChannelFactory
     {
          return ChannelFactory::new();
     }
}
