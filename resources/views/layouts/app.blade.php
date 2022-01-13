<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="antialiased text-blueGray-700">
    @include('layouts.navigation')

    <div class="relative md:ml-64 bg-blueGray-50">
        <!-- TOP NAV -->
        <nav
            class="absolute top-0 left-0 z-10 flex items-center w-full p-4 bg-transparent md:flex-row md:flex-nowrap md:justify-start">
            <div class="flex flex-wrap items-center justify-end w-full px-4 mx-auto md:flex-nowrap md:px-10">
                <x-dropdown>
                    <x-slot name="trigger">
                        <a class="block text-blueGray-500" href="#" onclick="openDropdown(event,'user-dropdown')">
                            <span class="text-white">{{ __('Hi') }}, {{ Auth::user()->name }}</span>
                        </a>
                        <div class="h-0.5 w-full bg-pink-100 rounded"></div>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('profile.show') }}">{{ __('My profile') }}</x-dropdown-link>
                        <x-divider />
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </nav>
        <!-- END TOP NAV -->

        <div class="relative pt-12 pb-32 bg-pink-600 md:pt-32">
            <div class="w-full px-4 mx-auto md:px-10">
                <div class="flex flex-wrap"></div>
            </div>
        </div>
        <div class="w-full px-4 mx-auto -m-24 md:px-10">
            {{ $slot }}
        </div>
    </div>

    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
    <script type="text/javascript">
        /* Sidebar - Side navigation menu on mobile/responsive mode */
        function toggleNavbar(collapseID) {
            document.getElementById(collapseID).classList.toggle("hidden");
            document.getElementById(collapseID).classList.toggle("bg-white");
            document.getElementById(collapseID).classList.toggle("m-2");
            document.getElementById(collapseID).classList.toggle("py-3");
            document.getElementById(collapseID).classList.toggle("px-6");
        }

        /* Function for dropdowns */
        function openDropdown(event, dropdownID) {
            event.preventDefault();
            let element = event.target;
            while (element.nodeName !== "A") {
                element = element.parentNode;
            }
            Popper.createPopper(element, document.getElementById(dropdownID), {
                placement: "bottom-start",
            });
            document.getElementById(dropdownID).classList.toggle("hidden");
            document.getElementById(dropdownID).classList.toggle("block");
        }

        function toggleModal(modalID, title, content, url){
            document.getElementById(modalID).classList.toggle("hidden");
            document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
            document.getElementById(modalID).classList.toggle("flex");
            document.getElementById(modalID + "-backdrop").classList.toggle("flex");

            document.getElementById(modalID).getElementsByTagName("h3")[0].innerText = 'Lorem Ipsum';
            document.getElementById(modalID).getElementsByTagName("p")[0].innerText = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged";
            document.getElementById(modalID).getElementsByTagName("a")[0].href = '#';
        }
    </script>
</body>

</html>
