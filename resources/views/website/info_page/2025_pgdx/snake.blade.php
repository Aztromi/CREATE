@extends('layouts.app')

@section('styles')
    @include('website.info_page.2025_pgdx.games.snake.styles')
    @include('website.info_page.2025_pgdx.contact_form.styles')
    <style>
        body{
            background-color: #151515 !important;
        }

        .modal-content {
            background-color: transparent !important;
        }

        .modal-backdrop.show {
            opacity: .9 !important;
        }
    </style>
@endsection

@section('scripts-bottom')
    @include('website.info_page.2025_pgdx.games.snake.scripts')
    @include('website.info_page.2025_pgdx.contact_form.scripts')
    <script>
        $(document).ready(function(){
            $("#modal-game-snake").modal({ 
                backdrop: "static", 
                keyboard: false, 
            });

            $("#modal-game-form").modal({ 
                backdrop: "static", 
                keyboard: false, 
            });
            
            $('#modal-game-form #game-label').html('SNAKE');

            $('#modal-game-snake').modal('show');
        });
    </script>
@endsection

@section('content')

    {{--
    <section class="p-0">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <img class="w-100 banner-img" src="{{ asset('img/static/2025_PGDX/Rectangle_90.png') }}" alt="CREATEPhilippines x PGDX logo">
                </div>
            </div>
        </div>
    </section>
    --}}

    @include('website.info_page.2025_pgdx.games.snake.content')
    @include('website.info_page.2025_pgdx.contact_form.form')

    
@endsection