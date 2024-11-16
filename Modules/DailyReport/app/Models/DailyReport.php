<?php

namespace Modules\DailyReport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\DailyReport\Database\Factories\DailyReportFactory;

class DailyReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): DailyReportFactory
    // {
    //     // return DailyReportFactory::new();
    // }
}
