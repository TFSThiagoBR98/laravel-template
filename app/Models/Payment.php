<?php

namespace App\Models;

use App\Contracts\CompanyOwned;
use App\Enums;
use App\Concerns\HasCompany;
use App\Traits\BelongToCreator;
use App\Traits\BelongToPaymentMethod;
use App\Traits\BelongToCashFlow;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Payment
 *
 * @property string $name
 * @property string $id
 * @property string $description
 * @property string $method
 * @property \Illuminate\Support\Collection|null $payment_data
 * @property \Illuminate\Support\Collection|null $confirmation_data
 * @property \Illuminate\Support\Collection|null $chargeback_data
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property string $acquirer
 * @property string|null $payable_type
 * @property string|null $payable_id
 * @property string|null $payer_type
 * @property string|null $payer_id
 * @property \App\Enums\PaymentStatus $status
 * @property string|null $notes
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $company_id
 * @property string|null $creator_id
 * @property string|null $courtyard_id
 * @property string|null $cash_flow_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\CashFlow|null $cashFlow
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User|null $creator
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $payable
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $payer
 * @property-read \App\Models\PaymentMethod|null $paymentMethod
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAcquirer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCashFlowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereChargebackData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereConfirmationData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCourtyardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePayerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperPayment
 */
class Payment extends BaseModelMedia implements CompanyOwned
{
    use HasCompany;
    use BelongToPaymentMethod;
    use BelongToCreator;
    use BelongToCashFlow;

    /**
     * The table associated with the model.
     */
    final public const TABLE = 'payments';

    /**
     * Table ID for foreign keys
     */
    final public const FOREIGN_KEY = 'payment_id';

    /**
     * Primary Key
     */
    final public const ATTRIBUTE_ID = 'id';

    final public const ATTRIBUTE_DESCRIPTION = 'description';
    final public const ATTRIBUTE_METHOD = 'method';
    final public const ATTRIBUTE_PAYMENT_DATA = 'payment_data';
    final public const ATTRIBUTE_CONFIRMATION_DATA = 'confirmation_data';
    final public const ATTRIBUTE_CHARGEBACK_DATA = 'chargeback_data';
    final public const ATTRIBUTE_PRICE = 'price';
    final public const ATTRIBUTE_ACQUIRER = 'acquirer';
    final public const ATTRIBUTE_PAID_AT = 'paid_at';

    final public const MORPH_PAYABLE = 'payable';
    final public const MORPH_PAYER = 'payer';

    final public const ATTRIBUTE_STATUS = 'status';
    final public const ATTRIBUTE_NOTES = 'notes';

    final public const ATTRIBUTE_FK_COMPANY = Company::FOREIGN_KEY;
    final public const ATTRIBUTE_FK_CASH_FLOW = CashFlow::FOREIGN_KEY;
    final public const ATTRIBUTE_FK_PAYMENT_METHOD = self::ATTRIBUTE_METHOD;

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
        self::ATTRIBUTE_METHOD,
        self::ATTRIBUTE_PAYMENT_DATA,
        self::ATTRIBUTE_CONFIRMATION_DATA,
        self::ATTRIBUTE_CHARGEBACK_DATA,
        self::ATTRIBUTE_PRICE,
        self::ATTRIBUTE_ACQUIRER,
        self::ATTRIBUTE_PAID_AT,
        self::ATTRIBUTE_FK_CREATOR,
        self::ATTRIBUTE_STATUS,
        self::ATTRIBUTE_NOTES,
        self::ATTRIBUTE_EXTRA_ATTRIBUTES,
        self::ATTRIBUTE_FK_COMPANY,
        self::ATTRIBUTE_FK_CREATOR,
        self::ATTRIBUTE_FK_CASH_FLOW,
        self::MORPH_PAYABLE.'_id',
        self::MORPH_PAYABLE.'_type',
        self::MORPH_PAYER.'_id',
        self::MORPH_PAYER.'_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        self::ATTRIBUTE_DESCRIPTION => 'string',
        self::ATTRIBUTE_METHOD => 'string',
        self::ATTRIBUTE_PAYMENT_DATA => 'collection',
        self::ATTRIBUTE_CONFIRMATION_DATA => 'collection',
        self::ATTRIBUTE_CHARGEBACK_DATA => 'collection',
        self::ATTRIBUTE_PRICE => 'int',
        self::ATTRIBUTE_PAID_AT => 'datetime',
        self::ATTRIBUTE_ACQUIRER => 'string',
        self::ATTRIBUTE_STATUS => Enums\PaymentStatus::class,
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

    /**
     * The agent who did this payment
     *
     * @return MorphTo
     */
    public function payer(): MorphTo
    {
        return $this->morphTo(self::MORPH_PAYER);
    }

    /**
     * Get payment method of model
     *
     * @return BelongsTo
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, self::ATTRIBUTE_FK_PAYMENT_METHOD);
    }
}
