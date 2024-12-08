<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Database\Factories\CategoryFactory;
use Modules\JobOffer\Models\JobOffer;

/**
 *
 *
 * @property int $id
 * @property int $author_id
 * @property int $is_parent
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, JobOffer> $jobOffers
 * @property-read int|null $job_offers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $parent
 * @property-read int|null $parent_count
 * @method static \Modules\Category\Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereIsParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function children()
    {
        if (!$this->is_parent) return null;
        return $this->morphToMany(Category::class, 'categoryable');
    }

    public function jobOffers()
    {
        return $this->morphedByMany(JobOffer::class, 'categoryable');
    }

    public function parent()
    {
        return $this->morphedByMany(Category::class, 'categoryable');
    }

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

}
