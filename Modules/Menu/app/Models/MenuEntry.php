<?php

namespace Modules\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Models\User;

/**
 * 
 *
 * @property-read User|null $author
 * @property-read MenuEntry|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MenuEntry query()
 * @mixin \Eloquent
 */
class MenuEntry extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function children()
    {
        if(!$this->is_parent) return null;
        return $this->hasMany(MenuEntry::class, 'parent_id');
    }

    public function parent()
    {
        if($this->is_parent) return null;
        return $this->belongsTo(MenuEntry::class, 'parent_id');
    }
}
