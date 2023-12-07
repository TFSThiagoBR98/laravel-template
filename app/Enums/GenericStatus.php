<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

/**
 * Generic Status
 */
enum GenericStatus: string implements HasLabel, HasColor, HasIcon
{
    case Active = 'active';
    case Disabled = 'disabled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'Ativo',
            self::Disabled => 'Desativado',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Active => 'success',
            self::Disabled => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Active => 'heroicon-m-check',
            self::Disabled => 'heroicon-m-x-mark',
        };
    }
}
