<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property int $salary
 * @property string|null $tags
 * @property string $job_type
 * @property bool $remote
 * @property string|null $requirements
 * @property string|null $benefits
 * @property string|null $address
 * @property string $city
 * @property string $state
 * @property string|null $zipcode
 * @property string $contact_email
 * @property string|null $contact_phone
 * @property string $company_name
 * @property string|null $company_description
 * @property string|null $company_logo
 * @property string|null $company_website
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\JobFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereBenefits($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereCompanyDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereCompanyLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereCompanyWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereJobType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereRemote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Job whereZipcode($value)
 * @mixin \Eloquent
 */
class Job extends Model
{
    use HasFactory;

    protected $table = 'job_listings';

    protected $fillable = [
        'title',
        'description',
        'salary',
        'tags',
        'job_type',
        'remote',
        'requirements',
        'benefits',
        'address',
        'city',
        'state',
        'zipcode',
        'contact_email',
        'contact_phone',
        'company_name',
        'company_description',
        'company_logo',
        'company_website',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo((User::class));
    }

    // Relation to bookmarks
    public function bookmarkedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'job_user_bookmarks')->withTimestamps();
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class);
    } 

}
