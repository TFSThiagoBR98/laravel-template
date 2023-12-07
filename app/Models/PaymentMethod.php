<?php

namespace App\Models;

use App\Contracts\CompanyOwned;
use App\Enums;
use App\Traits\BelongToCompany;

/**
 * App\Models\PaymentMethod
 *
 * @property string $id
 * @property string $name
 * @property \App\Enums\GenericStatus $status
 * @property string|null $notes
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $company_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Company $company
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod withoutTrashed()
 * @mixin \Eloquent
 */
class PaymentMethod extends BaseModelMedia implements CompanyOwned
{
    use BelongToCompany;

    /**
     * The table associated with the model.
     */
    final public const TABLE = 'payment_methods';

    /**
     * Table ID for foreign keys
     */
    final public const FOREIGN_KEY = 'payment_method_id';

    /**
     * Primary Key
     */
    final public const ATTRIBUTE_ID = 'id';

    final public const ATTRIBUTE_NAME = 'name';
    final public const ATTRIBUTE_STATUS = 'status';
    final public const ATTRIBUTE_NOTES = 'notes';

    final public const ATTRIBUTE_FK_COMPANY = Company::FOREIGN_KEY;

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
        self::ATTRIBUTE_STATUS,
        self::ATTRIBUTE_NOTES,
        self::ATTRIBUTE_EXTRA_ATTRIBUTES,
        self::ATTRIBUTE_FK_COMPANY,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        self::ATTRIBUTE_NAME => 'string',
        self::ATTRIBUTE_STATUS => Enums\GenericStatus::class,
        self::ATTRIBUTE_NOTES => 'string',
    ];

    public static function findByName($name): ?self
    {
        return self::where('name', $name)->first();
    }
}
