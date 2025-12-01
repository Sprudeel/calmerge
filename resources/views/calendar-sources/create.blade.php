<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Calendar Source') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('calendar-sources.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                <label for="ics_url" class="block text-gray-700 text-sm font-bold mb-2">ICS URL:</label>
                <div class="flex gap-2">
                    <input type="url" name="ics_url" id="ics_url" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <button type="button" id="test-url-btn" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline whitespace-nowrap">
                        Test URL
                    </button>
                </div>
                @error('ics_url')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div id="preview-container" class="hidden mb-6 p-4 bg-gray-50 rounded border">
                <h3 class="font-bold text-sm mb-2">Preview (First 5 Events)</h3>
                <div id="preview-content" class="text-xs text-gray-600 space-y-1"></div>
                <p id="preview-error" class="text-red-500 text-xs hidden"></p>
            </div>

            <script>
                document.getElementById('test-url-btn').addEventListener('click', async function() {
                    const urlInput = document.getElementById('ics_url');
                    const btn = this;
                    const container = document.getElementById('preview-container');
                    const content = document.getElementById('preview-content');
                    const errorMsg = document.getElementById('preview-error');

                    if (!urlInput.value) {
                        alert('Please enter a URL first.');
                        return;
                    }

                    btn.disabled = true;
                    btn.innerText = 'Testing...';
                    container.classList.remove('hidden');
                    content.innerHTML = 'Loading...';
                    errorMsg.classList.add('hidden');

                    try {
                        const response = await fetch('{{ route("calendar-sources.validate") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ ics_url: urlInput.value })
                        });

                        const data = await response.json();

                        if (response.ok && data.valid) {
                            content.innerHTML = '';
                            if (data.events.length === 0) {
                                content.innerHTML = '<p>No events found.</p>';
                            } else {
                                const ul = document.createElement('ul');
                                ul.className = 'list-disc pl-4';
                                data.events.forEach(event => {
                                    const li = document.createElement('li');
                                    li.textContent = `${event.summary} (${event.start})`;
                                    ul.appendChild(li);
                                });
                                content.appendChild(ul);
                            }
                        } else {
                            content.innerHTML = '';
                            errorMsg.textContent = data.message || 'Validation failed.';
                            errorMsg.classList.remove('hidden');
                        }
                    } catch (e) {
                        content.innerHTML = '';
                        errorMsg.textContent = 'An error occurred while validating the URL.';
                        errorMsg.classList.remove('hidden');
                    } finally {
                        btn.disabled = false;
                        btn.innerText = 'Test URL';
                    }
                });
            </script>

                        <div class="mb-4">
                            <label for="access_token" class="block text-gray-700 text-sm font-bold mb-2">Access Token (Optional):</label>
                            <p class="text-gray-600 text-xs mb-2">If set, this calendar will only be visible on the public page when the token is in the URL (?token=yourtoken)</p>
                            <input type="text" name="access_token" id="access_token" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('access_token') }}" placeholder="e.g., secret123">
                            @error('access_token')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Groups (Optional):</label>
                            <div class="space-y-2">
                                @foreach($groups as $group)
                                    <label class="inline-flex items-center mr-4">
                                        <input type="checkbox" name="groups[]" value="{{ $group->id }}" class="form-checkbox h-4 w-4 text-blue-600" {{ in_array($group->id, old('groups', [])) ? 'checked' : '' }}>
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
                                Create Source
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
