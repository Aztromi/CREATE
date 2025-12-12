@extends('admin.index')

@section('contentAdmin')
    @include('shared.connect-creatives.list.list')
@endsection

@include('shared.connect-creatives.list.dependent')