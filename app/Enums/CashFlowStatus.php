<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

/**
 * Generic Status
 */
enum CashFlowStatus: string implements HasLabel, HasColor, HasIcon
{
    case Open = 'open';
    case Close = 'close';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Open => 'Aberto',
            self::Close => 'Fechado',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Open => 'success',
            self::Close => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Open => 'heroicon-m-check',
            self::Close => 'heroicon-m-x-mark',
        };
    }
}
