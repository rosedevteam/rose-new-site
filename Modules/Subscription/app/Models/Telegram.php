<?php

namespace Modules\Subscription\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Subscription\Database\Factories\TelegramFactory;

class Telegram extends Model
{
    use HasFactory;

    protected $guarded;

    public function logs()
    {
        return $this->hasMany(TelegramChannelLog::class);
    }

}
