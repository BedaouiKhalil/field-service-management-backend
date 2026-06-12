<!DOCTYPE html>
<html lang="en">

@include('layouts.shared.head')

<body>
    <div class="wrapper">
        @include('layouts.admin.partials.sidebar')

        <div class="main">
            @include('layouts.admin.partials.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3"><strong>@yield('page-title', 'Dashboard') </strong>@yield('page-subtitle')</h1>
                    @if (session('success'))
                        <input type="hidden" id="flash-success" value="{{ session('success') }}">
                    @endif
                    @if (session('error'))
                        <input type="hidden" id="flash-error" value="{{ session('error') }}">
                    @endif
                    @yield('content')
                </div>
            </main>


        </div>
    </div>

    @include('layouts.admin.partials.script')
    @vite('resources/js/app.js')
    @stack('scripts')

</body>

</html>
