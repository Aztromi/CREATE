@extends('admin.index')

@section('styles')
    @include('shared.creative-works.list.styles')
    <style>
        .status-label {
            color: #FFFFFF;
            /* white-space: nowrap; */
            /* width: 100px; */
            display: inline;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 400;
            margin-bottom: 5px;
            border-radius: 15px 5px 15px 5px;
        }

        .status-label span{
            display: inline-block;
        }

        #approved-container {
            margin-right: 5px;
            background-color: #AAAAAA;

        }

        #verified-container {
            background-color: #888888;
            
        }
    </style>
@endsection

@section('scripts-bottom')
    @include('shared.creative-works.list.scripts')
    <script src="{{ asset('js/userdash/creative-works/list.js?ver='.time()) }}"></script>
@endsection

@section('contentAdmin')
    @include('shared.creative-works.list.content')
@endsection