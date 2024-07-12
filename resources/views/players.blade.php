<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            Saloon v3 - Demo App
        </title>

        <link
            rel="stylesheet"
            href="{{ asset('css/app.css') }}"
        />
    </head>
    <body class="w-full h-full bg-green-600">
        <h1>List of Players</h1>

        @if (!empty($all_players))
            <ul>
                @foreach ($all_players['data'] as $player)
                    <img src="{{ $player['image_path'] }}">
                    <div>{{ $player['name'] }}</div>
                @endforeach
            </ul>
        @else
            <p>No players found.</p>
        @endif

        <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
            Developed by William Ferreira @ Singlesoftware
        </div>
    </body>
</html>
