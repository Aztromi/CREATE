@extends('tests.layout')

@section('styles')
<style>
    img{
        max-width: 400px;
    }
    table{
        max-width: 1000px;
    }
</style>
@endsection

@section('content')
<div>
    
    <!-- <center><h1>Create Philippines</h1></center> -->
    <h2 style="padding-top: 50px;">TEST: Articles</h2>
    <table class="table-bordered">
        @foreach($articles as $article)
        <tr>
            <td style="vertical-align: top;">
                <h3>Story Code: {{ $article->id }}||{{ $article->name }}</h3>
                <img width="300" src="{{ asset('folder_articles/' . $article->asset->path) }}" alt="{{ asset('folder_articles/' . $article->asset->path) }}"><br>
                Author: {{ $article->author }}<br>
                Date: {{ \Carbon\Carbon::parse($article->date)->format('F d, Y') }}
            </td>
            <td>{!! $article->content !!}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection

@section('scripts-bottom')
<script>
    $(document).ready(function(){
        $('#btnArticles').removeClass('btn-primary');
        $('#btnArticles').addClass('btn-secondary');

        // $('#btnArticles').on('click', function(e){
        //     e.preventDefault();
        // });
    });
    
</script>
@endsection