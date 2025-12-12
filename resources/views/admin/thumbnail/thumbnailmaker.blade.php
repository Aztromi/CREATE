@extends('admin.index')

@section('contentAdmin')
<section>
    <h1>Thumbnail Creator</h1>
    <hr>
    <form action="{{ route('admin.add-thumbnail.update') }}" method="POST">
        @csrf

        @foreach ($stories as $story)
        <input type="hidden" name="ids[]" value="{{ $story->id }}">
        @endforeach

        <button type="submit" class="btn btn-secondary">Add Thumbnails</button>
    </form>
    @if (session('success'))
    <div style="padding: 10px; background: #d1e7dd; color: #0f5132; border-radius: 5px; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
    @endif
    <div class="table-responsive mt-60 mb-60">
        <table class="w-100">
            <thead class="sticky-top mt-5 bg-white text-nowrap">
                <tr>
                    <td>No.</td>
                    <td>Title</td>
                    <td>Ownerable ID</td>
                    <td>Image Name</td>
                    <td>Cover Image</td>
                    <td>Thumbnail</td>
                    <td>Link</td>
                </tr>
            </thead>
            <tbody>
                @foreach($stories as $story)
                <tr>
                    <td class="px-2">{{ $story->id }}</td>
                    <td class="px-2">{{ $story->title }}</td>
                    <td class="px-2">Name: {{ $story->ownerable_id }}</td>
                    <td class="px-2">{{ $story->cover_image }}</td>
                    <td class="px-2">
                        <img src="{{ asset('folder_user-uploads/' . $story->ownerable_id . '/stories/' . rawurlencode($story->cover_image)) }}" width="300px">

                    </td>
                    <td class="px-2">{{ $story->thumbnail }}</td>
                    <td class="px-2">{{ $story->link }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>


@endsection