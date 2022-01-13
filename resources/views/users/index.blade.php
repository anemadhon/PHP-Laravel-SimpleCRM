<x-app-layout>
    <div class="w-full px-4 md:pb-6">
        <div class="relative flex flex-col min-w-0 break-words">
            <div class="flex-auto text-white text-xl font-semibold">
                <div class="lg:w-1/2 w-full mb-6 lg:mb-0">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-1 text-white">{{ __('Users') }}</h1>
                    <div class="h-1 w-20 bg-pink-100 rounded"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full px-4 pb-2 md:pb-4">
        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
            <div class="block w-full overflow-x-auto">
                <table class="items-center w-full bg-transparent border-collapse">
                    <thead>
                    <tr>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Name
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Username
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Email
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Role
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                {{ $user->name }}
                            </td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                {{ $user->username }}
                            </td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                {{ $user->email }}
                            </td>
                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                {{ $user->role->name }}
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>

        {{ $users->links() }}

    </div>
</x-app-layout>
