<footer class="mt-auto">

    <!-- Footer content -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex gap-4 items-center text-center md:text-left">
                    <p class="text-sm">
                        <strong>CalMerge</strong>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        Version {{ env('APP_VERSION') }} | Made by <a href="https://github.com/Sprudeel" class="text-blue-400 hover:text-blue-300">Sprudeel</a>
                    </p>
                </div>
                <div class="text-center md:text-right">
                    <a href="{{ route('help') }}" class="text-sm text-blue-400 hover:text-blue-300 mr-4">
                        Hilfe & Anleitungen
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Repeating wartmenschli image -->
    <div class="h-16 bg-repeat-x bg-center" style="background-image: url('{{ asset('images/wartmenschli.png') }}'); background-size: auto 100%;"></div>
</footer>
