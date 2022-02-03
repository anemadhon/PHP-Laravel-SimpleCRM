<x-app-layout>
    <div class="w-full px-4 md:pb-6">
        <div class="relative flex flex-col min-w-0 break-words">
            <div class="flex-auto text-white text-xl font-semibold">
                <div class="lg:w-1/2 w-full mb-6 lg:mb-0">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-1 text-white">{{ __('Projects') }}</h1>
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
            
            @canany(['manage-apps', 'manage-department', 'create-clients'])
                <div class="rounded-t mb-3 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-2 max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-lg text-blueGray-700">
                                <a href="{{ route('projects.create') }}">
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
                            Owner
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Level
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            State
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Teams
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Tasks
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                {{ $project->name }}
                            </td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                {{ $project->client->name }}
                            </td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                {{ $project->level->name }}
                            </td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                {{ $project->state->name }}
                            </td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">
                                <a href="{{ route('projects.teams.index', ['project' => $project]) }}" class="hover:underline">{{ $project->users_count }}</a>
                            </td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">
                                <a href="{{ route('projects.tasks.index', ['project' => $project]) }}" class="hover:underline">{{ $project->tasks_count }}</a>
                            </td>
                            <td class="text-center border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                @can('create-teams', $project)
                                    <a href="{{ route('projects.teams.create', ['project' => $project]) }}">
                                        <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-xs px-2 py-1 rounded-full shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" type="button">
                                            <i class="fas fa-plus"></i> {{ __('Create Team') }}
                                        </button>
                                    </a>
                                @endcan
                                @if (auth()->user()->canany(['manage-apps', 'manage-department']) || (auth()->user()->can('create-teams') && $project->users_count > 0))
                                    <a href="{{ route('projects.tasks.create', ['project' => $project]) }}">
                                        <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-xs px-2 py-1 rounded-full shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" type="button">
                                            <i class="fas fa-plus"></i> {{ __('Create Task') }}
                                        </button>
                                    </a>
                                @endif
                                <a href="{{ route('projects.show', ['project' => $project]) }}">
                                    <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-xs px-2 py-1 rounded-full shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" type="button">
                                        <i class="far fa-eye"></i> {{ __('Details') }}
                                    </button>
                                </a>
                                @cannot('create-tasks')
                                    <a href="{{ route('projects.edit', ['project' => $project]) }}">
                                        <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-xs px-2 py-1 rounded-full shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" type="button">
                                            <i class="fas fa-pen"></i> {{ __('Edit') }}
                                        </button>
                                    </a>
                                @endcannot
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

        {{ $projects->links() }}

    </div>
</x-app-layout>
