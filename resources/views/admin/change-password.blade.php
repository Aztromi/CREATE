@extends('admin.index')

@section('contentAdmin')
    @include('shared.change-password.form')
@endsection

@include('shared.change-password.dependents')