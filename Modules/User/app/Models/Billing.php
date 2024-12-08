<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 *
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $address
 * @property string|null $city
 * @property string|null $province
 * @property string|null $postal_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Modules\User\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Billing whereUserId($value)
 * @mixin \Eloquent
 */
class Billing extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
