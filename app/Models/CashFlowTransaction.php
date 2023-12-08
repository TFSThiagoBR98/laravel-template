<?php

namespace App\Models;

use App\Contracts\CompanyOwned;
use App\Enums;
use App\Traits\BelongToCashFlow;
use App\Concerns\HasCompany;
use App\Traits\BelongToCreator;

/**
 * App\Models\CashFlowTransaction
 *
 * @property string $id
 * @property string $name
 * @property \App\Enums\CashFlowTransactionType $operation_type
 * @property int $amount
 * @property \App\Enums\GenericStatus $status
 * @property string|null $notes
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $company_id
 * @property string|null $creator_id
 * @property string $cash_flow_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\CashFlow $cashFlow
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User|null $creator
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereCashFlowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereExtraAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereOperationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withExtraAttributes()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CashFlowTransaction withoutTrashed()
 * @mixin \Eloquent
 * @mixin IdeHelperCashFlowTransaction
 */
class CashFlowTransaction extends BaseModelMedia implements CompanyOwned
{
    use HasCompany;
    use BelongToCreator;
    use BelongToCashFlow;

    /**
     * The table associated with the model.
     */
    final public const TABLE = 'cash_flow_transactions';

    /**
     * Table ID for foreign keys
     */
    final public const FOREIGN_KEY = 'cash_flow_transaction_id';

    /**
     * Primary Key
     */
    final public const ATTRIBUTE_ID = 'id';

    final public const ATTRIBUTE_DESCRIPTION = 'name';
    final public const ATTRIBUTE_OPERATION_TYPE = 'operation_type';
    final public const ATTRIBUTE_AMOUNT = 'amount';
    final public const ATTRIBUTE_STATUS = 'status';
    final public const ATTRIBUTE_NOTES = 'notes';

    final public const ATTRIBUTE_FK_COMPANY = Company::FOREIGN_KEY;
    final public const ATTRIBUTE_FK_CASH_FLOW = CashFlow::FOREIGN_KEY;

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
        self::ATTRIBUTE_OPERATION_TYPE,
        self::ATTRIBUTE_AMOUNT,
        self::ATTRIBUTE_STATUS,
        self::ATTRIBUTE_NOTES,
        self::ATTRIBUTE_EXTRA_ATTRIBUTES,
        self::ATTRIBUTE_FK_COMPANY,
        self::ATTRIBUTE_FK_CASH_FLOW,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        self::ATTRIBUTE_DESCRIPTION => 'string',
        self::ATTRIBUTE_OPERATION_TYPE => Enums\CashFlowTransactionType::class,
        self::ATTRIBUTE_AMOUNT => 'int',
        self::ATTRIBUTE_STATUS => Enums\GenericStatus::class,
        self::ATTRIBUTE_NOTES => 'string',
    ];
}
