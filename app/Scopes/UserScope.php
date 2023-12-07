<?php

declare(strict_types=1);

namespace App\Scopes;

use App\Contracts\UserOwned;
use App\Models\User;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserScope implements Scope
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
        if ($user != null && $model instanceof UserOwned) {
            if (!$user->hasAnyRole('super-admin', 'admin')) {
                $builder->where($model->getTable() . '.' . User::FOREIGN_KEY, $user);
            }
        }
    }
}
