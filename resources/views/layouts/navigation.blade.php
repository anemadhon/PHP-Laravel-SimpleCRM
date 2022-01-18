<nav
    class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6"
>
    <div
        class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto"
    >
        <button
            class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
            type="button"
            onclick="toggleNavbar('example-collapse-sidebar')"
        >
            <i class="fas fa-bars"></i>
        </button>
        <a
            class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
            href="{{ route('dashboard') }}"
        >
            {{ __('Simple CRM') }}
        </a>
        <div
            class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded hidden"
            id="example-collapse-sidebar"
        >
            <div
                class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-blueGray-200"
            >
                <div class="flex flex-wrap">
                    <div class="w-6/12">
                        <a
                            class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
                            href="{{ route('dashboard') }}"
                        >
                            {{ __('Simple CRM') }}
                        </a>
                    </div>
                    <div class="w-6/12 flex justify-end">
                        <button
                            type="button"
                            class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
                            onclick="toggleNavbar('example-collapse-sidebar')"
                        >
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Heading -->
            <x-nav-heading>
                {{ auth()->user()->role->name }} {{ __('Menus') }}
            </x-nav-heading>

            <!-- Navigation -->

            <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                <li class="items-center">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        <x-slot name="icon">
                            <i class="fas fa-tv mr-2 text-sm opacity-75"></i>
                        </x-slot>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </li>

                @canany(['manage-apps', 'manage-department', 'manage-clients'])
                    <li class="items-center">
                        <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')">
                            <x-slot name="icon">
                                <i class="fas fa-users mr-2 text-sm opacity-75"></i>
                            </x-slot>
                            {{ __('Users') }}
                        </x-nav-link>
                    </li>
                    
                    <li class="items-center">
                        <x-nav-link href="{{ route('clients.index') }}" :active="request()->routeIs('clients.*')">
                            <x-slot name="icon">
                                <i class="far fa-handshake mr-2 text-sm opacity-75"></i>
                            </x-slot>
                            {{ __('Clients') }}
                        </x-nav-link>
                    </li>
                @endcanany
                
                @canany(['manage-apps', 'manage-department', 'manage-teams', 'manage-tasks'])
                    <li class="items-center">
                        <x-nav-link href="{{ route('projects.index') }}" :active="request()->routeIs('projects.*')">
                            <x-slot name="icon">
                                <i class="fas fa-briefcase mr-2 text-sm opacity-75"></i>
                            </x-slot>
                            {{ __('Projects') }}
                        </x-nav-link>
                    </li>
                    
                    <li class="items-center">
                        <x-nav-link href="{{ route('tasks.index') }}" :active="request()->routeIs('tasks.*')">
                            <x-slot name="icon">
                                <i class="fas fa-tasks mr-2 text-sm opacity-75"></i>
                            </x-slot>
                            {{ __('Task') }}
                        </x-nav-link>
                    </li>
                @endcanany
            </ul>

            @can('manage-apps')
                <x-divider class="my-4" />
                
                <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                    <li class="items-center">
                        <x-nav-link href="{{ route('admin.roles.index') }}" :active="request()->routeIs('admin.roles.*')">
                            <x-slot name="icon">
                                <i class="fas fa-user-tag mr-2 text-sm opacity-75"></i>
                            </x-slot>
                            {{ __('Role') }}
                        </x-nav-link>
                    </li>
                    
                    <li class="items-center">
                        <x-nav-link href="{{ route('admin.skills.index') }}" :active="request()->routeIs('admin.skills.*')">
                            <x-slot name="icon">
                                <i class="fas fa-trophy mr-2 text-sm opacity-75"></i>
                            </x-slot>
                            {{ __('Skill') }}
                        </x-nav-link>
                    </li>
                    
                    <li class="items-center">
                        <x-nav-link href="{{ route('admin.levels.index') }}" :active="request()->routeIs('admin.levels.*')">
                            <x-slot name="icon">
                                <i class="fas fa-layer-group mr-2 text-sm opacity-75"></i>
                            </x-slot>
                            {{ __('Level') }}
                        </x-nav-link>
                    </li>
                    
                    <li class="items-center">
                        <x-nav-link href="{{ route('admin.types.index') }}" :active="request()->routeIs('admin.types.*')">
                            <x-slot name="icon">
                                <i class="fas fa-hand-holding-usd mr-2 text-sm opacity-75"></i>
                            </x-slot>
                            {{ __('Client Type') }}
                        </x-nav-link>
                    </li>
                    
                    <li class="items-center">
                        <x-nav-link href="{{ route('admin.states.index') }}" :active="request()->routeIs('admin.states.*')">
                            <x-slot name="icon">
                                <i class="fas fa-project-diagram mr-2 text-sm opacity-75"></i>
                            </x-slot>
                            {{ __('Project State') }}
                        </x-nav-link>
                    </li>
                </ul>
            @endcan
            
            <x-divider class="my-4" />
            
            <x-nav-heading>
                {{ __('About Author') }}
            </x-nav-heading>
            
            <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                <x-nav-link href="#">
                    <x-slot name="icon">
                        <i class="far fa-smile mr-2 text-sm opacity-75"></i>
                    </x-slot>
                    {{ __('Say Hai!') }}
                </x-nav-link>
            </ul>
            
        </div>
    </div>
</nav>
