<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

/**
 * Generic Status
 */
enum CashFlowTransactionType: string implements HasLabel, HasColor, HasIcon
{
    case Sangria = 'withdraw';
    case Despesa = 'expenses';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Sangria => 'Sangria',
            self::Despesa => 'Despesa',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Sangria => 'danger',
            self::Despesa => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Sangria => 'heroicon-m-check',
            self::Despesa => 'heroicon-m-x-mark',
        };
    }
}
