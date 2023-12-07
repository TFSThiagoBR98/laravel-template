<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a Company Owned Model
 *
 * @property string $company_id
 * @property Company $company
 */
interface CompanyOwned
{
    /**
     * Get company of model
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo;
}
