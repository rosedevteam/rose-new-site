<?php

namespace Modules\JobOffer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Models\Category;
use Modules\JobOffer\Database\Factories\JobOfferFactory;
use Modules\User\Models\User;

/**
 * 
 *
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property string $content
 * @property string $type
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\JobOffer\Models\JobApplication> $applications
 * @property-read int|null $applications_count
 * @property-read User $author
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $categories
 * @property-read int|null $categories_count
 * @method static \Modules\JobOffer\Database\Factories\JobOfferFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobOffer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobOffer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobOffer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobOffer whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobOffer whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobOffer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobOffer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobOffer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobOffer whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobOffer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobOffer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class JobOffer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    protected static function newFactory()
    {
        return JobOfferFactory::new();
    }
}
