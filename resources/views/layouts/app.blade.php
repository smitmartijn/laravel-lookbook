<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Lookbook</title>

    @if(file_exists(public_path('css/app.css')))
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @if(file_exists(public_path('js/app.js')))
    <script src="{{ asset('js/app.js') }}" defer></script>
    @endif
    @elseif(file_exists(public_path('build/assets/app.css')))
    <link href="{{ asset('build/assets/app.css') }}" rel="stylesheet">
    @if(file_exists(public_path('build/assets/app.js')))
    <script src="{{ asset('build/assets/app.js') }}" defer></script>
    @endif
    @else
    {{-- For Laravel 9+ with Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Highlight.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/highlightjs-blade/dist/blade.min.js"></script>

    <style>
        .hljs {
            background: rgb(229 231 235) !important;
        }

        html.dark .hljs {
            background: rgb(39 39 42) !important;
        }
    </style>
    <script>
        function changeHighlightJsTheme() {
            document.querySelector('link[href*="highlight.js"]')?.remove();
            const link = document.createElement("link");
            const theme = document.documentElement.classList.contains('dark') ? 'github-dark' : 'github';
            link.rel = "stylesheet";
            link.href = `https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/${theme}.min.css`;
            document.querySelector("head").append(link);
        }
        document.addEventListener('DOMContentLoaded', (event) => {
            changeHighlightJsTheme();
            hljs.highlightAll();

            document.addEventListener('theme-changed', () => {
                changeHighlightJsTheme();
                hljs.highlightAll();
                console.log('Theme changed');
            });
        });
    </script>
</head>

<body class="h-full bg-zinc-100 antialiased dark:bg-zinc-900">
    <div x-data="{ darkMode: localStorage.theme === 'dark' }" class="flex flex-col min-h-screen">
        <header
            class="bg-gray-900 text-white p-4 flex justify-between items-center border-b border-zinc-900/10 dark:border-white/10">
            <div class="flex items-center">
                <div class="mr-4">
                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#d83f22]"
                        viewBox="0 0 512 512" preserveAspectRatio="xMidYMid meet" xmlns:bx="https://boxy-svg.com">
                        <g transform="translate(0.0,512) scale(0.1,-0.1)" fill="currentColor" stroke="none">
                            <path d="M200 4520 l0 -230 2360 0 2360 0 0 230 0 230 -2360 0 -2360 0 0 -230z" />
                            <path
                                d="M280 2560 l0 -1520 890 0 890 0 0 240 0 240 -627 2 -628 3 -3 1278 -2 1277 -260 0 -260 0 0 -1520z" />
                            <path d="M200 600 l0 -230 2360 0 2360 0 0 230 0 230 -2360 0 -2360 0 0 -230z" /><text
                                style="font-family: Roboto; font-size: 4280px; font-weight: 700; text-transform: uppercase; white-space: pre;"
                                transform="matrix(1, 0, 0, -1, 0, 0)" x="2268.58" y="-1044.6">B</text>
                        </g>
                    </svg>
                </div>
                <h1 class="text-xl font-bold">
                    <a href="{{ route('lookbook.index') }}">Laravel Lookbook</a>
                </h1>
            </div>

            <button class="px-4 py-2 bg-gray-700 rounded-md text-sm flex items-center gap-2" @click="darkMode = !darkMode;
                document.documentElement.classList.toggle('dark');
                localStorage.theme = darkMode ? 'dark' : 'light';
                document.dispatchEvent(new Event('theme-changed'));">
                <svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="h-6 w-6 stroke-white dark:hidden">
                    <path d="M12.5 10a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"></path>
                    <path stroke-linecap="round"
                        d="M10 5.5v-1M13.182 6.818l.707-.707M14.5 10h1M13.182 13.182l.707.707M10 15.5v-1M6.11 13.889l.708-.707M4.5 10h1M6.11 6.111l.708.707">
                    </path>
                </svg>
                <svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="hidden h-6 w-6 stroke-white dark:block">
                    <path d="M15.224 11.724a5.5 5.5 0 0 1-6.949-6.949 5.5 5.5 0 1 0 6.949 6.949Z"></path>
                </svg>
                <span x-text="darkMode ? 'Dark mode' : 'Light mode'"></span>
            </button>
        </header>

        <div class="flex flex-1">
            <div class="w-96 max-w-96 p-4 border-r border-zinc-900/10 dark:border-white/10">
                @include('lookbook::components.navigation')
            </div>
            <div class="w-full">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Check for dark mode preference
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) &&
            window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            localStorage.theme = 'dark';
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.theme = 'light';
        }
    </script>
</body>

</html>