<?php

declare(strict_types=1);

namespace App\Policies;

use App\Policies\BasePolicy;

class PaymentMethodPolicy extends BasePolicy
{
    /**
     * @var string
     */
    protected string $model = \App\Models\PaymentMethod::class;
}
