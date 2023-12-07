<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Track Payment of the Model
 *
 * @property string $payment_id
 * @property Payment $payment
 *
 * @inheritDoc /App/Models/BaseModelMedia
 * @inherits /App/Models/BaseModelMedia
 */
trait BelongToPayment
{
    /**
     * Get payment method of model
     *
     * @return BelongsTo
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, Payment::FOREIGN_KEY);
    }
}
