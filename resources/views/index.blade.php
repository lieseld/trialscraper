<!doctype html>
<html lang="en" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TrialScraper</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @livewireScripts
    @livewireStyles
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body class="dark:bg-gray-900 flex items-center justify-center h-screen">
    <livewire:app-component/>
</body>
</html>
