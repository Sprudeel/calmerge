<!DOCTYPE html>
<html lang="de" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hilfe - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased h-full flex flex-col">
    <div class="flex-1 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h1 class="text-3xl font-bold">So verwenden Sie Ihren Kalender-Feed</h1>
                </div>

                <div class="p-6 space-y-8">
                    <!-- Introduction -->
                    <div>
                        <p class="text-gray-700">
                            Sie haben zwei Möglichkeiten, Ihren zusammengeführten Kalender zu nutzen: <strong>Abonnieren</strong>, um ihn automatisch aktuell zu halten, oder eine <strong>Momentaufnahme herunterladen</strong> für einen einmaligen Import.
                        </p>
                    </div>

                    <!-- Subscribe vs Download -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                        <h3 class="font-bold text-blue-900 mb-2">📡 Abonnieren (Empfohlen)</h3>
                        <p class="text-sm text-blue-800">
                            Durch das Abonnieren bleibt Ihr Kalender automatisch aktuell. Alle Änderungen an den Quellkalendern werden in Ihrer Kalender-App angezeigt.
                        </p>
                    </div>

                    <div class="bg-green-50 border-l-4 border-green-500 p-4">
                        <h3 class="font-bold text-green-900 mb-2">💾 Momentaufnahme herunterladen</h3>
                        <p class="text-sm text-green-800">
                            Beim Herunterladen wird eine einmalige Kopie erstellt. Ereignisse werden nicht automatisch aktualisiert, können aber in jede Kalender-App importiert werden.
                        </p>
                    </div>

                    <!-- Apple Calendar -->
                    <div class="border-t pt-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-8 h-8 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/>
                            </svg>
                            Apple Kalender (macOS/iOS)
                        </h2>
                        <div class="space-y-4 ml-10">
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">Zum Abonnieren:</h3>
                                <ol class="list-decimal list-inside space-y-1 text-gray-700">
                                    <li>Öffnen Sie die Kalender-App</li>
                                    <li>Gehen Sie zu <strong>Ablage → Neues Kalenderabonnement</strong> (macOS) oder <strong>Einstellungen → Kalender → Account hinzufügen → Andere → Abonnierten Kalender hinzufügen</strong> (iOS)</li>
                                    <li>Fügen Sie Ihre Kalender-URL ein</li>
                                    <li>Klicken Sie auf <strong>Abonnieren</strong></li>
                                    <li>Wählen Sie die Aktualisierungshäufigkeit und klicken Sie auf <strong>OK</strong></li>
                                </ol>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">Heruntergeladene Datei importieren:</h3>
                                <ol class="list-decimal list-inside space-y-1 text-gray-700">
                                    <li>Laden Sie die Momentaufnahme herunter</li>
                                    <li>Doppelklicken Sie auf die .ics-Datei oder ziehen Sie sie in die Kalender-App</li>
                                    <li>Wählen Sie aus, in welchen Kalender importiert werden soll</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Google Calendar -->
                    <div class="border-t pt-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-8 h-8 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="#4285F4"/>
                            </svg>
                            Google Kalender
                        </h2>
                        <div class="space-y-4 ml-10">
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">Zum Abonnieren:</h3>
                                <ol class="list-decimal list-inside space-y-1 text-gray-700">
                                    <li>Öffnen Sie <a href="https://calendar.google.com" target="_blank" class="text-blue-600 hover:underline">Google Kalender</a></li>
                                    <li>Klicken Sie in der linken Seitenleiste auf das <strong>+</strong> neben "Weitere Kalender"</li>
                                    <li>Wählen Sie <strong>Per URL</strong></li>
                                    <li>Fügen Sie Ihre Kalender-URL ein</li>
                                    <li>Klicken Sie auf <strong>Kalender hinzufügen</strong></li>
                                </ol>
                                <p class="text-sm text-gray-600 mt-2">Hinweis: Google Kalender kann mehrere Stunden für die Synchronisierung benötigen.</p>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">Heruntergeladene Datei importieren:</h3>
                                <ol class="list-decimal list-inside space-y-1 text-gray-700">
                                    <li>Laden Sie die Momentaufnahme herunter</li>
                                    <li>Klicken Sie in Google Kalender auf das Zahnrad-Symbol → <strong>Einstellungen</strong></li>
                                    <li>Klicken Sie in der linken Seitenleiste auf <strong>Importieren & Exportieren</strong></li>
                                    <li>Klicken Sie auf <strong>Datei von Ihrem Computer auswählen</strong></li>
                                    <li>Wählen Sie Ihre heruntergeladene .ics-Datei</li>
                                    <li>Wählen Sie aus, in welchen Kalender importiert werden soll</li>
                                    <li>Klicken Sie auf <strong>Importieren</strong></li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Outlook -->
                    <div class="border-t pt-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-8 h-8 mr-2" viewBox="0 0 24 24" fill="#0078D4">
                                <path d="M7 2h10a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm5 4a5 5 0 1 0 0 10 5 5 0 0 0 0-10z"/>
                            </svg>
                            Outlook
                        </h2>
                        <div class="space-y-4 ml-10">
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">Zum Abonnieren (Outlook.com):</h3>
                                <ol class="list-decimal list-inside space-y-1 text-gray-700">
                                    <li>Öffnen Sie <a href="https://outlook.live.com/calendar" target="_blank" class="text-blue-600 hover:underline">Outlook Kalender</a></li>
                                    <li>Klicken Sie auf <strong>Kalender hinzufügen</strong></li>
                                    <li>Wählen Sie <strong>Aus dem Web abonnieren</strong></li>
                                    <li>Fügen Sie Ihre Kalender-URL ein</li>
                                    <li>Geben Sie einen Namen ein und klicken Sie auf <strong>Importieren</strong></li>
                                </ol>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">Zum Abonnieren (Outlook Desktop):</h3>
                                <ol class="list-decimal list-inside space-y-1 text-gray-700">
                                    <li>Gehen Sie zu <strong>Datei → Kontoeinstellungen → Kontoeinstellungen</strong></li>
                                    <li>Wählen Sie die Registerkarte <strong>Internetkalender</strong></li>
                                    <li>Klicken Sie auf <strong>Neu</strong></li>
                                    <li>Fügen Sie Ihre Kalender-URL ein und klicken Sie auf <strong>Hinzufügen</strong></li>
                                </ol>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">Heruntergeladene Datei importieren:</h3>
                                <ol class="list-decimal list-inside space-y-1 text-gray-700">
                                    <li>Laden Sie die Momentaufnahme herunter</li>
                                    <li>Gehen Sie zu <strong>Datei → Öffnen und Exportieren → Importieren/Exportieren</strong></li>
                                    <li>Wählen Sie <strong>iCalendar-Datei (.ics) importieren</strong></li>
                                    <li>Navigieren Sie zu Ihrer heruntergeladenen Datei</li>
                                    <li>Klicken Sie auf <strong>OK</strong></li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Troubleshooting -->
                    <div class="border-t pt-6 bg-yellow-50 p-4 rounded">
                        <h2 class="text-xl font-bold text-gray-900 mb-3">💡 Fehlerbehebung</h2>
                        <ul class="list-disc list-inside space-y-2 text-gray-700">
                            <li><strong>Kalender wird nicht aktualisiert?</strong> Die meisten Apps aktualisieren abonnierte Kalender alle paar Stunden. Überprüfen Sie die Synchronisierungseinstellungen Ihrer App.</li>
                            <li><strong>Ereignisse fehlen?</strong> Stellen Sie sicher, dass Sie beim Erstellen des Feeds alle gewünschten Kalender ausgewählt haben.</li>
                            <li><strong>Feed aktualisieren?</strong> Erstellen Sie einen neuen Feed mit den gewünschten Kalendern und aktualisieren Sie die Abonnement-URL in Ihrer Kalender-App.</li>
                        </ul>
                    </div>

                    <!-- Back button -->
                    <div class="text-center pt-4">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Zurück zur Kalenderauswahl
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer />
</body>
</html>
