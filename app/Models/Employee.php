<?php declare(strict_types=1);

namespace App\Models;

use App\Contracts\CompanyOwned;
use App\Contracts\UserOwned;
use App\Enums;
use App\Events\Employee\EmployeeCreated;
use App\Events\Employee\EmployeeUpdated;
use App\Concerns\HasCompany;
use App\Traits\BelongToUser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Traits\HasRoles;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

/**
 * Model Employee
 *
 * @property string $company_id
 * @property string $user_id
 * @property string $id
 * @property string|null $role
 * @property \App\Enums\GenericStatus $status
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Company $company
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperEmployee
 */
class Employee extends BaseModelMedia implements CompanyOwned, UserOwned
{
    use HasCompany;
    use BelongToUser;
    use HasRoles;
    use CentralConnection;

    /**
     * Set Permission Guard Name
     *
     * @var string
     */
    protected $guard_name = 'web';

    /**
     * The table associated with the model.
     */
    final public const TABLE = 'employees';

    /**
     * Table ID for foreign keys
     */
    final public const FOREIGN_KEY = 'employee_id';

    /**
     * Primary Key
     */
    final public const ATTRIBUTE_ID = 'id';
    final public const ATTRIBUTE_ROLE = 'role';
    final public const ATTRIBUTE_STATUS = 'status';

    final public const ATTRIBUTE_FK_COMPANY = Company::FOREIGN_KEY;
    final public const ATTRIBUTE_FK_USER = User::FOREIGN_KEY;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = self::ATTRIBUTE_ID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        self::ATTRIBUTE_ROLE,
        self::ATTRIBUTE_STATUS,
        self::ATTRIBUTE_FK_COMPANY,
        self::ATTRIBUTE_FK_USER,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        self::ATTRIBUTE_STATUS => Enums\GenericStatus::class,
    ];

    /**
     * The event map for the model.
     *
     * Allows for object-based events for native Eloquent events.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => EmployeeCreated::class,
        'updated' => EmployeeUpdated::class,
    ];

    /**
     * Get Employee if registred by Company and User
     *
     * @param string $companyId
     * @param string $userId
     *
     * @return self|null
     */
    public static function getEmployeeByCompanyIdUserId(string $companyId, string $userId): ?self
    {
        return self::query()
            ->where(self::ATTRIBUTE_FK_COMPANY, $companyId)
            ->where(self::ATTRIBUTE_FK_USER, $userId)
            ->first();
    }

    public function hasCompanyColumn(): bool
    {
        return Schema::hasColumn($this->getModel()->getTable(), $this->getCompanyColumnName());
    }

    /**
     * Get company of model
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, $this->getCompanyColumnName());
    }
}
