<footer>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-2">
                <a class="navbar-brand" href="{{ url('/') }}" alt="{{ config('app.name', 'Create Philippines') }}" title="{{ config('app.name', 'Create Philippines') }}">
                    <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name', 'Create Philippines') }}">
                </a>
                <div class="socials-footer">
                    @include('components.socials')
                </div>
            </div>
            <div class="col-xs-12 col-sm-8 navigation-footer">
                @include('layouts.navigation')
            </div>
            <div class="col-xs-12 col-sm-2">
                <p>
                    Copyright &copy; {{ date('Y') }}.
                    <br><a href="{{ url('/privacy-policy') }}">Privacy Policy</a>.
                </p>
            </div>
        </div>
    </div>
</footer>