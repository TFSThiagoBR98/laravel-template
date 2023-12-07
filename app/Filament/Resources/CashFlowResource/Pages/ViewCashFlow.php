<?php

namespace App\Filament\Resources\CashFlowResource\Pages;

use App\Filament\Resources\CashFlowResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCashFlow extends ViewRecord
{
    protected static string $resource = CashFlowResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
