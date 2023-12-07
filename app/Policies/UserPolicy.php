<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Policies\BasePolicy;

class UserPolicy extends BasePolicy
{
    /**
     * @var string
     */
    protected string $model = \App\Models\User::class;

    /**
     * Determine whether the user can impersonate other users.
     *
     * @param  \App\Models\User $user User who execute the action
     *
     * @return bool
     */
    public function impersonate(?User $user, ?array $injectedArgs = null, ?Model $model = null): bool
    {
        return $this->checkPermissions($user, __FUNCTION__, $model, $injectedArgs);
    }
}
