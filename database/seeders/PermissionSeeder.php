<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\AcquirerTransaction;
use App\Models\CashFlow;
use App\Models\CashFlowTransaction;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Policies\AuditPolicy;
use App\Policies\BasePolicy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PermissionSeeder extends Seeder
{
    /**
     * @return array<string,array<string>>
     */
    public function getRolesWeb(): array
    {
        return [
            'super-admin' => array_merge(
                BasePolicy::getPermissions(
                    Role::class,
                    [
                        'viewAny',
                        'view',
                        'create',
                        'update',
                        'delete',
                        'restore',
                        'forceDelete'
                    ]
                ),
                BasePolicy::getPermissions(
                    Permission::class,
                    [
                        'viewAny',
                        'view',
                        'create',
                        'update',
                        'delete',
                        'restore',
                        'forceDelete'
                    ]
                ),
                BasePolicy::getPermissions(
                    Media::class,
                    [
                        'viewAny',
                        'view',
                        'create',
                        'update',
                        'delete',
                        'restore',
                        'forceDelete'
                    ]
                ),
                BasePolicy::getPermissions(
                    User::class,
                    [
                        'viewAny',
                        'view',
                        'create',
                        'update',
                        'delete',
                        'restore',
                        'forceDelete'
                    ]
                ),
                BasePolicy::getPermissions(
                    Company::class,
                    [
                        'viewAny',
                        'view',
                        'create',
                        'update',
                        'delete',
                        'restore',
                        'forceDelete'
                    ]
                ),
                BasePolicy::getPermissions(
                    Employee::class,
                    [
                        'viewAny',
                        'view',
                        'create',
                        'update',
                        'delete',
                        'restore',
                        'forceDelete'
                    ]
                ),
                BasePolicy::getPermissions(
                    AcquirerTransaction::class,
                    [
                        'viewAny',
                        'view',
                        'create',
                        'update',
                        'delete',
                        'restore',
                        'forceDelete'
                    ]
                ),
                BasePolicy::getPermissions(
                    AuditPolicy::class,
                    [
                        'viewAny',
                        'view',
                        'create',
                        'update',
                        'delete',
                        'restore',
                        'forceDelete'
                    ]
                ),
                BasePolicy::getPermissions(
                    CashFlow::class,
                    [
                        'viewAny',
                        'view',
                        'create',
                        'update',
                        'delete',
                        'restore',
                        'forceDelete'
                    ]
                ),
                BasePolicy::getPermissions(
                    CashFlowTransaction::class,
                    [
                        'viewAny',
                        'view',
                        'create',
                        'update',
                        'delete',
                        'restore',
                        'forceDelete'
                    ]
                ),
                BasePolicy::getPermissions(
                    Media::class,
                    [
                        'viewAny',
                        'view',
                        'create',
                        'update',
                        'delete',
                        'restore',
                        'forceDelete'
                    ]
                ),
                BasePolicy::getPermissions(
                    PaymentMethod::class,
                    [
                        'viewAny',
                        'view',
                        'create',
                        'update',
                        'delete',
                        'restore',
                        'forceDelete'
                    ]
                ),
                BasePolicy::getPermissions(
                    Payment::class,
                    [
                        'viewAny',
                        'view',
                        'create',
                        'update',
                        'delete',
                        'restore',
                        'forceDelete'
                    ]
                ),
            ),
            'minimal' => array_merge(
                BasePolicy::getPermissions(
                    User::class,
                    [
                        'update',
                    ]
                ),
            ),
        ];
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->truncateTables();

        $roles = $this->getRolesWeb();
        foreach ($roles as $role => $permissions) {
            $this->command->info("Register web permissions for $role");
            /** @var Role */
            $rol = Role::findOrCreate($role);
            $rol->givePermissionTo(BasePolicy::findOrCreatePermission($permissions));
        }
    }

    /**
     * Truncate Tables
     *
     * @return void
     */
    public function truncateTables(): void
    {
        $this->command->info('Truncating User, Role and Permission tables');
        Schema::disableForeignKeyConstraints();

        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();

        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();

        Schema::enableForeignKeyConstraints();
    }
}
