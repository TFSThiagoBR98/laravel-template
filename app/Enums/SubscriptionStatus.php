<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

/**
 * Subscription Status
 */
enum SubscriptionStatus: string implements HasLabel, HasColor, HasIcon
{
    case Active = 'active';
    case Trialing = 'trialing';
    case PastDue = 'past_due';
    case Paused = 'paused';
    case Canceled = 'canceled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'Ativo',
            self::Trialing => 'Em Teste',
            self::PastDue => 'Pagamento em Atraso',
            self::Paused => 'Pausado',
            self::Canceled => 'Cancelado',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Active => 'success',
            self::Trialing => 'info',
            self::PastDue => 'danger',
            self::Paused => 'warning',
            self::Canceled => 'gray',

        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Active => 'heroicon-m-check',
            self::Active => 'heroicon-m-check',
            self::Trialing => 'heroicon-m-check',
            self::PastDue => 'heroicon-m-check',
            self::Paused => 'heroicon-m-check',
            self::Canceled => 'heroicon-m-check',
        };
    }
}
