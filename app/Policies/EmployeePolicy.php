<?php

declare(strict_types=1);

namespace App\Policies;

use App\Policies\BasePolicy;

class EmployeePolicy extends BasePolicy
{
    /**
     * @var string
     */
    protected string $model = \App\Models\Employee::class;
}
