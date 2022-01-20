<x-app-layout>
    <div class="px-4 w-full pb-2 md:pb-4">
        <div class="flex relative flex-col mb-6 min-w-0 break-words bg-white rounded shadow-lg bg-blueGray-100 xl:mb-0">

            <div class="px-6 py-6 mb-0 bg-white rounded-t">
                <div class="flex justify-between text-center">
                    <h6 class="text-xl font-bold text-blueGray-700">
                        {{ __("New {$project->name} Team Form") }}
                    </h6>
                </div>
            </div>

            <div class="flex-auto p-4">

                <x-errors class="mb-4" :errors="$errors" />

                <form action="{{ route('projects.teams.store', ['project' => $project]) }}" method="POST">
                    @csrf
                    <div class="flex flex-wrap">
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="project" :value="__('Project')"/>
                                <select name="project_id" id="project" class="rounded-md w-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="{{ $project->id }}" selected>{{ $project->name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="pm" :value="__('Project Manager')"/>
                                <select name="pm" id="pm" class="rounded-md w-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select User</option>
                                    @foreach ($users_pm as $pm)
                                        <option value="{{ $pm->id }}" {{ old('assigned_to') === $pm->id ? 'selected' : '' }}>{{ $pm->name }} - {{ $pm->role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="dev" :value="__('Developer')"/>
                                <select name="dev[]" id="dev" class="rounded-md w-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required multiple>
                                    <option value="">Select User</option>
                                    @foreach ($users_dev as $dev)
                                        <option value="{{ $dev->id }}" {{ old('assigned_to') === $dev->id ? 'selected' : '' }}>{{ $dev->name }} - {{ $dev->role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="qa" :value="__('Quality Assurance')"/>
                                <select name="qa" id="qa" class="rounded-md w-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select User</option>
                                    @foreach ($users_qa as $qa)
                                        <option value="{{ $qa->id }}" {{ old('assigned_to') === $qa->id ? 'selected' : '' }}>{{ $qa->name }} - {{ $qa->role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <x-divider class="mt-6"/>

                    <div class="mt-6">
                        <x-button>
                            {{ __('Save') }}
                        </x-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
