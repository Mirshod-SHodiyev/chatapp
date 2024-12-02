<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Chat App</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Vue.js va CSS uchun Vite link -->
    </head>
    <body class="font-sans bg-[#edf2f7]">
        <div id="app" data-auth="{{ json_encode(auth()->user()) }}"> <!-- auth foydalanuvchini JSON formatda uzatish -->
            <App /> <!-- Vue.js App komponentini chaqirish -->
        </div>

        <!-- Vue.js ilovasini yuklash -->
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
