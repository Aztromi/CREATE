@extends('admin.index')

@section('contentAdmin')
<section>
    <h1>Thumbnail Creator</h1>
    <hr>
    <!-- <form action="{{ route('admin.add-thumbnail.update') }}" method="POST">

        @foreach ($stories as $story)
        <input type="hidden" name="ids[]" value="{{ $story->id  }}">
        <input type="hidden" name="images[]" value="{{ 'folder_user-uploads/' . $story->ownerable_id . '/stories/' . $story->cover_image }}">
        @endforeach

        <button type="submit" class="btn btn-secondary">Add Thumbnails</button>
    </form> -->
    @if (session('success'))
    <div style="padding: 10px; background: #d1e7dd; color: #0f5132; border-radius: 5px; margin-bottom: 15px;">
        <strong>Updated thumbnails:</strong>
        <ul>
            @foreach (session('success') as $item)
            @if ($item)
            <li>{{ $item }}</li>
            @endif
            @endforeach
        </ul>
    </div>
    @endif
    <!-- Profiles -->
    <div class="table-responsive mt-60 mb-60">
         <form action="{{ route('admin.add-thumbnail.update') }}" method="POST">
            @csrf
                    <button type="submit" class="btn btn-secondary">Add Thumbnails</button>
             <table class="w-100">
                 <thead class="sticky-top mt-5 bg-white text-nowrap">
                     <tr>
                         <td>No.</td>
                         <td>ID</td>
                         <td>Name</td>
                         <td>Display Name</td>
                         <td>Company Name</td>
                         <td>Display Photo</td>
                         <td>Thumbnail Applied</td>
                         <td>Cover Photo</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($profileData as $index => $profile)
                        <input type="hidden" name="ids[]" value="{{ $profile->user_id  }}">
                        <input type="hidden" name="images[]" value="{{ 'folder_user-uploads/' . $profile->user_id . '/Profile/' . $profile->uindie->display_photo }}">
                        <tr>
                            <td class="px-2">{{ $index + 1 }}</td>
                            <td class="px-2">{{ $profile->user_id }}</td>
                            <td class="px-2">{{ $profile->first_name }} {{ $profile->last_name }}</td>
                            <td class="px-2">{{ $profile->display_name }}</td>
                            <td class="px-2">{{ $profile->company_name }}</td>
                            <td class="px-2">
                               <img src="
                                        @if($profile->uindie->display_photo)
                                            {{ @asset('folder_user-uploads/' . $profile->user_id . '/Profile/' . $profile->uindie->display_photo) }}
                                        @else
                                            {{ @asset('/img/default_profile_img.png') }}
                                        @endif
                                    " alt="{{ @$profile->latestSlug->value  }}" 
                                    height="50"
                                    loading="lazy">
                            </td>
                            <td class="px-2">
                                <img src="
                                @if($profile->uindie->display_photo)
                                {{ @asset('folder_user-uploads/' . $profile->user_id . '/Profile/thumbnails/' . $profile->uindie->display_photo) }}
                                @else
                                {{ @asset('/img/default_profile_img.png') }}
                                @endif
                                " alt="{{ @$profile->latestSlug->value  }}" 
                                height="50"
                                loading="lazy">
                            </td>
                         <td class="px-2">
                             <img src="{{ asset('folder_user-uploads/' . $profile->user_id . '/Profile/thumbnails/' . rawurlencode($story->cover_image)) }}" width="300px">
                         </td>
                     </tr>
                     @endforeach
                 </tbody>
             </table>
    </form>
    </div>

    <!-- Stories -->
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
                    <td class="px-2">
                        <img src="{{ asset('folder_user-uploads/' . $story->ownerable_id . '/stories/thumbnails/' . rawurlencode($story->cover_image)) }}" width="300px">
                    </td>
                    <td class="px-2">{{ $story->link }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection
