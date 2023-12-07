<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Company;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Track Company of the Model
 *
 * @property string $company_id
 * @property Company $company
 */
trait BelongToCompany
{
    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootBelongToCompany(): void
    {
        static::addGlobalScope(new CompanyScope());
    }

    /**
     * Get company of model
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, Company::FOREIGN_KEY);
    }
}
