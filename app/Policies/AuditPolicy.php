<?php

declare(strict_types=1);

namespace App\Policies;

use App\Policies\BasePolicy;

class AuditPolicy extends BasePolicy
{
    /**
     * @var string
     */
    protected string $model = \App\Models\Audit::class;
}
