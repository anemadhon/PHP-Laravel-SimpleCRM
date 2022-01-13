<x-app-layout>
    <div class="px-4 w-full pb-2 md:pb-4">
        <div class="flex relative flex-col mb-6 min-w-0 break-words bg-white rounded shadow-lg bg-blueGray-100 xl:mb-0">

            <div class="px-6 py-6 mb-0 bg-white rounded-t">
                <div class="flex justify-between text-center">
                    <h6 class="text-xl font-bold text-blueGray-700">
                        {{ $state === 'New' ? __('New Project States Form') : __('Update Project States Form') }}
                    </h6>
                </div>
            </div>

            <div class="flex-auto p-4">

                <x-errors class="mb-4" :errors="$errors" />

                <form action="{{ $state === 'Update' ? route('admin.states.update', ['state' => $project_state]) : route('admin.states.store') }}" method="POST">
                    @csrf
                    @if ($state === 'Update')
                        @method('PUT')
                    @endif

                    <div class="flex flex-wrap">
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="name" :value="__('Name')"/>
                                <x-input
                                        type="text"
                                        placeholder="{{ __('Name') }}"
                                        name="name"
                                        id="name"
                                        value="{{ old('name', $project_state->name ?? '')  }}"
                                        required
                                />
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="description" :value="__('Description')"/>
                                <textarea name="description" id="description" class="rounded-md w-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" cols="30" rows="3" placeholder="{{ __('Description') }}" required>{{ old('description', $project_state->description ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="for" :value="__('For')"/>
                                <select name="for" id="for" class="rounded-md w-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="dev" {{ $state === 'Update' && $project_state->for === 'dev' ? 'selected' : '' }}>Developer</option>
                                    <option value="non" {{ $state === 'Update' && $project_state->for === 'non' ? 'selected' : '' }}>Non Developer</option>
                                </select>
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
