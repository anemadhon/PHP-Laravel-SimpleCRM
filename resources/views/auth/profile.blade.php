<x-app-layout>
    <div class="px-4 w-full pb-2 md:pb-4">
        <div class="flex relative flex-col mb-6 min-w-0 break-words bg-white rounded shadow-lg bg-blueGray-100 xl:mb-0">

            <div class="px-6 py-6 mb-0 bg-white rounded-t">
                <div class="flex justify-between text-center">
                    <h6 class="text-xl font-bold text-blueGray-700">
                        {{ __('My profile') }}
                    </h6>
                </div>
            </div>

            <div class="flex-auto p-4">

                @if ($message = Session::get('success'))
                    <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-emerald-500">
                        <span class="text-xl inline-block mr-5 align-middle">
                            <i class="fas fa-bell"></i>
                        </span>
                        <span class="inline-block align-middle mr-8">
                            <b class="capitalize">Success!</b> {{ $message }}
                        </span>
                    </div>
                @endif

                <x-errors class="mb-4" :errors="$errors" />

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-wrap">
                        <div class="w-full lg:w-6/12 px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="name" :value="__('Name')"/>
                                <x-input
                                        type="text"
                                        placeholder="{{ __('Name') }}"
                                        name="name"
                                        id="name"
                                        value="{{ old('name', auth()->user()->name) }}"
                                        required
                                />
                            </div>
                        </div>
                        <div class="w-full lg:w-6/12 px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="email" :value="__('Email')"/>
                                <x-input
                                        type="email"
                                        name="email"
                                        id="email"
                                        value="{{ old('email', auth()->user()->email) }}"
                                        placeholder="{{ __('Email') }}"
                                />
                            </div>
                        </div>
                        <div class="w-full lg:w-6/12 px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="username" :value="__('Username')"/>
                                <x-input
                                        type="text"
                                        placeholder="{{ __('Username') }}"
                                        name="username"
                                        id="username"
                                        value="{{ old('username', auth()->user()->username) }}"
                                        required
                                />
                            </div>
                        </div>
                        <div class="w-full lg:w-6/12 px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="role" :value="__('Role')"/>
                                <p class="text-md rounded-md w-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    {{ auth()->user()->role->name }}
                                </p>
                            </div>
                        </div>
                        <div class="w-full lg:w-6/12 px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="password" :value="__('New password')"/>
                                <x-input
                                        type="password"
                                        name="password"
                                        id="password"
                                        placeholder="{{ __('New password') }}"
                                />
                            </div>
                        </div>
                        <div class="w-full lg:w-6/12 px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="password_confirmation" :value="__('New password confirmation')"/>
                                <x-input
                                        type="password"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        placeholder="{{ __('New password confirmation') }}"
                                />
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <x-label for="skills" :value="__('Skills')"/>
                                <select name="skill_id[]" id="skills" class="rounded-md w-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" multiple>
                                    @foreach ($skills as $skill)
                                        <option value="{{ $skill->id }}" {{ (in_array($skill->id, $user_skills) || old('skill_id') === $skill->id) ? 'selected' : '' }}>{{ $skill->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <x-divider class="mt-6"/>

                    <div class="mt-6">
                        <x-button>
                            {{ __('Submit') }}
                        </x-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
