@extends('layouts.app')

@section('styles')
    <style>
        body{
            background-color: #151515 !important;
        }

        .menu-item-container>.row {
            color: #F5F5F5;
            border: 1px solid #454545;
            padding: 20px 10px !important;
            border-radius: 20px;
            margin: 5px;
        }

        .menu-item-container table {
            color: #F5F5F5;
        }

        .menu-item-container table tbody tr td:nth-child(1) {
            text-transform: uppercase;
        }

        .menu-item-container table tbody tr:nth-child(-n + 3) td {
            font-weight: bold;
        }

        .menu-item-container table tbody tr:nth-child(1) td {
            font-size: 24px;
            color:rgb(52, 232, 43);
        }
        .menu-item-container table tbody tr:nth-child(2) td {
            font-size: 22px;
            color:rgb(242, 255, 0);
        }
        .menu-item-container table tbody tr:nth-child(3) td {
            font-size: 18px;
            color:rgb(255, 145, 0);
        }

        .menu-item-container .btn-container .btn {
            border: 0;
            background-color:rgb(188, 19, 19);
        }
    </style>
@endsection

@section('scripts-bottom')
    <script>
        $(document).ready(function(){

            $('.btn-snake').on('click', function(e){
                e.preventDefault();
                window.location.href = "{{ route('play.select', ['game' => 'snake']) }}";
            });
            
            $('.btn-tetris').on('click', function(e){
                e.preventDefault();
                window.location.href = "{{ route('play.select', ['game' => 'tetris']) }}";
            });
        });
    </script>
@endsection

@section('content')

{{--
    <section class="p-0">
        <div class="container p-0">
            <div class="row">
                <div class="col-12">
                    <img class="w-100 banner-img" src="{{ asset('img/static/2025_PGDX/Rectangle_90.png') }}" alt="CREATEPhilippines x PGDX logo">
                </div>
            </div>
        </div>
    </section>
--}}

<br><br>

    <section class="p-3">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center text-light mt-2 mb-5">
                    <span>Scores and final rankings are provisional and subject to validation.</span>
                </div>
                <div class="col-12 col-md-6 menu-item-container mx-auto">
                    <div class="row">
                        <div class="col-12 text-center"><h2>SNAKE</h2></div>
                        <div class="col-12 text-center mt-3"><h4>Leaderboard</h4></div>
                        <div class="col-12 leader-table pl-3 pr-3">
                            @if($snake_leader->isEmpty())
                                <div class="text-center">No recorded scores</div>
                            @else
                                <table class="table table-dark">
                                    <thead>
                                        <th>Nickname</th>
                                        <th>Score</th>
                                    </thead>
                                    <tbody>
                                        @foreach($snake_leader as $result)
                                        <tr>
                                            <td>{{ $result['nickname'] ?: '-' }}</td>
                                            <td>{{ $result['score'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div class="col-12 btn-container text-center mt-4">
                            <button class="btn btn-primary btn-lg btn-snake">Play Snake</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 menu-item-container">
                    <div class="row">
                        <div class="col-12 text-center"><h2>TETRIS</h2></div>
                        <div class="col-12 text-center mt-3"><h4>Leaderboard</h4></div>
                        <div class="col-12 leader-table pl-3 pr-3">
                            @if($tetris_leader->isEmpty())
                                <div class="text-center">No recorded scores</div>
                            @else
                                <table class="table table-dark">
                                    <thead>
                                        <th>Nickname</th>
                                        <th>Score</th>
                                    </thead>
                                    <tbody>
                                        @foreach($tetris_leader as $result)
                                        <tr>
                                            <td>{{ $result['nickname'] }}</td>
                                            <td>{{ $result['score'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div class="col-12 btn-container text-center mt-4">
                            <button class="btn btn-primary btn-lg btn-tetris">Play Tetris</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
@endsection