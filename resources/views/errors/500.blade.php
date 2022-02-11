<x-guest-layout>
    <div class="px-4 w-full lg:w-4/12">
        <div class="flex relative flex-col mb-6 w-full min-w-0 break-words rounded-lg border-0 shadow-lg bg-blueGray-200">

            <div class="px-6 py-6 mb-0 rounded-t">
                <div class="mb-3 text-center">
                    <p class="font-bold text-blueGray-500" style="font-size: 6em">
                        {{__('500')}}
                    </p>
                </div>
                
                <hr class="border-b-1 border-blueGray-300"/>
                
                <div class="mb-1 text-center">
                    <p class="text-lg text-blueGray-500">
                        {{__('Server Error')}}
                    </p>
                </div>

                <hr class="border-b-1 border-blueGray-300"/>
            </div>

            <div class="flex-auto px-4 py-10 pt-0 lg:px-10">
                <a href="{{ route('dashboard') }}">
                    <x-button class="w-full">
                        {{ __('Back to Dashboard') }}
                    </x-button>
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>