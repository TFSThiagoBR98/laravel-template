<?php

declare(strict_types=1);

namespace App\Policies;

use App\Contracts\CompanyOwned;
use App\Contracts\UserOwned;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

abstract class BasePolicy
{
    use HandlesAuthorization;

    /**
     * @var string
     */
    protected string $model;

    /**
     * Get Permission String format
     *
     * @param string $classModel
     * @param string $action
     *
     * @return string
     */
    public static function getPermissionString(string $classModel, string $action): string
    {
        return $classModel . '.' . $action;
    }

    /**
     * @param string $classModel
     * @param array<string> $actions
     *
     * @return array<string>
     */
    public static function getPermissions(string $classModel, array $actions): array
    {
        $permissions = [];

        foreach ($actions as $action) {
            $permissions[] = $action . '_' . $classModel;
        }

        return $permissions;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    /**
     * Get or create permissions
     *
     * @param array<int,string> $names
     *
     * @return array
     */
    public static function findOrCreatePermission($names, $guard = null): array
    {
        $tree = [];
        foreach ($names as $name) {
            $tree[] = Permission::findOrCreate($name, $guard);
        }

        return $tree;
    }

    /**
     * Check permission for models
     *
     * @param User|null $user
     * @param string $action
     * @param Model|null $model
     * @param array|null $args
     *
     * @return bool
     */
    public function checkPermissions(?User $user, string $action, ?Model $model = null, ?array $args = null): bool
    {
        if ($user === null) {
            return false;
        }

        if ($user->hasRole('super-admin')) {
            return true;
        }

        $companyOwned = (new $this->model()) instanceof CompanyOwned;
        $userOwned = (new $this->model()) instanceof UserOwned;
        $permission = $action . '_' . $this->model;

        if ($args !== null && isset($args['id'])) {
            $model = (new $this->model())->find($args['id']);
        }

        // Check if company owned model
        if ($companyOwned) {
            /** @var Company */
            $company = tenancy()->model();

            if ($company !== null) { // Check if company exist
                $employee = Employee::getEmployeeByCompanyIdUserId($company->{Company::ATTRIBUTE_ID}, $user->{User::ATTRIBUTE_ID});
                if ($employee !== null) { // Check if user is from the company
                    // Check if employee can do the action for the company
                    Log::info('permission-check: employee-permissions', [$user, $user->getAllPermissions()]);
                    if ($employee->hasPermissionTo($permission, guardName: 'web')) {
                        return true;
                    }

                    // Fallback to user permission
                    Log::info('permission-check: user-permissions', [$user, $user->getAllPermissions()]);
                    if ($user->hasPermissionTo($permission, guardName: 'web')) {
                        return true;
                    }

                    Log::info('permission-check: employee not allowed', [$user, $action, $model, $args, $company, $permission, $user->getAllPermissions()]);
                } else {
                    Log::info('permission-check: employee not found', [$user, $action, $model, $args, $company]);
                }
            } else {
                Log::info('permission-check: company not found', [$user, $action, $model, $args]);
            }
        } else {
            Log::info('permission-check: not company owned', [$user, $action, $model, $args]);
        }

        // Check if User Owned model
        if ($userOwned) {
            /** @var string|null */
            $userModel = null;
            if ($model !== null) {
                if ($model instanceof UserOwned) {
                    /** @var User */
                    $userModel = $model->{User::FOREIGN_KEY};
                }
            } else {
                if (($args[User::FOREIGN_KEY] ?? null) !== null) {
                    /** @var User|null */
                    $userModel = User::find($args[User::FOREIGN_KEY])->{User::FOREIGN_KEY};
                }
            }

            if ($user->{User::ATTRIBUTE_ID} === $userModel) {
                if ($user->hasPermissionTo($permission, guardName: 'web')) {
                    return true;
                }
                Log::info('permission-check: permission denied on userowned', [$user, $action, $model, $args, $permission]);
            } else {
                Log::info('permission-check: user id do not match owner id', [$user, $action, $model, $args, $user->{User::ATTRIBUTE_ID} === $userModel, $userModel]);
            }
        }

        // Check if user is manipulating itself
        if ($model instanceof User) {
            if ($user->{User::ATTRIBUTE_ID} === $model->{User::ATTRIBUTE_ID}) {
                return true;
            }
        }

        try {
            return $user->hasPermissionTo($permission, guardName: 'web');
        } catch (PermissionDoesNotExist $e) {
            Permission::findOrCreate($permission);
            return $user->hasPermissionTo($permission, guardName: 'web');
        }
    }

    /**
     * Determine whether the user can view any posts.
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function viewAny(?User $user, ?Model $model = null, ?array $injectedArgs = null): bool
    {
        return $this->checkPermissions($user, __FUNCTION__, $model, $injectedArgs);
    }

    /**
     * Determine whether the user can view the users.
     *
     * @param  \App\Models\User $user User who execute the action
     * @param  Model $model User to Quewe
     *
     * @return bool
     */
    public function view(?User $user, ?Model $model = null, ?array $injectedArgs = null): bool
    {
        return $this->checkPermissions($user, __FUNCTION__, $model, $injectedArgs);
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\Models\User $user User who execute the action
     *
     * @return bool
     */
    public function create(?User $user, ?array $injectedArgs = null, ?Model $model = null): bool
    {
        return $this->checkPermissions($user, __FUNCTION__, $model, $injectedArgs);
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\Models\User $user User who execute the action
     * @param  Model $model
     *
     * @return bool
     */
    public function update(?User $user, ?Model $model = null, ?array $injectedArgs = null): bool
    {
        return $this->checkPermissions($user, __FUNCTION__, $model, $injectedArgs);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User $user
     * @param  Model $model
     *
     * @return bool
     */
    public function delete(?User $user, ?Model $model = null, ?array $injectedArgs = null): bool
    {
        return $this->checkPermissions($user, __FUNCTION__, $model, $injectedArgs);
    }

    /**
     * Determine whether the user can delete any model.
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function deleteAny(?User $user, ?Model $model = null, ?array $injectedArgs = null): bool
    {
        return $this->checkPermissions($user, __FUNCTION__, $model, $injectedArgs);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  Model $model
     * @param  array $injectedArgs
     *
     * @return bool
     */
    public function restore(User $user, ?Model $model = null, ?array $injectedArgs = null): bool
    {
        return $this->checkPermissions($user, __FUNCTION__, $model, $injectedArgs);
    }

    /**
     * Determine whether the user can restore any model.
     *
     * @param  \App\Models\User  $user
     * @param  Model $model
     * @param  array $injectedArgs
     *
     * @return bool
     */
    public function restoreAny(User $user, ?Model $model = null, ?array $injectedArgs = null): bool
    {
        return $this->checkPermissions($user, __FUNCTION__, $model, $injectedArgs);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  Model $model
     * @param  array $injectedArgs
     *
     * @return bool
     */
    public function forceDelete(User $user, ?Model $model = null, ?array $injectedArgs = null): bool
    {
        return $this->checkPermissions($user, __FUNCTION__, $model, $injectedArgs);
    }

    /**
     * Determine whether the user can permanently delete any model.
     *
     * @param  \App\Models\User  $user
     * @param  Model $model
     * @param  array $injectedArgs
     *
     * @return bool
     */
    public function forceDeleteAny(User $user, ?Model $model = null, ?array $injectedArgs = null): bool
    {
        return $this->checkPermissions($user, __FUNCTION__, $model, $injectedArgs);
    }

    /**
     * Determine whether the user can replicate the model.
     *
     * @param  \App\Models\User  $user
     * @param  Model $model
     * @param  array $injectedArgs
     *
     * @return bool
     */
    public function replicate(User $user, ?Model $model = null, ?array $injectedArgs = null): bool
    {
        return $this->checkPermissions($user, __FUNCTION__, $model, $injectedArgs);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  Model $model
     * @param  array $injectedArgs
     *
     * @return bool
     */
    public function reorder(User $user, ?Model $model = null, ?array $injectedArgs = null): bool
    {
        return $this->checkPermissions($user, __FUNCTION__, $model, $injectedArgs);
    }

    protected function getModelId(?Model $model): ?string
    {
        return $model?->getKey();
    }
}
