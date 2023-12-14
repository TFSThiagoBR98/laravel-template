<?php

declare(strict_types=1);

namespace App\Listeners\Employee;

use App\Events\Employee\EmployeeUpdated;

/**
 * Class ReAssignRoleToUser.
 */
class ReAssignRoleToUser
{
    /**
     * Handle the event.
     *
     * @param  EmployeeUpdated  $event
     * @return void
     */
    public function handle(EmployeeUpdated $event): void
    {
        //$user = $event->getModel()->user;
        $event->getModel()->syncRoles([$event->getModel()->role]);
        //$user->syncRoles([$event->getModel()->role]);
    }
}
