<?php

namespace App\Models;

use App\Contracts\CompanyOwned;
use App\Enums;
use App\Enums\CashFlowStatus;
use App\Traits\BelongToCompany;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * App\Models\CashFlow
 *
 * @property string $id
 * @property \Illuminate\Support\Carbon $work_date
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property int $start_amount
 * @property CashFlowStatus $status
 * @property string|null $notes
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $company_id
 * @property string|null $employee_open_id
 * @property string|null $employee_close_id
 * @property-read Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User|null $closedBy
 * @property-read \App\Models\Company $company
 * @property-read Collection<int, \App\Models\RemovalOrderDiscount> $discounts
 * @property-read int|null $discounts_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User|null $openedBy
 * @property-read Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read Collection<int, \App\Models\CashFlowTransaction> $transactions
 * @property-read int|null $transactions_count
 * @method static Builder|CashFlow newModelQuery()
 * @method static Builder|CashFlow newQuery()
 * @method static Builder|CashFlow onlyTrashed()
 * @method static Builder|CashFlow query()
 * @method static Builder|CashFlow whereCompanyId($value)
 * @method static Builder|CashFlow whereCreatedAt($value)
 * @method static Builder|CashFlow whereDeletedAt($value)
 * @method static Builder|CashFlow whereEmployeeCloseId($value)
 * @method static Builder|CashFlow whereEmployeeOpenId($value)
 * @method static Builder|CashFlow whereEndDate($value)
 * @method static Builder|CashFlow whereExtraAttributes($value)
 * @method static Builder|CashFlow whereId($value)
 * @method static Builder|CashFlow whereNotes($value)
 * @method static Builder|CashFlow whereStartAmount($value)
 * @method static Builder|CashFlow whereStartDate($value)
 * @method static Builder|CashFlow whereStatus($value)
 * @method static Builder|CashFlow whereUpdatedAt($value)
 * @method static Builder|CashFlow whereWorkDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withExtraAttributes()
 * @method static Builder|CashFlow withTrashed()
 * @method static Builder|CashFlow withoutTrashed()
 * @mixin \Eloquent
 */
class CashFlow extends BaseModelMedia implements CompanyOwned
{
    use BelongToCompany;

    /**
     * The table associated with the model.
     */
    final public const TABLE = 'cash_flows';

    /**
     * Table ID for foreign keys
     */
    final public const FOREIGN_KEY = 'cash_flow_id';

    /**
     * Primary Key
     */
    final public const ATTRIBUTE_ID = 'id';

    /**
     * The Date yyyy-mm-dd for this cash flow work
     */
    final public const ATTRIBUTE_WORK_DATE = 'work_date';
    final public const ATTRIBUTE_START_DATE = 'start_date';
    final public const ATTRIBUTE_END_DATE = 'end_date';
    final public const ATTRIBUTE_START_AMOUNT = 'start_amount';
    final public const ATTRIBUTE_STATUS = 'status';
    final public const ATTRIBUTE_NOTES = 'notes';

    final public const ATTRIBUTE_FK_COMPANY = Company::FOREIGN_KEY;
    final public const ATTRIBUTE_FK_OPEN_EMPLOYEE = 'employee_open_id';
    final public const ATTRIBUTE_FK_CLOSE_EMPLOYEE = 'employee_close_id';

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
        self::ATTRIBUTE_WORK_DATE,
        self::ATTRIBUTE_START_DATE,
        self::ATTRIBUTE_END_DATE,
        self::ATTRIBUTE_START_AMOUNT,
        self::ATTRIBUTE_STATUS,
        self::ATTRIBUTE_NOTES,
        self::ATTRIBUTE_EXTRA_ATTRIBUTES,
        self::ATTRIBUTE_FK_COMPANY,
        self::ATTRIBUTE_FK_OPEN_EMPLOYEE,
        self::ATTRIBUTE_FK_CLOSE_EMPLOYEE,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        self::ATTRIBUTE_WORK_DATE => 'date',
        self::ATTRIBUTE_START_DATE => 'datetime',
        self::ATTRIBUTE_END_DATE => 'datetime',
        self::ATTRIBUTE_START_AMOUNT => 'int',
        self::ATTRIBUTE_STATUS => CashFlowStatus::class,
        self::ATTRIBUTE_NOTES => 'string',
    ];

    /**
     * Get creator of model
     *
     * @return BelongsTo
     */
    public function openedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, self::ATTRIBUTE_FK_OPEN_EMPLOYEE);
    }

    /**
     * Get creator of model
     *
     * @return BelongsTo
     */
    public function closedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, self::ATTRIBUTE_FK_CLOSE_EMPLOYEE);
    }

    /**
     * Get company of model
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(CashFlowTransaction::class, self::FOREIGN_KEY, self::ATTRIBUTE_ID);
    }

    /**
     * Payments
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, self::FOREIGN_KEY, self::ATTRIBUTE_ID);
    }


    public function getPaidPayments(): Builder|HasMany
    {
        return $this->payments()
            ->whereIn(Payment::ATTRIBUTE_STATUS, [Enums\PaymentStatus::Paid->value])
            ->orderBy(Payment::ATTRIBUTE_CREATED_AT, 'desc');
    }

    public static function getCurrentCashFlow(Company $company): ?self
    {
        return self::query()
            ->where(CashFlow::ATTRIBUTE_FK_COMPANY, $company->{self::ATTRIBUTE_ID})
            ->whereDate(self::ATTRIBUTE_WORK_DATE, Carbon::today()->toDateString())
            ->where(self::ATTRIBUTE_STATUS, 'open')
            ->first();
    }


    public function getTotalPaid(): int
    {
        return $this->getPaidPayments()->sum(Payment::ATTRIBUTE_PRICE);
    }


    public function getTotalCashPaid(): int
    {
        $methods = PaymentMethod::query()
            ->whereIn(PaymentMethod::ATTRIBUTE_NAME, ['Dinheiro'])
            ->pluck('id');

        return $this->getPaidPayments()
            ->whereIn(Payment::ATTRIBUTE_FK_PAYMENT_METHOD, $methods)
            ->sum(Payment::ATTRIBUTE_PRICE);
    }

    public function getTotalCardPaid(): int
    {
        $methods = PaymentMethod::query()
            ->whereIn(PaymentMethod::ATTRIBUTE_NAME, [
                'Cartão de Crédito',
                'Cartão de Débito',
            ])
            ->pluck('id');

        return $this->getPaidPayments()
            ->whereIn(Payment::ATTRIBUTE_FK_PAYMENT_METHOD, $methods)
            ->sum(Payment::ATTRIBUTE_PRICE);
    }

    public function getTotalBankPaid(): int
    {
        $methods = PaymentMethod::query()
            ->whereIn(PaymentMethod::ATTRIBUTE_NAME, [
                'TED/DOC',
                'PIX',
                'Boleto',
            ])
            ->pluck('id');

        return $this->getPaidPayments()
            ->whereIn(Payment::ATTRIBUTE_FK_PAYMENT_METHOD, $methods)
            ->sum(Payment::ATTRIBUTE_PRICE);
    }

    public function getPdf(): StreamedResponse {
        $record = $this;

        $company = $record->company;

        /** @var Carbon */
        $now = Carbon::now()->locale('pt-BR');

        $releases = $this->getReleaseOrdersForCashFlow();
        $countReleases = $releases->count();

        $payments = $this->getPaidPayments()->get();
        $discounts = $this->getDiscountsForCashFlow();

        $totalPaid = $record->getTotalPaid(); // Todos os pagamentos

        $totalCashPayments = $record->getTotalCashPaid(); // Pagamentos em Dinheiro
        $initialPrice = $record->{self::ATTRIBUTE_START_AMOUNT};
        $subTotalCash = $totalCashPayments + $initialPrice;
        $cashFluxDiscount = 0;
        $expensesDiscount = 0;
        $totalCash = $subTotalCash + $cashFluxDiscount + $expensesDiscount;
        $totalCardPayments = $record->getTotalCardPaid();
        $totalBankPayments = $record->getTotalBankPaid();
        $totalAllPaymentsExcpCash = $totalCardPayments + $totalBankPayments;

        $html = View::make('reports.cash_flow', [
            'record' => $record,
            'company' => $company,
            'currentDate' => $now->translatedFormat('d \d\e F \d\e Y'),
            'currentAuthName' => Auth::user()->name,
            'openedBy' => $record->openedBy?->name,
            'cashFlowDate' => $record->{self::ATTRIBUTE_WORK_DATE}?->translatedFormat('d \d\e F \d\e Y'),
            'initialPrice' => Str::formatMoney($initialPrice),
            'totalRemovals' => $countReleases,
            'totalCashFlow' => Str::formatMoney($totalPaid), // Valor total recebido em pagamentos
            'totalCashPayments' => Str::formatMoney($totalCashPayments), // Total recebido em Dinheiro
            'subTotalCash' => Str::formatMoney($subTotalCash), // Saldo inicial + Total recebido em Dinheiro
            'cashFluxDiscount' => Str::formatMoney($cashFluxDiscount), // Soma dos descontos de sangria
            'expensesDiscount' => Str::formatMoney($expensesDiscount), // Soma dos descontos de despesa
            'totalCash' => Str::formatMoney($totalCash), // Total em caixa
            'totalCards' => Str::formatMoney($totalCardPayments), // Total recebido em cartão
            'totalBank' => Str::formatMoney($totalBankPayments), // Total recebido via banco
            'totalCardBank' => Str::formatMoney($totalAllPaymentsExcpCash), // Valor total entre cartão e banco
            'cashTransactions' => $record->transactions,
            'discounts' => $discounts,
            'payments' => $payments,
        ])->render();

        //return response()->streamDownload(fn () => print($html), "reseal-{$record->id}.html");

        $shot = Browsershot::html($html)
            ->format('A4')
            ->showBackground()
            ->margins(top: 5, right: 8, bottom: 15, left: 8);

        return response()->streamDownload(
            fn () => print($shot->pdf()),
            "cashflow-{$record->id}.pdf",
            headers: [
                'Content-Type' => 'application/pdf',
            ],
            disposition: 'inline'
        );
    }
}
