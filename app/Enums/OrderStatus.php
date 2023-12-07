<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

/**
 * Generic Status
 */
enum OrderStatus: string implements HasLabel, HasColor, HasIcon
{
    case Paid = 'paid';
    case Waiting = 'waiting';
    case Chargeback = 'chargeback';
    case Error = 'error';
    case Canceled = 'canceled';
    case Preparing = 'preparing';
    case Shipped = 'shipped';
    case Complete = 'complete';
    case Unknown = 'unknown';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Paid => 'Pago',
            self::Waiting => 'Aguardando Pagamento',
            self::Error => 'Erro no Processamento',
            self::Chargeback => 'Estornado',
            self::Canceled => 'Cancelado',
            self::Preparing => 'Preparando para Envio',
            self::Shipped => 'Enviado',
            self::Complete => 'Entrega Concluída',
            self::Unknown => 'Desconhecido',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Paid => 'success',
            self::Waiting => 'info',
            self::Chargeback => 'danger',
            self::Error => 'danger',
            self::Canceled => 'warning',
            self::Preparing => 'warning',
            self::Shipped => 'warning',
            self::Complete => 'success',
            self::Unknown => '',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Paid => 'heroicon-m-check',
            self::Chargeback => 'heroicon-m-check',
            self::Error => 'heroicon-m-check',
            self::Waiting => 'heroicon-m-check',
            self::Canceled => 'heroicon-m-check',
            self::Unknown => 'heroicon-m-check',
            self::Preparing => 'heroicon-m-check',
            self::Shipped => 'heroicon-m-check',
            self::Complete => 'heroicon-m-check',
        };
    }
}
