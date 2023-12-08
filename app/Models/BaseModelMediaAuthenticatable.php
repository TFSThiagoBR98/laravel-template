<?php

declare(strict_types=1);

namespace App\Models;

use Bavix\Wallet\Interfaces\Customer;
use Bavix\Wallet\Traits\CanPay;
use Bavix\Wallet\Traits\HasWallets;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail as HasVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use TFSThiagoBR98\LighthouseGraphQLPassport\HasSocialLogin;
use Laragear\TwoFactor\Contracts\TwoFactorAuthenticatable;
use Laragear\TwoFactor\TwoFactorAuthentication;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * BaseModelMediaAuthenticable
 * BaseModelMedia with Authenticable assets
 */
abstract class BaseModelMediaAuthenticatable extends BaseModelMedia implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    FilamentUser,
    TwoFactorAuthenticatable,
    MustVerifyEmail,
    Customer
{
    use Authenticatable;
    use HasApiTokens;
    use Authorizable;
    use CanResetPassword;
    use HasVerifyEmail;
    use CanPay;
    use HasRoles;
    use HasSocialLogin;
    use HasVerifyEmail;
    use HasWallets;
    use Notifiable;
    use AuthenticationLoggable;
    use TwoFactorAuthentication;

    public function canAccessPanel(Panel $panel): bool
    {
        if (! $this->hasVerifiedEmail()) {
            //redirect('verify-email');
            return true;
        } else {
            return true;
        }
    }

    public function canImpersonate()
    {
        return $this->can('impersonate', \App\Models\User::class) || $this->hasRole('super-admin');
    }
}
