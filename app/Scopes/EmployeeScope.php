<?php

declare(strict_types=1);

namespace App\Scopes;

use App\Contracts\CompanyOwned;
use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Special Scope for
 */
class EmployeeScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        /** @var User */
        $user = Auth::user();
        if ($user != null && $model instanceof User) {
            if (!$user->hasAnyRole('super-admin', 'admin')) {
                Log::info('Apply_Company_Scope', [$model, $user]);
                $employees_list = $user->employees()->getQuery()->withoutGlobalScopes([CompanyScope::class, UserScope::class, EmployeeScope::class])->get();
                $employees = $employees_list->map(fn (\App\Models\Employee $model) => $model->{\App\Models\Employee::ATTRIBUTE_FK_COMPANY});
                $builder
                    ->join('employees', $model->getTable() . '.' . 'id', 'employees.user_id')
                    ->whereIn('employees.' . Company::FOREIGN_KEY, $employees);
            }
        }
    }
}
