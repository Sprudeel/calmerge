<!DOCTYPE html>
<html lang="de" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased h-full flex flex-col">
    <div class="flex-1 flex flex-col items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-2xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg text-center">
            <h1 class="text-2xl font-bold mb-4">Ihr zusammengeführter Kalender-Feed</h1>
            
            <p class="text-gray-600 mb-6">Abonnieren Sie diese URL in Ihrer Kalender-App:</p>

            <div class="bg-gray-100 p-4 rounded mb-6 break-all">
                <code class="text-lg text-blue-600">{{ url('/sharedcal/' . $feed->token) }}</code>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-6">
                <a href="{{ route('download.calendar', $feed->token) }}" class="inline-flex items-center justify-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Momentaufnahme herunterladen
                </a>
                <a href="{{ route('help') }}" class="inline-flex items-center justify-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Anleitung zum Abonnieren
                </a>
            </div>

            <a href="{{ route('home') }}" class="text-blue-500 hover:text-blue-700 underline">Weiteren Feed erstellen</a>
        </div>
    </div>

    <x-footer />
</body>
</html>
