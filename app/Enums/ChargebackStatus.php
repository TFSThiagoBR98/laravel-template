<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

/**
 * Generic Status
 */
enum ChargebackStatus: string implements HasLabel, HasColor, HasIcon
{
    case Approved = 'approved';
    case Pending = 'pending';
    case Waiting = 'waiting';
    case Error = 'error';
    case Unknown = 'unknown';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Approved => 'Aprovado',
            self::Waiting => 'Solicitado',
            self::Pending => 'Pendente',
            self::Error => 'Erro no Processamento',
            self::Unknown => 'Desconhecido',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Approved => 'success',
            self::Waiting => 'info',
            self::Pending => 'secondary',
            self::Error => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Approved => 'heroicon-m-check',
            self::Pending => 'heroicon-m-check',
            self::Waiting => 'heroicon-m-check',
            self::Error => 'heroicon-m-check',
            self::Unknown => 'heroicon-m-check',
        };
    }
}
