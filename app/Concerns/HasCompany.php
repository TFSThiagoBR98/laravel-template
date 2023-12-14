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
    public static function bootHasCompany(): void
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
            if (static::hasCompanyColumn()) {
                $user = Auth::user();
                if ($user) {
                    $model = tenancy()->tenant;
                    if ($model == null) {
                        if (! $user->hasRole('super-admin')) {
                            $query->whereNull(static::getCompanyColumnName());
                        }
                    } else {
                        $query->whereBelongsTo($model, 'company')
                            ->orWhereNull(static::getCompanyColumnName());
                    }
                } else  {
                    $query->whereNull(static::getCompanyColumnName());
                }
            } else {
                $user = Auth::user();
            }
        });
    }

    public static function getCompanyColumnName(): string
    {
        return 'company_id';
    }

    public static function hasCompanyColumn(): bool
    {
        $table = static::getModel()->getTable();
        $column = static::getCompanyColumnName();
        return Schema::setConnection(static::getModel()->newModelQuery()->getConnection())
            ->hasColumn($table, $column);
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
