<?php

declare(strict_types=1);

namespace App\Policies;

use App\Policies\BasePolicy;

class CashFlowPolicy extends BasePolicy
{
    /**
     * @var string
     */
    protected string $model = \App\Models\CashFlow::class;
}
