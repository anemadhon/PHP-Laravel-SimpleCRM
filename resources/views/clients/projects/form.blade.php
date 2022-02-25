<x-app-layout>
    <div class="px-4 w-full pb-2 md:pb-4">
        <div class="flex relative flex-col mb-6 min-w-0 break-words bg-white rounded shadow-lg bg-blueGray-100 xl:mb-0">

            <div class="px-6 py-6 mb-0 bg-white rounded-t">
                <div class="flex justify-between text-center">
                    <h6 class="text-xl font-bold text-blueGray-700">
                        {{ __("{$state} {$client->name} Project Form") }}
                    </h6>
                </div>
            </div>

            <div class="flex-auto p-4">

                <x-errors class="mb-4" :errors="$errors" />

                <form action="{{ $state === 'Update' ? route('clients.projects.update', ['client' => $client, 'project' => $project]) : route('clients.projects.store', ['client' => $client]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($state === 'Update')
                        @method('PUT')
                    @endif

                    <div class="flex flex-wrap">
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="owner" :value="__('Owner')"/>
                                <select name="client_id" id="owner" class="rounded-md w-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="{{ $client->id }}" selected>{{ $client->name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="name" :value="__('Name')"/>
                                <x-input
                                        type="text"
                                        placeholder="{{ __('Name') }}"
                                        name="name"
                                        id="name"
                                        value="{{ old('name', $project->name ?? '')  }}"
                                        required
                                />
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="description" :value="__('Description')"/>
                                <textarea name="description" id="description" class="rounded-md w-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" cols="30" rows="3" placeholder="{{ __('Description') }}" required>{{ old('description', $project->description ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div date-rangepicker class="flex">
                                <div class="relative w-full mb-3">
                                    <x-input
                                            type="text"
                                            placeholder="{{ __('Start Date') }}"
                                            name="started_at"
                                            id="start"
                                            value="{{ old('started_at', (isset($project) ? $project->started_at->toDateString() : ''))  }}"
                                            required
                                            onfocus="(this.type='date')"
                                            onblur="(this.type='text')"
                                    />
                                </div>
                                <span class="mx-4 pt-2 text-gray-500">to</span>
                                <div class="relative w-full mb-3">
                                    <x-input
                                            type="text"
                                            placeholder="{{ __('End Date') }}"
                                            name="ended_at"
                                            id="end"
                                            value="{{ old('ended_at', (isset($project) ? $project->ended_at->toDateString() : ''))  }}"
                                            required
                                            onfocus="(this.type='date')"
                                            onblur="(this.type='text')"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="level" :value="__('Level')"/>
                                <select name="level_id" id="level" class="rounded-md w-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option></option>
                                    @foreach ($levels as $level)
                                        <option value="{{ $level->id }}" {{ ($state === 'Update' && $project->level_id == $level->id) || old('level_id') == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="state" :value="__('State')"/>
                                <select name="state_id" id="state" class="rounded-md w-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option></option>
                                    @foreach ($states as $project_state)
                                        <option value="{{ $project_state->id }}" {{ ($state === 'Update' && $project->state_id == $project_state->id) || old('state_id') == $project_state->id ? 'selected' : '' }}>{{ $project_state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="attachment" :value="__('Attachments')"/>
                                @if ($state === 'Update' && isset($project))
                                    <x-label class="inline-flex items-center text-gray-600">
                                        <x-slot name="value">
                                            <input type="radio"
                                                id="flag"
                                                name="flag"
                                                class="mt-1 ml-2"
                                                value="edit"
                                                checked>
                                            <span class="ml-2 text-gray-600">Replace</span>
                                        </x-slot>
                                    </x-label>
                                    <x-label class="inline-flex items-center text-gray-600">
                                        <x-slot name="value">
                                            <input type="radio"
                                                id="flag"
                                                name="flag"
                                                class="mt-1 ml-1"
                                                value="add">
                                            <span class="ml-2 text-gray-600">Add</span>
                                        </x-slot>
                                    </x-label>
                                @endif
                                <input
                                        type="file"
                                        placeholder="{{ __('Attachments') }}"
                                        name="attachment[]"
                                        id="attachment"
                                        class="p-1 block
                                        w-full
                                        text-gray-700
                                        bg-white bg-clip-padding
                                        border border-solid border-gray-300
                                        rounded
                                        focus:bg-white focus:border-indigo-300 focus:outline-none focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        accept="{{ $mimes }}"
                                        multiple
                                />
                            </div>
                        </div>
                    </div>

                    <x-divider class="mt-6"/>

                    <div class="mt-6">
                        <x-button>
                            {{ $state === 'New' ? __('Save') : __('Update') }}
                        </x-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('#level').select2({
            theme: "classic",
            placeholder: "Select Level",
            allowClear: false
        });
        $('#state').select2({
            theme: "classic",
            placeholder: "Select State",
            allowClear: false
        });
    });
</script>
