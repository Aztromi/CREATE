@extends('admin.index')

@section('styles')
    @include('shared.creative-works.form.styles')
@endsection

@section('scripts-bottom')
    @include('shared.creative-works.form.scripts')
    <script src="{{ asset('js/userdash/creative-works/form.js?ver='.time()) }}"></script>
@endsection

@section('contentAdmin')
    @include('shared.creative-works.form.content')
@endsection