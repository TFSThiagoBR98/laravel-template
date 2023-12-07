<?php

declare(strict_types=1);

namespace App\Models;

use App\Scopes\EmployeeScope;
use App\Scopes\CompanyScope;
use App\Scopes\UserScope;
use App\Enums;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * User model
 *
 * @property Carbon $activated_at
 * @property string $id
 * @property string $name
 * @property string $tax_id
 * @property string|null $phone
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes|null $extra_attributes
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $avatar
 * @property string|null $theme
 * @property string|null $theme_color
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $employees
 * @property-read int|null $employees_count
 * @property-read string $balance
 * @property-read int $balance_int
 * @property-read \Bavix\Wallet\Models\Wallet $wallet
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Joselfonseca\LighthouseGraphQLPassport\Models\SocialProvider> $socialProviders
 * @property-read int|null $social_providers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Bavix\Wallet\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Bavix\Wallet\Models\Transfer> $transfers
 * @property-read int|null $transfers_count
 * @property-read \Laragear\TwoFactor\Models\TwoFactorAuthentication $twoFactorAuth
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Bavix\Wallet\Models\Transaction> $walletTransactions
 * @property-read int|null $wallet_transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Bavix\Wallet\Models\Wallet> $wallets
 * @property-read int|null $wallets_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModelMediaAuthenticatable permission($permissions)
 * @method static Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModelMediaAuthenticatable role($roles, $guard = null)
 * @method static Builder|User whereActivatedAt($value)
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereExtraAttributes($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereTaxNumber($value)
 * @method static Builder|User whereTheme($value)
 * @method static Builder|User whereThemeColor($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withExtraAttributes()
 * @method static Builder|User withTrashed()
 * @method static Builder|User withoutTrashed()
 * @method static Builder|User whereTaxId($value)
 * @mixin \Eloquent
 */
class User extends BaseModelMediaAuthenticatable
{
    /**
     * The table associated with the model.
     */
    final public const TABLE = 'users';

    /**
     * Table ID for foreign keys
     */
    final public const FOREIGN_KEY = 'user_id';

    /**
     * Primary Key
     */
    final public const ATTRIBUTE_ID = 'id';

    final public const ATTRIBUTE_NAME = 'name';
    final public const ATTRIBUTE_TAX_ID = 'tax_id';
    final public const ATTRIBUTE_EMAIL = 'email';
    final public const ATTRIBUTE_PHONE = 'phone';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'tax_id',
        'phone',
        'email',
        'password',
        'email_verified_at',
        'activated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Default Guard for the model
     *
     * @var string
     */
    protected $guard_name = 'web';

    /**
     * Companies of User
     *
     * @return HasMany
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, self::FOREIGN_KEY, self::ATTRIBUTE_ID)
            ->withoutGlobalScopes([CompanyScope::class, UserScope::class, EmployeeScope::class]);
    }

    /**
     * Activate user
     *
     * @return void
     */
    public function activate(): void
    {
        $this->activated_at = Carbon::now();
        $this->save();
    }

    /**
     * Deactivate user
     *
     * @return void
     */
    public function deactivate(): void
    {
        $this->activated_at = null;
        $this->save();
    }
}
