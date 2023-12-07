<?php

declare(strict_types=1);

namespace App\Events\Employee;

use App\Events\Base\BaseUpdatedEvent;
use App\Models\Employee;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;

/**
 * Class EmployeeUpdated.
 *
 * @extends BaseUpdatedEvent<Employee>
 */
class EmployeeUpdated extends BaseUpdatedEvent
{
    /**
     * Create a new event instance.
     *
     * @param  Employee  $model
     */
    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }

    /**
     * Get the model that has fired this event.
     *
     * @return Employee
     */
    public function getModel(): Employee
    {
        return $this->model;
    }
}
