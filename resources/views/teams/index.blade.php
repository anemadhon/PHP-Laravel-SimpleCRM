<x-app-layout>
    <div class="w-full px-4 md:pb-6">
        <div class="relative flex flex-col min-w-0 break-words">
            <div class="flex-auto text-white text-xl font-semibold">
                <div class="lg:w-1/2 w-full mb-6 lg:mb-0">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-1 text-white">{{ __('Teams') }}</h1>
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
            
            <div class="block w-full overflow-x-auto">
                <table class="items-center w-full bg-transparent border-collapse">
                    <thead>
                    <tr>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Project Name
                        </th>
                        <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                            Team Member
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($teams as $team)
                            <tr>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{ $team->name }}
                                </td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    @forelse ($team->users as $member)
                                    <ul class="list-disc">
                                        <li>{{ $member->name }} - {{ $member->role->name }} - {{ $member->tasks->count() === 0 ? 'No Task' : "{$member->tasks->count()} Task" }}{{ $member->tasks->count() > 1 ? 's' : '' }}</li>
                                    </ul>
                                    @empty
                                        {{ __('No Team Created') }}
                                    @endforelse
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{ __('No Record Found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $teams->links() }}

    </div>
</x-app-layout>
