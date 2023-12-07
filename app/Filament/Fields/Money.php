<?php

namespace App\Filament\Fields;

use Closure;
use Akaunting\Money\Currency;
use Akaunting\Money\Money as AkauntingMoney;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;

class Money extends TextInput
{
    protected string|int|float|null $initialValue = '0,00';

    protected function setUp(): void
    {
        $this
            ->prefix('R$')
            ->maxLength(13)
            ->extraAlpineAttributes([
                'x-on:keypress' => 'function() {
                        var charCode = event.keyCode || event.which;
                        if (charCode < 48 || charCode > 57) {
                            event.preventDefault();
                            return false;
                        }
                        return true;
                    }',
                'x-on:keyup' => 'function() {
                        var money = $el.value;
                        money = money.replace(/\D/g, \'\');
                        money = (parseFloat(money) / 100).toLocaleString(\'pt-BR\', { minimumFractionDigits: 2 });
                        $el.value = money === \'NaN\' ? \'0,00\' : money;
                    }',
                'x-on:blur' => 'function() {
                    var money = $el.value;
                    money = money.replace(/\D/g, \'\');
                    money = (parseFloat(money) / 100).toLocaleString(\'pt-BR\', { minimumFractionDigits: 2 });
                    $el.value = money === \'NaN\' ? \'0,00\' : money;
                }',
            ])
            ->dehydrateMask()
            ->default(0.00)
            ->formatStateUsing(function ($state) {
                if (blank($state)) {
                    return $this->initialValue;
                }

                $mon = new AkauntingMoney($state, new Currency('BRL'));
                return $mon->formatSimple();
            });

    }

    public function dehydrateMask(bool|Closure $condition = true): static
    {
        if ($condition) {
            $this->dehydrateStateUsing(function ($state): ?int {
                if (blank($state)) {
                    return null;
                }

                return intval(Str::onlyNumbers($state));
            });
        } else {
            $this->dehydrateStateUsing(function ($state): ?string {
                if (blank($state)) {
                    return null;
                }

                $mon = new AkauntingMoney(Str::onlyNumbers($state), new Currency('BRL'));
                return $mon->formatSimple();
            });
        }

        return $this;
    }

    public function initialValue(null|string|int|float|Closure $value = '0,00'): static
    {
        $this->initialValue = $value;

        return $this;
    }
}
