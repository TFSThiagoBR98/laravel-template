<?php

namespace App\Models;

use App\Concerns\HasCompany;
use App\Contracts\CompanyOwned;
use App\Enums;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\AcquirerTransaction
 *
 * @property string $id
 * @property string|null $description
 * @property string|null $operation
 * @property string $method
 * @property \Illuminate\Support\Collection $request
 * @property \Illuminate\Support\Collection $response
 * @property string $http_code
 * @property string|null $acquirer
 * @property string|null $payable_type
 * @property string|null $payable_id
 * @property string|null $payer_type
 * @property string|null $payer_id
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
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $payable
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereAcquirer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereHttpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereOperation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction wherePayableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction wherePayableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction wherePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction wherePayerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AcquirerTransaction withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperAcquirerTransaction
 */
class AcquirerTransaction extends BaseModelMedia implements CompanyOwned
{
    use HasCompany;

    /**
     * The table associated with the model.
     */
    final public const TABLE = 'acquirer_transactions';

    /**
     * Table ID for foreign keys
     */
    final public const FOREIGN_KEY = 'acquirer_transaction_id';

    /**
     * Primary Key
     */
    final public const ATTRIBUTE_ID = 'id';

    final public const ATTRIBUTE_DESCRIPTION = 'description';
    final public const ATTRIBUTE_OPERATION = 'operation';
    final public const ATTRIBUTE_METHOD = 'method';
    final public const ATTRIBUTE_REQUEST = 'request';
    final public const ATTRIBUTE_RESPONSE = 'response';
    final public const ATTRIBUTE_HTTP_CODE = 'http_code';
    final public const ATTRIBUTE_ACQUIRER = 'acquirer';

    final public const MORPH_PAYABLE = 'payable';
    final public const MORPH_PAYER = 'payer';

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
        self::ATTRIBUTE_DESCRIPTION,
        self::ATTRIBUTE_OPERATION,
        self::ATTRIBUTE_METHOD,
        self::ATTRIBUTE_REQUEST,
        self::ATTRIBUTE_RESPONSE,
        self::ATTRIBUTE_HTTP_CODE,
        self::ATTRIBUTE_ACQUIRER,
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
        self::ATTRIBUTE_DESCRIPTION => 'string',
        self::ATTRIBUTE_OPERATION => 'string',
        self::ATTRIBUTE_METHOD => 'string',
        self::ATTRIBUTE_REQUEST => 'collection',
        self::ATTRIBUTE_RESPONSE => 'collection',
        self::ATTRIBUTE_HTTP_CODE => 'string',
        self::ATTRIBUTE_ACQUIRER => 'string',
        self::ATTRIBUTE_STATUS => Enums\GenericStatus::class,
        self::ATTRIBUTE_NOTES => 'string',
    ];

    /**
     * Payable item
     *
     * @return MorphTo
     */
    public function payable(): MorphTo
    {
        return $this->morphTo(self::MORPH_PAYABLE);
    }
}

