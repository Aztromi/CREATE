@extends('dashboard.index')

@section('styles')
    @include('shared.creative-works.list.styles')
@endsection

@section('scripts-bottom')
    @include('shared.creative-works.list.scripts')
    <script src="{{ asset('js/userdash/creative-works/list.js?ver='.time()) }}"></script>
@endsection

@section('userDashboard')
    @include('shared.creative-works.list.content')
@endsection