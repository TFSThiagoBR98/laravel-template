<?php

namespace App\Concerns;

use App\Models\Company;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

trait HasCompany
{
    /**
     * Boot
     *
     * @return void
     */
    public static function bootBelongToCompany(): void
    {
        self::creating(function (Model $model) {
            $col = static::getCompanyColumnName();
            if ($model->hasCompanyColumn()) {
                if (!$model->{$col}) {
                    if (Auth::check()) {
                        $tennant = Filament::getTenant() ?? Auth::user()->companies->first();
                        $model->{$col} = $tennant?->getKey();
                    } else {
                        $model->{$col} = null;
                    }
                }
            }
        });

        static::addGlobalScope('company', function (Builder $query) {
            if ($this->hasCompanyColumn()) {
                $user = Auth::user();
                if ($user) {
                    $query->whereBelongsTo($user->companies)
                        ->orWhereNull(static::getCompanyColumnName());
                } else  {
                    $query->whereNull(static::getCompanyColumnName());
                }
            }
        });
    }

    public static function getCompanyColumnName(): string
    {
        return 'company_id';
    }

    public function hasCompanyColumn(): bool
    {
        return Schema::hasColumn($this->getModel()->getTable(), $this->getCompanyColumnName());
    }

    /**
     * Get company of model
     *
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, $this->getCompanyColumnName());
    }
}
