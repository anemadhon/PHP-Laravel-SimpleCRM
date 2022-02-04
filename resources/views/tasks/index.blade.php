<x-app-layout>
    <div class="w-full px-4 md:pb-6">
        <div class="relative flex flex-col min-w-0 break-words">
            <div class="flex-auto text-white text-xl font-semibold">
                <div class="lg:w-1/2 w-full mb-6 lg:mb-0">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-1 text-white">{{ __('Tasks') }}</h1>
                    <div class="h-1 w-20 bg-pink-100 rounded"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full px-4 pb-2 md:pb-4">
        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
            @if ($message = Session::get('success'))
                <div class="text-white px-6 py-4 m-2 border-0 rounded relative mb-4 bg-emerald-500">
                    <span class="text-xl inline-block mr-5 align-middle">
                        <i class="fas fa-bell"></i>
                    </span>
                    <span class="inline-block align-middle mr-8">
                        <b class="capitalize">Success!</b> {{ $message }}
                    </span>
                </div>
            @endif
            
            @canany(['manage-apps', 'manage-department'])
                <div class="rounded-t mb-3 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-2 max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-lg text-blueGray-700">
                                <a href="{{ route('tasks.create') }}">
                                    <button class="bg-orange-500 text-white active:bg-orange-600 font-bold uppercase text-xs px-3 py-2 rounded-full shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" type="button">
                                        <i class="fas fa-plus"></i> {{ __('Add') }}
                                    </button>
                                </a>
                            </h3>
                        </div>
                    </div>
                </div>
            @endcanany

            <div class="block w-full overflow-x-auto">
                <table class="items-center w-full bg-transparent border-collapse">
                    <thead>
                    <tr>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Name
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Project
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Level
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            State
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Assigned To
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Sub Task
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                {{ $task->name }}
                            </td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                {{ $task->project->name }}
                            </td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                {{ $task->level->name }}
                            </td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                {{ $task->state->name }}
                            </td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                {{ $task->user->name }}
                            </td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">
                                <a href="{{ route('tasks.subs.index', ['task' => $task]) }}" class="hover:underline">{{ $task->subs_count }}</a>
                            </td>
                            <td class="text-center border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                @can('manage-sub-tasks', $task)
                                    <a href="{{ route('tasks.subs.create', ['task' => $task]) }}">
                                        <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-xs px-2 py-1 rounded-full shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" type="button">
                                            <i class="fas fa-plus"></i> {{ __('Create Sub Task') }}
                                        </button>
                                    </a>
                                @endcan
                                @if (auth()->user()->can('edit-tasks', $task))
                                    <a href="{{ route('tasks.edit', ['task' => $task]) }}">
                                        <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-xs px-2 py-1 rounded-full shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" type="button">
                                            <i class="fas fa-pen"></i> {{ __('Edit') }}
                                        </button>
                                    </a>
                                @else
                                    <button class="bg-emerald-500 text-white font-bold uppercase text-xs px-2 py-1 rounded-full shadow outline-none ease-linear transition-all duration-150 hover:shadow-md cursor-not-allowed" disabled type="button">
                                        <i class="fas fa-pen"></i> {{ __('Edit') }}
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                {{ __('No Record Found') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $tasks->links() }}

    </div>
</x-app-layout>
