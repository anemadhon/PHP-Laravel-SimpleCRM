<x-app-layout>
    <div class="w-full px-4 md:pb-6">
        <div class="relative flex flex-col min-w-0 break-words">
            <div class="flex-auto text-white text-xl font-semibold">
                <div class="lg:w-1/2 w-full mb-6 lg:mb-0">
                    <h1 class="sm:text-3xl text-2xl font-medium title-font mb-1 text-white">{{ __("{$owner->name} Details") }}</h1>
                    <div class="h-1 w-20 bg-pink-100 rounded"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="px-4 pb-2 md:pb-4">
        <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
            <div class="w-full md:w-1/2 px-8 pt-4 bg-white rounded-t">
                <div class="flex justify-between text-center pb-1">
                    <p class="text-2xl font-bold text-blueGray-700">
                        {{ $owner->name }}
                    </p>
                </div>
                <div class="flex justify-between text-center">
                    <p class="text-md text-blueGray-700">
                        Client :
                    </p>
                    <p class="text-md text-blueGray-700">
                        {{ $owner->client->name }}
                    </p>
                </div>
                <div class="flex justify-between text-center">
                    <p class="text-md text-blueGray-700">
                        Level / State :
                    </p>
                    <p class="text-md text-blueGray-700">
                        {{ $owner->level->name }} / {{ $owner->state->name }}
                    </p>
                </div>
                <div class="flex justify-between text-center pb-1">
                    <p class="text-md text-blueGray-700">
                        Timeline :
                    </p>
                    <p class="text-md text-blueGray-700">
                        {{ $owner->started_at->toFormattedDateString() }} - {{ $owner->ended_at->toFormattedDateString() }}
                    </p>
                </div>
                <hr class="pt-1">
                <div class="flex justify-between text-center">
                    <p class="text-md text-blueGray-700">
                        Description :
                    </p>
                    <p class="text-md text-blueGray-700">
                        {{ $owner->description }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap p-4">
                <div class="w-full md:w-1/2 p-4">
                    <div class="border border-gray-400 p-6 rounded-lg">
                        <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Attachments</h2>
                        <table class="leading-relaxed text-sm px-6 items-center w-full bg-transparent border-collapse">
                            @foreach ($attachments as $attachment)
                                <tr class="align-middle border border-solid text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                    <td class="py-1">{{ $attachment->path }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="w-full md:w-1/2 p-4">
                    <div class="border border-gray-400 p-6 rounded-lg">
                        <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 mb-4">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Teams</h2>
                        <table class="leading-relaxed text-sm px-6 items-center w-full bg-transparent border-collapse">
                            @foreach ($teams as $team)
                                <tr class="align-middle border border-solid text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                    <td class="py-1">{{ $team->name }}</td>
                                    <td class="py-1 text-right">{{ $team->role->name }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="w-full md:w-1/2 p-4">
                    <div class="border border-gray-400 p-6 rounded-lg">
                        <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Tasks</h2>
                        <table class="leading-relaxed text-sm px-6 items-center w-full bg-transparent border-collapse">
                            @foreach ($tasks as $task)
                                <tr class="align-middle border border-solid text-xs text-center uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                    <td class="py-1 text-left">
                                        <div class="w-20">
                                            <p class="break-all">{{ $task->name }}</p>
                                        </div>
                                    </td>
                                    <td class="py-1">{{ $task->level->name }}</td>
                                    <td class="py-1 text-right">{{ $task->state->name }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
