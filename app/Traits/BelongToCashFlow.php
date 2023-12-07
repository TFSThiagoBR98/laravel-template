<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\CashFlow;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Track CashFlow of the Model
 *
 * @property string $cash_flow_id
 * @property CashFlow $cashFlow
 *
 * @inherits /App/Models/BaseModelMedia
 */
trait BelongToCashFlow
{
    /**
     * Get company of model
     *
     * @return BelongsTo
     */
    public function cashFlow(): BelongsTo
    {

        return $this->belongsTo(CashFlow::class, CashFlow::FOREIGN_KEY);
    }
}
