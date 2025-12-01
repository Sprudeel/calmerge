<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Calendar Source') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('calendar-sources.update', $calendarSource) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('name', $calendarSource->name) }}" required>
                            @error('name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="ics_url" class="block text-gray-700 text-sm font-bold mb-2">ICS URL:</label>
                            <input type="url" name="ics_url" id="ics_url" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('ics_url', $calendarSource->ics_url) }}" required>
                            @error('ics_url')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="access_token" class="block text-gray-700 text-sm font-bold mb-2">Access Token (Optional):</label>
                            <p class="text-gray-600 text-xs mb-2">If set, this calendar will only be visible on the public page when the token is in the URL (?token=yourtoken)</p>
                            <input type="text" name="access_token" id="access_token" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('access_token', $calendarSource->access_token) }}" placeholder="e.g., secret123">
                            @error('access_token')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Groups (Optional):</label>
                            <div class="space-y-2">
                                @foreach($groups as $group)
                                    <label class="inline-flex items-center mr-4">
                                        <input type="checkbox" name="groups[]" value="{{ $group->id }}" class="form-checkbox h-4 w-4 text-blue-600" {{ in_array($group->id, old('groups', $calendarSource->groups->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">{{ $group->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @if($groups->isEmpty())
                                <p class="text-gray-500 text-xs italic">No groups available. <a href="{{ route('groups.create') }}" class="text-blue-500 hover:text-blue-700">Create one</a></p>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update Source
                            </button>
                            <a href="{{ route('calendar-sources.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
