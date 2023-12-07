<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Track Order of the Model
 *
 * @property string $order_id
 * @property Order $order
 *
 * @inheritDoc /App/Models/BaseModelMedia
 * @inherits /App/Models/BaseModelMedia
 */
trait BelongToOrder
{
    /**
     * Get company of model
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, Order::FOREIGN_KEY);
    }
}
