<x-app-layout>
    <div class="w-full px-4 md:pb-6">
        <div class="relative flex flex-col min-w-0 break-words">
            <div class="flex-auto text-white text-xl font-semibold">
                <div class="lg:w-1/2 w-full mb-6 lg:mb-0">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-1 text-white">{{ __('Dashboard Statistics') }}</h1>
                    <div class="h-1 w-20 bg-pink-100 rounded"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="px-4 pb-2 md:pb-4">
        <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
            <div class="flex flex-wrap p-4">
                @can('manage-apps')
                    <div class="w-full xl:w-1/3 md:w-1/2 p-4">
                        <div class="border border-gray-400 p-6 rounded-lg">
                            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Roles</h2>
                            <table class="leading-relaxed text-sm px-6 items-center w-full bg-transparent border-collapse">
                                @foreach ($dashboard['roles'] as $role)
                                    <tr class="align-middle border border-solid text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                        <td class="py-1">{{ $role->name }}</td>
                                        <td class="text-right">{{ $role->users_count }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endcan
                @canany(['manage-apps', 'manage-department', 'manage-clients'])
                    <div class="w-full xl:w-1/3 md:w-1/2 p-4">
                        <div class="border border-gray-400 p-6 rounded-lg">
                            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 mb-4">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Users</h2>
                            <table class="leading-relaxed text-sm px-6 items-center w-full bg-transparent border-collapse">
                                <tr class="align-middle border border-solid text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                    <td class="py-1">Idle</td>
                                    <td class="text-right">{{ $dashboard['user_idle'] }}</td>
                                </tr>
                                <tr class="align-middle border border-solid text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                    <td class="py-1">In Project</td>
                                    <td class="text-right">{{ $dashboard['user_in_project'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @endcanany
                @canany(['manage-apps', 'manage-department', 'manage-clients', 'manage-teams'])
                    <div class="w-full xl:w-1/3 md:w-1/2 p-4">
                        <div class="border border-gray-400 p-6 rounded-lg">
                            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Project States</h2>
                            <table class="leading-relaxed text-sm px-6 items-center w-full bg-transparent border-collapse">
                                @foreach ($dashboard['state_projects'] as $state_project)
                                <tr class="align-middle border border-solid text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                    <td class="py-1">{{ $state_project->name }}</td>
                                    <td class="text-right">{{ $state_project->projects_count }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="w-full xl:w-1/3 md:w-1/2 p-4">
                        <div class="border border-gray-400 p-6 rounded-lg">
                            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Task States</h2>
                            <table class="leading-relaxed text-sm px-6 items-center w-full bg-transparent border-collapse">
                                @foreach ($dashboard['state_tasks'] as $state_task)
                                <tr class="align-middle border border-solid text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                    <td class="py-1">{{ $state_task->name }}</td>
                                    <td class="text-right">{{ $state_task->tasks_count }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endcanany
                @canany(['manage-apps', 'manage-department', 'manage-teams'])
                    <div class="w-full xl:w-1/3 md:w-1/2 p-4">
                        <div class="border border-gray-400 p-6 rounded-lg">
                            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Levels - Project</h2>
                            <table class="leading-relaxed text-sm px-6 items-center w-full bg-transparent border-collapse">
                                @foreach ($dashboard['level_projects'] as $project)
                                    <tr class="align-middle border border-solid text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                        <td class="py-1">{{ $project->name }}</td>
                                        <td class="text-right">{{ $project->projects_count }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="w-full xl:w-1/3 md:w-1/2 p-4">
                        <div class="border border-gray-400 p-6 rounded-lg">
                            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Levels - Task</h2>
                            <table class="leading-relaxed text-sm px-6 items-center w-full bg-transparent border-collapse">
                                @foreach ($dashboard['level_tasks'] as $task)
                                    <tr class="align-middle border border-solid text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                        <td class="py-1">{{ $task->name }}</td>
                                        <td class="text-right">{{ $task->tasks_count }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endcanany
                @canany(['manage-apps', 'manage-department', 'manage-clients'])
                    <div class="w-full xl:w-1/3 md:w-1/2 p-4">
                        <div class="border border-gray-400 p-6 rounded-lg">
                            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                            </div>
                            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Client Types</h2>
                            <table class="leading-relaxed text-sm px-6 items-center w-full bg-transparent border-collapse">
                                @foreach ($dashboard['types'] as $type)
                                    <tr class="align-middle border border-solid text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                        <td class="py-1">{{ $type->name }}</td>
                                        <td class="text-right">{{ $type->clients_count }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endcanany
                @canany(['manage-teams', 'manage-tasks'])
                    <div class="w-full xl:w-1/3 md:w-1/2 p-4">
                        <div class="border border-gray-400 p-6 rounded-lg">
                            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </div>
                            <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Your Project</h2>
                            <table class="leading-relaxed text-sm px-6 items-center w-full bg-transparent border-collapse">
                                @forelse ($your_projects as $skill)
                                    <tr class="align-middle border border-solid text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                        <td class="py-1">{{ $skill->name }}</td>
                                        <td class="text-right">{{ $skill->users_count }}</td>
                                    </tr>
                                @empty
                                    <tr class="align-middle border border-solid text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                        <td class="py-1" colspan="2">{{ __("You're Idle") }}</td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                    </div>  
                    @can('manage-clients')
                        
                        <div class="w-full xl:w-1/3 md:w-1/2 p-4">
                            <div class="border border-gray-400 p-6 rounded-lg">
                                <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </div>
                                <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Your Task</h2>
                                <table class="leading-relaxed text-sm px-6 items-center w-full bg-transparent border-collapse">
                                    @forelse ($your_tasks as $skill)
                                        <tr class="align-middle border border-solid text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                            <td class="py-1">{{ $skill->name }}</td>
                                            <td class="text-right">{{ $skill->users_count }}</td>
                                        </tr>
                                    @empty
                                        <tr class="align-middle border border-solid text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                            <td class="py-1" colspan="2">{{ __("You're Idle") }}</td>
                                        </tr>
                                    @endforelse
                                </table>
                            </div>
                        </div>   
                    @endcan 
                @endcanany
                <div class="w-full xl:w-1/3 md:w-1/2 p-4">
                    <div class="border border-gray-400 p-6 rounded-lg">
                        <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Skills</h2>
                        <table class="leading-relaxed text-sm px-6 items-center w-full bg-transparent border-collapse">
                            @foreach ($dashboard['skills'] as $skill)
                                <tr class="align-middle border border-solid text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                    <td class="py-1">{{ $skill->name }}</td>
                                    <td class="text-right">{{ $skill->users_count }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
