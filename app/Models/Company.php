<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums;
use App\Scopes\CompanyScope;
use App\Scopes\UserScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * Model Company
 *
 * @property string $id
 * @property string $name
 * @property string $tax_id
 * @property bool $visible_to_client
 * @property \App\Enums\GenericStatus $status
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $members
 * @property-read int|null $members_count
 * @method static Builder|Company newModelQuery()
 * @method static Builder|Company newQuery()
 * @method static Builder|Company onlyTrashed()
 * @method static Builder|Company query()
 * @method static Builder|Company whereCreatedAt($value)
 * @method static Builder|Company whereDeletedAt($value)
 * @method static Builder|Company whereExtraAttributes($value)
 * @method static Builder|Company whereId($value)
 * @method static Builder|Company whereName($value)
 * @method static Builder|Company whereStatus($value)
 * @method static Builder|Company whereTaxNumber($value)
 * @method static Builder|Company whereUpdatedAt($value)
 * @method static Builder|Company whereVisibleToClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withExtraAttributes()
 * @method static Builder|Company withTrashed()
 * @method static Builder|Company withoutTrashed()
 * @method static Builder|Company whereTaxId($value)
 * @mixin \Eloquent
 * @mixin IdeHelperCompany
 */
class Company extends BaseModelMedia
{
    /**
     * The table associated with the model.
     */
    final public const TABLE = 'companies';

    /**
     * Table ID for foreign keys
     */
    final public const FOREIGN_KEY = 'company_id';

    /**
     * Primary Key
     */
    final public const ATTRIBUTE_ID = 'id';

    final public const ATTRIBUTE_NAME = 'name';
    final public const ATTRIBUTE_TAX_ID = 'tax_id';
    final public const ATTRIBUTE_VISIBLE_TO_CLIENT = 'visible_to_client';
    final public const ATTRIBUTE_STATUS = 'status';

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
        self::ATTRIBUTE_NAME,
        self::ATTRIBUTE_TAX_ID,
        self::ATTRIBUTE_VISIBLE_TO_CLIENT,
        self::ATTRIBUTE_STATUS,
        self::ATTRIBUTE_EXTRA_ATTRIBUTES,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        self::ATTRIBUTE_NAME => 'string',
        self::ATTRIBUTE_TAX_ID => 'string',
        self::ATTRIBUTE_VISIBLE_TO_CLIENT => 'bool',
        self::ATTRIBUTE_STATUS => Enums\GenericStatus::class,
    ];

    /**
     * Return Employees
     *
     * @return HasMany|Builder
     */
    private function employees(): HasMany|Builder
    {
        return $this->hasMany(Employee::class, self::FOREIGN_KEY, self::ATTRIBUTE_ID);
    }

    /**
     * Return Members of Company
     * Without the base filters
     *
     * @return HasMany
     */
    public function members(): HasMany
    {
        return $this->employees()
            ->withoutGlobalScope(CompanyScope::class)
            ->withoutGlobalScope(UserScope::class);
    }

    /**
     * Scope for Client Visibility
     *
     * @param Builder $query
     * @return Builder
     */
    public function filterByVisibility(Builder $query): Builder
    {
        return $query->where('visible_to_client', true);
    }

    public function getCurrentCashFlow(): ?CashFlow
    {
        if (($this->extra_attributes->settings['cashflow_method'] ?? 'global') == 'global') {
            return CashFlow::query()
                ->where(CashFlow::ATTRIBUTE_FK_COMPANY, $this->{self::ATTRIBUTE_ID})
                ->whereDate(CashFlow::ATTRIBUTE_WORK_DATE, Carbon::today()->toDateString())
                ->where(CashFlow::ATTRIBUTE_STATUS, 'open')
                ->first();
        } else {
            return CashFlow::query()
                ->where(CashFlow::ATTRIBUTE_FK_OPEN_EMPLOYEE, Auth::id())
                ->where(CashFlow::ATTRIBUTE_FK_COMPANY, $this->{self::ATTRIBUTE_ID})
                ->whereDate(CashFlow::ATTRIBUTE_WORK_DATE, Carbon::today()->toDateString())
                ->where(CashFlow::ATTRIBUTE_STATUS, 'open')
                ->first();
        }
    }
}
