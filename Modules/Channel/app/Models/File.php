<?php

namespace Modules\Channel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Channel\Database\Factories\FileFactory;

class File extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded;

    protected $table = 'message_files';

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    // protected static function newFactory(): FileFactory
    // {
    //     // return FileFactory::new();
    // }
}
