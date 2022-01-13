<x-app-layout>
    <div class="px-4 w-full pb-2 md:pb-4">
        <div class="flex relative flex-col mb-6 min-w-0 break-words bg-white rounded shadow-lg bg-blueGray-100 xl:mb-0">

            <div class="px-6 py-6 mb-0 bg-white rounded-t">
                <div class="flex justify-between text-center">
                    <h6 class="text-xl font-bold text-blueGray-700">
                        {{ $state === 'New' ? __('New Skills Form') : __('Update Skills Form') }}
                    </h6>
                </div>
            </div>

            <div class="flex-auto p-4">

                <x-errors class="mb-4" :errors="$errors" />

                <form action="{{ $state === 'Update' ? route('admin.skills.update', ['skill' => $skill]) : route('admin.skills.store') }}" method="POST">
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
                                        value="{{ old('name', $skill->name ?? '')  }}"
                                        required
                                />
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
