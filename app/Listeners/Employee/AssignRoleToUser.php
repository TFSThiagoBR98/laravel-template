<?php

declare(strict_types=1);

namespace App\Listeners\Employee;

use App\Events\Employee\EmployeeCreated;

/**
 * Class AssignRoleToUser.
 */
class AssignRoleToUser
{
    /**
     * Handle the event.
     *
     * @param  EmployeeCreated  $event
     * @return void
     */
    public function handle(EmployeeCreated $event): void
    {
        $user = $event->getModel()->user;
        $event->getModel()->assignRole($event->getModel()->role);
        $user->assignRole($event->getModel()->role);
    }
}
