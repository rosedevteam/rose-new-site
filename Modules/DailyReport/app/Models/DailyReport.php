<?php

namespace Modules\DailyReport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Models\User;

/**
 * 
 *
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property string $file
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $author
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyReport whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyReport whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyReport whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyReport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DailyReport extends Model
{
    protected $guarded = [];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
