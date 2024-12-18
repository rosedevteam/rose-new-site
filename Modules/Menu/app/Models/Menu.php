<?php

namespace Modules\Menu\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Menu\Database\Factories\MenuFactory;
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

    protected $table = 'menus';
    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(Menu::class , 'parent_id' , 'id');
    }

    protected static function newFactory()
    {
        return MenuFactory::new();
    }
}
