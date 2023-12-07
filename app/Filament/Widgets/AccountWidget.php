<?php

namespace App\Filament\Widgets;

use Filament\Widgets\AccountWidget as BaseAccountWidget;

class AccountWidget extends BaseAccountWidget
{
    /**
     * @var int | string | array<string, int | null>
     */
    protected int | string | array $columnSpan = 'full';
}
