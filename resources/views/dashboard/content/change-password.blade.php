@extends('dashboard.index')

@section('userDashboard')
    @include('shared.change-password.form')
@endsection

@include('shared.change-password.dependents')