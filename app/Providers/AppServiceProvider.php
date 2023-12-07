<?php

namespace App\Providers;

use Akaunting\Money\Currency;
use Akaunting\Money\Money as AkauntingMoney;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Telescope\Telescope;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Telescope::auth(function () {
            /** @var \App\Models\User */
            $user = Auth::user();
            return $user?->hasRole('super-admin') ?? false;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Request::setTrustedProxies(
            ['REMOTE_ADDR'],
            Request::HEADER_X_FORWARDED_FOR
        );

        Validator::extend('full_name', function($attribute, $value)
        {
            if (! is_string($value) && ! is_numeric($value)) {
                return false;
            }

            return preg_match('/^[^(\|\]~`!%#¨^&*=\$\@};:+\"\”\“\/\[\\\\\{\}?><’)]*$/u', $value) > 0;
        });

        Str::macro('masker', function (string $val, string $mask) {
            $maskared = '';
            $k = 0;
            for ($i = 0; $i <= strlen($mask) - 1; $i++) {
                if ($mask[$i] == '#') {
                    if (isset($val[$k]))
                        $maskared .= $val[$k++];
                } else {
                    if (isset($mask[$i]))
                        $maskared .= $mask[$i];
                }
            }
            return $maskared;
        });

        DateTimePicker::configureUsing(fn (DateTimePicker $component) => $component->timezone(config('app.user_timezone')));
        TextColumn::configureUsing(fn (TextColumn $column) => $column->timezone(config('app.user_timezone')));

        /**
         * Calculates the great-circle distance between two points, with
         * the Vincenty formula.
         * @param float $latitudeFrom Latitude of start point in [deg decimal]
         * @param float $longitudeFrom Longitude of start point in [deg decimal]
         * @param float $latitudeTo Latitude of target point in [deg decimal]
         * @param float $longitudeTo Longitude of target point in [deg decimal]
         * @param float $earthRadius Mean earth radius in [m]
         * @return float Distance between points in [m] (same as earthRadius)
         */
        Str::macro('vincentyGreatCircleDistance', function ($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) {
            // convert from degrees to radians
            $latFrom = deg2rad($latitudeFrom);
            $lonFrom = deg2rad($longitudeFrom);
            $latTo = deg2rad($latitudeTo);
            $lonTo = deg2rad($longitudeTo);

            $lonDelta = $lonTo - $lonFrom;
            $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
            $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

            $angle = atan2(sqrt($a), $b);
            return $angle * $earthRadius;
        });

        Str::macro('withoutNumbers', function (string $str) {
            return preg_replace('/[0-9]+/', '', $str);
        });

        Str::macro('onlyNumbers', function (string $str) {
            return preg_replace('/[^0-9]/', '', $str);
        });

        Str::macro('formatPhone', function (string $str) {
            $value = preg_replace('/[^0-9]/', '', $str);
            $mask = strlen($value) > 10 ? '(##) #####-####' : '(##) ####-####';
            return Str::masker($value, $mask);
        });

        Str::macro('formatDdiPhone', function (string $str) {
            $value = preg_replace('/[^0-9]/', '', $str);
            $mask = strlen($value) > 12 ? '+## (##) #####-####' : '+## (##) ####-####';
            return Str::masker($value, $mask);
        });

        Str::macro('formatCep', function (string $str) {
            $value = preg_replace('/[^0-9]/', '', $str);
            $mask = '#####-###';
            return Str::masker($value, $mask);
        });

        Str::macro('formatCpfCnpj', function (string $str) {
            $value = preg_replace('/[^0-9]/', '', $str);
            $mask = strlen($value) > 11 ? '##.###.###/####-##' : '###.###.###-##';
            return Str::masker($value, $mask);
        });

        Str::macro('formatDateTime', function (Carbon $dateTime) {
            $dateTime = $dateTime->setTimezone('America/Sao_Paulo');
            return $dateTime->format('d/m/Y H:i:s');
        });

        Str::macro('formatDateTimeLn', function (Carbon $dateTime) {
            $dateTime = $dateTime->setTimezone('America/Sao_Paulo');
            return $dateTime->format("d/m/Y\nH:i:s");
        });

        Str::macro('formatDate', function (Carbon $dateTime) {
            $dateTime = $dateTime->setTimezone('America/Sao_Paulo');
            return $dateTime->format('d/m/Y');
        });

        Str::macro('formatDateExtended', function (Carbon $dateTime) {
            $dateTime = $dateTime->locale('pt-BR')->setTimezone('America/Sao_Paulo');
            return $dateTime->translatedFormat('d \\d\\e F \\d\\e Y');
        });

        Str::macro('formatTime', function (Carbon $dateTime) {
            $dateTime = $dateTime->setTimezone('America/Sao_Paulo');
            return $dateTime->toTimeString();
        });

        Str::macro('formatSimpleMoney', function (int $money): string {
            return (new AkauntingMoney($money, new Currency('BRL')))->formatSimple();
        });

        Str::macro('formatMoney', function (int $money): string {
            return (new AkauntingMoney($money, new Currency('BRL')))->format();
        });

        Str::macro('moneyToFloat', function (int $money): float {
            return (new AkauntingMoney($money, new Currency('BRL')))->getValue();
        });
    }
}
