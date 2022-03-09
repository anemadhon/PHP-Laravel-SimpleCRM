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
    
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- Custom Select2 Styles -->
    <style>
        .select2.select2-container {
            width: 100% !important;
        }

        .select2.select2-container .select2-selection {
            height: 43px;
            border-radius: 0.375rem;
            border-color: rgb(209 213 219);
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        }

        .select2.select2-container .select2-selection--single .select2-selection__rendered {
            padding-top: 0.3rem;
            margin-left: 0.4rem;
        }

        .select2.select2-container .select2-selection--single .select2-selection__arrow {
            background: #f8f8f8;
            border-left: 1px solid #ccc;
            -webkit-border-radius: 0 0.375rem 0.375rem 0;
            -moz-border-radius: 0 0.375rem 0.375rem 0;
            border-radius: 0 0.375rem 0.375rem 0;
            height: 41px;
            width: 33px;
        }

        .select2.select2-container *:focus {
            border-color: rgb(165 180 252);
            box-shadow: var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) var(rgb(199 210 254));
        }
        
        .select2.select2-container .select2-selection--multiple {
            height: auto;
            min-height: 38px;
        }

        .select2.select2-container .select2-selection--multiple .select2-selection__rendered {
            padding-top: 0.3rem;
        }

        .select2.select2-container.select2-container--open .select2-selection.select2-selection--multiple {
            border-color: rgb(165 180 252);
        }

        .select2.select2-container .select2-selection--multiple .select2-selection__choice {
            background-color: #f8f8f8;
            border: 1px solid #ccc;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            padding: 0 6px 0 22px;
            height: 24px;
            line-height: 24px;
            font-size: 12px;
            position: relative;
        }

        .select2.select2-container .select2-selection--multiple .select2-selection__choice .select2-selection__choice__remove {
            position: absolute;
            top: 0;
            left: 0;
            height: 22px;
            width: 22px;
            margin-top: -0.15rem;
            text-align: center;
            color: rgb(236 72 153);
            font-weight: bold;
            font-size: 16px;
        }
    </style>
    <style>
        /*Toast open/load animation*/
        .alert-toast {
          -webkit-animation: slide-in-right 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
          animation: slide-in-right 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        }
    
        /*Toast close animation*/
        .alert-toast input:checked~* {
          -webkit-animation: fade-out-right 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
          animation: fade-out-right 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        }
    
        /* -------------------------------------------------------------
         * Animations generated using Animista * w: http://animista.net, 
         * ---------------------------------------------------------- */
    
        @-webkit-keyframes slide-in-top {
            0% {
                -webkit-transform: translateY(-1000px);
                transform: translateY(-1000px);
                opacity: 0
            }
        
            100% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                opacity: 1
            }
        }
    
        @keyframes slide-in-top {
            0% {
                -webkit-transform: translateY(-1000px);
                transform: translateY(-1000px);
                opacity: 0
            }
        
            100% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                opacity: 1
            }
        }
    
        @-webkit-keyframes slide-out-top {
            0% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                opacity: 1
            }
        
            100% {
                -webkit-transform: translateY(-1000px);
                transform: translateY(-1000px);
                opacity: 0
            }
        }
    
        @keyframes slide-out-top {
            0% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                opacity: 1
            }
        
            100% {
                -webkit-transform: translateY(-1000px);
                transform: translateY(-1000px);
                opacity: 0
            }
        }
    
        @-webkit-keyframes slide-in-bottom {
            0% {
                -webkit-transform: translateY(1000px);
                transform: translateY(1000px);
                opacity: 0
            }
        
            100% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                opacity: 1
            }
        }
    
        @keyframes slide-in-bottom {
            0% {
                -webkit-transform: translateY(1000px);
                transform: translateY(1000px);
                opacity: 0
            }
        
            100% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                opacity: 1
            }
        }
    
        @-webkit-keyframes slide-out-bottom {
            0% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                opacity: 1
            }
        
            100% {
                -webkit-transform: translateY(1000px);
                transform: translateY(1000px);
                opacity: 0
            }
        }
    
        @keyframes slide-out-bottom {
            0% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                opacity: 1
            }
        
            100% {
                -webkit-transform: translateY(1000px);
                transform: translateY(1000px);
                opacity: 0
            }
        }
    
        @-webkit-keyframes slide-in-right {
            0% {
                -webkit-transform: translateX(1000px);
                transform: translateX(1000px);
                opacity: 0
            }
        
            100% {
                -webkit-transform: translateX(0);
                transform: translateX(0);
                opacity: 1
            }
        }
    
        @keyframes slide-in-right {
            0% {
                -webkit-transform: translateX(1000px);
                transform: translateX(1000px);
                opacity: 0
            }
        
            100% {
                -webkit-transform: translateX(0);
                transform: translateX(0);
                opacity: 1
            }
        }
    
        @-webkit-keyframes fade-out-right {
            0% {
                -webkit-transform: translateX(0);
                transform: translateX(0);
                opacity: 1
            }
        
            100% {
                -webkit-transform: translateX(50px);
                transform: translateX(50px);
                opacity: 0
            }
        }
    
        @keyframes fade-out-right {
            0% {
                -webkit-transform: translateX(0);
                transform: translateX(0);
                opacity: 1
            }
        
            100% {
                -webkit-transform: translateX(50px);
                transform: translateX(50px);
                opacity: 0
            }
        }
    </style>
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
        <div class="alert-toast fixed bottom-0 right-0 m-8 w-5/6 md:w-full max-w-sm hidden">
            <input type="checkbox" class="hidden" id="footertoast">
            <label class="close cursor-pointer flex items-start justify-between w-full p-2 bg-emerald-500 h-24 rounded shadow-lg text-white" for="footertoast">
                <span id="toastmessage"></span>
                <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </label>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        Echo.private('useractivity').listen('UserActivityProcessed', (event) => {
            const msg = `${event.user.name} ${event.activity} - (id: ${event.data.id}) in ${event.modul} module`

            document.querySelector('.alert-toast').classList.remove('hidden')
            document.querySelector('#toastmessage').innerHTML = msg
            
            setTimeout(() => {
                document.querySelector('#footertoast').checked = true;
            }, 2500);

            setTimeout(() => {
                document.querySelector('.alert-toast').classList.add('hidden')
            }, 3300);
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
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

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>

</html>
