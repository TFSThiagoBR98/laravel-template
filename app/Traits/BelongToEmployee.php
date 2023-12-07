<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Track Employee of the Model
 *
 * @property string $employee_id
 * @property Employee $employee
 *
 * @inheritDoc /App/Models/BaseModelMedia
 * @inherits /App/Models/BaseModelMedia
 */
trait BelongToEmployee
{
    /**
     * Get company of model
     *
     * @return BelongsTo
     */
    public function employee(): BelongsTo
    {

        return $this->belongsTo(Employee::class, Employee::FOREIGN_KEY);
    }
}
