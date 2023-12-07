<?php

declare(strict_types=1);

namespace App\Events\Employee;

use App\Events\Base\BaseCreatedEvent;
use App\Models\Employee;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;

/**
 * Class EmployeeCreated.
 *
 * @extends BaseCreatedEvent<Employee>
 */
class EmployeeCreated extends BaseCreatedEvent
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
