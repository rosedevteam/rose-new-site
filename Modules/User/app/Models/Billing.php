<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Billing extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
