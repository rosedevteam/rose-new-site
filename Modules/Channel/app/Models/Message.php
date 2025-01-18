<?php

namespace Modules\Channel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Models\User;

// use Modules\Channel\Database\Factories\MessageFactory;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded;

    protected $table = 'channel_messages';

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function file()
    {
        return $this->hasOne(File::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // protected static function newFactory(): MessageFactory
    // {
    //     // return MessageFactory::new();
    // }
}
