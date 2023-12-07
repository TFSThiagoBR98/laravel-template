<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <style type="text/css" media="all">
            {!! Vite::content('resources/css/print/print.css') !!}
        </style>

        <style type="text/css" media="all">
            .quebraPagina {
                page-break-after: always;
                page-break-inside: avoid;
            }

            pagebreak {
                page-break-after: always;
                page-break-inside: avoid;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            {{ $slot }}
        </div>
    </body>
</html>
