<?php

namespace Modules\DailyReport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\DailyReport\Database\Factories\DailyReportFactory;
use Modules\User\Models\User;

class DailyReport extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function newFactory(): DailyReportFactory
    {
        return DailyReportFactory::new();
    }

}
