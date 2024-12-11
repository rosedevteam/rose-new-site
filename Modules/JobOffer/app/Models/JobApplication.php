<?php

namespace Modules\JobOffer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\JobOffer\Database\Factories\JobApplicationFactory;

/**
 * 
 *
 * @property int $id
 * @property int $joboffer_id
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string $resume
 * @property string|null $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Modules\JobOffer\Models\JobOffer|null $jobOffer
 * @method static \Modules\JobOffer\Database\Factories\JobApplicationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobApplication query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobApplication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobApplication whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobApplication whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobApplication whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobApplication whereJobofferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobApplication wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobApplication whereResume($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobApplication whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobApplication whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class JobApplication extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class);
    }

    protected static function newFactory()
    {
        return JobApplicationFactory::new();
    }
}
