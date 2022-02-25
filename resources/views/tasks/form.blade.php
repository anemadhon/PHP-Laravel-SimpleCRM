<x-app-layout>
    <div class="px-4 w-full pb-2 md:pb-4">
        <div class="flex relative flex-col mb-6 min-w-0 break-words bg-white rounded shadow-lg bg-blueGray-100 xl:mb-0">

            <div class="px-6 py-6 mb-0 bg-white rounded-t">
                <div class="flex justify-between text-center">
                    <h6 class="text-xl font-bold text-blueGray-700">
                        {{ $state === 'New' ? __('New Tasks Form') : __('Update Tasks Form') }}
                    </h6>
                </div>
            </div>

            <div class="flex-auto p-4">

                <x-errors class="mb-4" :errors="$errors" />

                <form action="{{ $state === 'Update' ? route('tasks.update', ['task' => $task]) : route('tasks.store') }}" method="POST">
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
                                        value="{{ old('name', $task->name ?? '')  }}"
                                        required
                                />
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="project" :value="__('Project')"/>
                                <select name="project_id" id="project" class="rounded-md w-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @if ($state === 'Update')
                                        <option value="{{ $task->project_id }}" selected>{{ $task->project->name }}</option>
                                    @else
                                        <option></option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}" {{ ($state === 'Update' && $task->project_id == $project->id) || old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="level" :value="__('Level')"/>
                                <select name="level_id" id="level" class="rounded-md w-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option></option>
                                    @foreach ($levels as $level)
                                        <option value="{{ $level->id }}" {{ ($state === 'Update' && $task->level_id == $level->id) || old('level_id') == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
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
                                        <option value="{{ $project_state->id }}" {{ ($state === 'Update' && $task->state_id == $project_state->id) || old('state_id') == $project_state->id ? 'selected' : '' }}>{{ $project_state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="user" :value="__('Assigned To')"/>
                                <select name="assigned_to" id="user" class="rounded-md w-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @if ($state === 'Update')
                                        <option value="{{ $task->assigned_to }}" selected>{{ $task->user->name }} - {{ $task->user->role->name }}</option>
                                    @else
                                        <option></option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ ($state === 'Update' && $task->assigned_to == $user->id) || old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }} - {{ $user->role->name }}</option>
                                        @endforeach
                                    @endif
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
        $('#user').select2({
            theme: "classic",
            placeholder: "Select User",
            allowClear: false
        });
        $('#project').select2({
            theme: "classic",
            placeholder: "Select Project",
            allowClear: false
        });
    });
</script>
