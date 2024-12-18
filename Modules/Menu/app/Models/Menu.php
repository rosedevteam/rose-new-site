<?php

namespace Modules\Menu\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Menu\Database\Factories\MenuFactory;
use Modules\User\Models\User;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';
    protected $guarded = [];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function parent()
    {
        if($this->is_parent) return null;
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    protected static function newFactory()
    {
        return MenuFactory::new();
    }
}
