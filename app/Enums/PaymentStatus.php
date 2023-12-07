<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

/**
 * Generic Status
 */
enum PaymentStatus: string implements HasLabel, HasColor, HasIcon
{
    case Paid = 'paid';
    case Pending = 'pending';
    case Waiting = 'waiting';
    case Chargeback = 'chargeback';
    case Refunded = 'refunded';
    case Rejected = 'rejected';
    case Error = 'error';
    case Canceled = 'canceled';
    case Unknown = 'unknown';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Paid => 'Pago',
            self::Waiting => 'Aguardando Pagamento',
            self::Pending => 'Pendente de Criação',
            self::Error => 'Erro no Processamento',
            self::Refunded => 'Reembolsado',
            self::Rejected => 'Pagamento Recusado',
            self::Chargeback => 'Estornado',
            self::Canceled => 'Cancelado',
            self::Unknown => 'Desconhecido',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Paid => 'success',
            self::Waiting => 'info',
            self::Pending => 'secondary',
            self::Chargeback => 'danger',
            self::Error => 'danger',
            self::Refunded => 'danger',
            self::Rejected => 'danger',
            self::Canceled => 'warning',
            self::Unknown => '',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Paid => 'heroicon-m-check',
            self::Pending => 'heroicon-m-check',
            self::Chargeback => 'heroicon-m-check',
            self::Error => 'heroicon-m-check',
            self::Refunded => 'heroicon-m-check',
            self::Rejected => 'heroicon-m-check',
            self::Waiting => 'heroicon-m-check',
            self::Canceled => 'heroicon-m-check',
            self::Unknown => 'heroicon-m-check',
        };
    }
}
