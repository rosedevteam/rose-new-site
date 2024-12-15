<?php

namespace Modules\Menu\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Menu\Database\Factories\MenuEntryFactory;
use Modules\User\Models\User;

/**
 *
 *
 * @property-read User|null $author
 * @property-read Menu|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Menu query()
 * @mixin \Eloquent
 */
class Menu extends Model
{
    use HasFactory;

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
        return MenuEntryFactory::new();
    }
}
