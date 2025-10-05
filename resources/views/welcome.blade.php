<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }} - Notification System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles and Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .card-hover {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="gradient-bg min-h-screen">
            <div class="relative min-h-screen flex flex-col items-center justify-center">
                <div class="relative w-full max-w-6xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                            <div class="text-center">
                                <h1 class="text-6xl font-bold text-white mb-4">🔔</h1>
                                <h2 class="text-4xl font-bold text-white mb-2">Notification System</h2>
                                <p class="text-xl text-white/80">Laravel-powered notification management</p>
                            </div>
                        </div>
                        @if (Route::has('login'))
                            <div class="-mx-3 flex flex-1 justify-end lg:col-start-3">
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="rounded-md px-6 py-3 text-white bg-white/20 backdrop-blur-sm ring-1 ring-white/30 transition hover:bg-white/30 focus:outline-none focus-visible:ring-white"
                                    >
                                        Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="rounded-md px-6 py-3 text-white bg-white/20 backdrop-blur-sm ring-1 ring-white/30 transition hover:bg-white/30 focus:outline-none focus-visible:ring-white mr-3"
                                    >
                                        Log in
                                    </a>

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="rounded-md px-6 py-3 text-white bg-white/20 backdrop-blur-sm ring-1 ring-white/30 transition hover:bg-white/30 focus:outline-none focus-visible:ring-white"
                                        >
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </header>

                    <main class="mt-6">
                        <div class="grid gap-6 lg:grid-cols-3 lg:gap-8">
                            <div class="card-hover flex flex-col items-start gap-6 rounded-lg border border-white/20 p-6 bg-white/10 backdrop-blur-sm hover:border-white/40">
                                <div class="text-4xl">📊</div>
                                <h2 class="text-xl font-semibold text-white">
                                    Real-time Dashboard
                                </h2>
                                <p class="text-sm/relaxed text-white/80">
                                    Monitor notification statistics and system performance in real-time.
                                </p>
                            </div>

                            <div class="card-hover flex flex-col items-start gap-6 rounded-lg border border-white/20 p-6 bg-white/10 backdrop-blur-sm hover:border-white/40">
                                <div class="text-4xl">👥</div>
                                <h2 class="text-xl font-semibold text-white">
                                    User Management
                                </h2>
                                <p class="text-sm/relaxed text-white/80">
                                    Manage users and track their notification preferences and activity.
                                </p>
                            </div>

                            <div class="card-hover flex flex-col items-start gap-6 rounded-lg border border-white/20 p-6 bg-white/10 backdrop-blur-sm hover:border-white/40">
                                <div class="text-4xl">⚡</div>
                                <h2 class="text-xl font-semibold text-white">
                                    Instant Notifications
                                </h2>
                                <p class="text-sm/relaxed text-white/80">
                                    Send and manage notifications with instant delivery and read tracking.
                                </p>
                            </div>
                        </div>
                    </main>

                    <footer class="py-16 text-center text-sm text-white/70">
                        <p>Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
                        <p class="mt-2">Built with ❤️ using Laravel & AdminLTE</p>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>