@extends('tests.layout')

@section('styles')
<style>
    td{
        padding: 10px;
    }
</style>
@endsection
@section('content')
<div>
    
    <!-- <center><h1>Create Philippines</h1></center> -->
    <h2 style="padding-top: 50px;">TEST: Creative Works</h2>
    <table class="table-bordered">
        @foreach($creativeWorks as $work)
            <tr>
                <td style="vertical-align: top;">
                    <h3>Story Code: {{ $work->id }}||{{ $work->title }}</h3>
                    <img width="300" src="{{ asset('folder_user-uploads/' . $work->user->id . '/stories/' . $work->cover_image) }}" alt="{{ asset('folder_user-uploads/' . $work->user->id . '/stories/' . $work->cover_image) }}">
                </td>
                <td>
                    @if(!$work->storyContents->isEmpty())
                        <hr>
                        @foreach($work->storyContents as $content)
                            @if($content->type == 'image')
                                <strong style="color: rgb(207, 58, 9);">IMAGE: </strong><img width="300" src="{{ asset('folder_user-uploads/' . $work->user->id . '/stories/' . $content->value) }}" alt="{{ asset('folder_user-uploads/' . $work->user->id . '/stories/' . $content->value) }}">
                            @else
                            <strong style="color: rgb(207, 58, 9);">{{ $content->type }}: </strong>
                            <div style="max-width: 500px;">{!! $content->value !!}</div>
                            @endif
                            <br>
                        @endforeach
                    @else
                        No Content.
                    @endif
                </td>
            </tr>
        @endforeach

    </table>
    {{ $creativeWorks->links() }}
</div>
@endsection

@section('scripts-bottom')
<script>
    $(document).ready(function(){
        $('#btnStories').removeClass('btn-primary');
        $('#btnStories').addClass('btn-secondary');

        // $('#btnStories').on('click', function(e){
        //     e.preventDefault();
        // });
    });
    
</script>
@endsection