<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Track PaymentMethod of the Model
 *
 * @property string $payment_method_id
 * @property PaymentMethod $paymentMethod
 *
 * @inheritDoc /App/Models/BaseModelMedia
 * @inherits /App/Models/BaseModelMedia
 */
trait BelongToPaymentMethod
{
    /**
     * Get payment method of model
     *
     * @return BelongsTo
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, PaymentMethod::FOREIGN_KEY);
    }
}
