@extends('layouts.app')

@section('styles')
    @include('website.info_page.2025_pgdx.games.tetris2.styles')
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
    @include('website.info_page.2025_pgdx.games.tetris2.scripts')
    @include('website.info_page.2025_pgdx.contact_form.scripts')
    <script>
        $(document).ready(function(){
            $("#modal-game-form").modal({ 
                backdrop: "static", 
                keyboard: false, 
            });

            $("#modal-tetris-1").modal({ 
                backdrop: "static", 
                keyboard: false, 
            });
            
            $('#modal-game-form #game-label').html('TETRIS');

            $('#modal-tetris-1 .button-container #btn-start').on('click', function(){
                gameStart();
            });

            $('#modal-tetris-1 .button-container #btn-exit').on('click', function(){
                location.href = "{{ route('play.leaderboard') }}";
            });
            
            setGameModal('start', 0);
        });
    </script>
@endsection

@section('content')

    @include('website.info_page.2025_pgdx.games.tetris2.content')
    @include('website.info_page.2025_pgdx.contact_form.form')

    
@endsection