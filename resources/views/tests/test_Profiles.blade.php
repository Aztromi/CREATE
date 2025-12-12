@extends('tests.layout')

@section('content')
<div>
    
    <!-- <center><h1>Create Philippines</h1></center> -->
    <h2 style="padding-top: 50px;">TEST: Profiles</h2>
</div>


@endsection


@section('scripts-bottom')
<script>
    $(document).ready(function(){
        $('#btnProfiles').removeClass('btn-primary');
        $('#btnProfiles').addClass('btn-secondary');

        // $('#btnProfiles').on('click', function(e){
        //     e.preventDefault();
        // });
    });
    
</script>
@endsection