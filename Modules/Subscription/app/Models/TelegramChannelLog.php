<?php

namespace Modules\Subscription\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramChannelLog extends Model
{
    use HasFactory;

    protected $guarded;

    public function telegram()
    {
        return $this->hasMany(Telegram::class);
    }

}
