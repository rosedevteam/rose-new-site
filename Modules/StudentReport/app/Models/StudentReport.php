<?php

namespace Modules\StudentReport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;

class StudentReport extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['pivot'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class);
    }

}
