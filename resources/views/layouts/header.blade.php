<nav class="navbar navbar-expand-xl navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}" alt="{{ config('app.name', 'Create Philippines') }}" title="{{ config('app.name', 'Create Philippines') }}">
            <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name', 'Create Philippines') }}">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
           @include('layouts.navigation')
        </div>
    </div>
</nav>