<?php

declare(strict_types=1);

namespace App\Policies;

use App\Policies\BasePolicy;

class QueueMonitorPolicy extends BasePolicy
{
    /**
     * @var string
     */
    protected string $model = \Croustibat\FilamentJobsMonitor\Models\QueueMonitor::class;
}
