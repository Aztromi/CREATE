<html>
    <body style="color: #aaaaaa; font-family: 'open sans';">
        <h1>{{ $textHeader }}</h1>

        @foreach($users as $user)
            {{ $user->name }}<br>

        @endforeach

        <h1>USERS2</h1>
        {{ $users2 }}


        <h1>TOKEN TEST</h1>
        {{ $token }}

        

        {{--

        <h1>USER PROFILE</h1>

        @foreach($userProfile as $profile)
            {{ $profile->profile->uindie->display_photo ?: ''  }}<br><br>

        @endforeach
        --}}

        
        <h1>PASWWORD TEST</h1>
        <h3>{{ $passTest }}</h3>


        {{-- 
            
        --}}

        <h1>RSets</h1>
        @foreach($prasses as $prass)
            {{ $prass['email'] . "||" . $prass['ids'] . "||" . $prass['pass'] }}<br>
        @endforeach 
        

        {{-- $profileData->user_id --}}<br>

        
        {{-- CREATIVE PROFILE AND WORKS IMAGE HEADER CHECK

        <h1>PROFILES</h1>
        @foreach($creatives as $creative)
        <h2 style="color: #333333;">ID: {{ $creative->id }} &emsp; Display Name: {{ $creative->profile->dispName }}</h2>
        <table border="1">
            <tr><td>
                <h3>Profile Picture</h3>
                <strong>Image Path:</strong> {{ asset('folder_user-uploads/' . $creative->id . '/Profile/' . $creative->profile->uindie->display_photo) }}<br>
                <img width="300" class="myImage" src="
                    @if($creative->profile->uindie->display_photo)
                        {{ asset('folder_user-uploads/' . $creative->id . '/Profile/' . $creative->profile->uindie->display_photo) }}
                    @else
                        {{ asset('/img/default_profile_img.png') }}
                    @endif
                ">
            </td></tr>
        </table>
        

        <h3>Stories Cover Photo</h3>    
        
        <table border="1" width="500">
            <tr>
                @if(!$creative->stories->isEmpty())

                    @foreach($creative->stories as $story)
                        <td>
                            Image Path: {{ asset('folder_user-uploads/' . $creative->id . '/stories/' . $story->cover_image) }}<br>
                            <img width="200" src="{{ asset('folder_user-uploads/' . $creative->id . '/stories/' . $story->cover_image) }}" >
                        </td>
                    @endforeach

                @else
                    <td>
                        NO STORIES
                    </td>
                    
                @endif
            </tr>
        </table>




            <h2> END OF ID: {{ $creative->id }} &emsp; Display Name: {{ $creative->profile->dispName }}</h2><br>
            <br>
        @endforeach


        {{ $creatives->links() }}

        END CREATIVE PROFILE AND WORKS IAMGE HEADER CHECK --}}

        {{--
        @if($creativeWorks)
            @foreach($creativeWorks as $cWork)
            <table style="border: 1px solid black;"><tr>
                <td>
                    U:<strong>{{ $cWork->ownerable_id }}</strong> | W:<strong>{{ $cWork->id }}</strong> <br>
                    <img width="200" src="{{ asset('folder_user-uploads/' . $cWork->ownerable_id . '/stories/' . $cWork->cover_image) }}" alt=""><br>
                    <div style=" width: 200px; word-wrap: break-word;">Image Path: {{ asset('folder_user-uploads/' . $cWork->ownerable_id . '/stories/' . $cWork->cover_image) }}</div>
                </td>
                @if(!$cWork->storyContents->isEmpty())
                    @foreach($cWork->storyContents as $wContent)
                    <td width="200">
                        <strong>Content</strong><br>
                        Type: {{ $wContent->type }}<br>
                        Value: {{ $wContent->value }}<br>

                        @switch($wContent->type)
                            @case('image')
                                <img width="200" src="{{ asset('folder_user-uploads/' . $wContent->ownerable_id . '/stories/' . $wContent->value) }}" alt=""><br>
                            @break
                            @default
                                {{ $wContent->value }}
                            @break
                        @endswitch
                    </td>

                    $count++;
                    @endforeach
                @endif
            </tr></table><br>
                
            @endforeach

            {{ $creativeWorks->links() }}
        @endif
        --}}



        <h2>SLUG TEST</h2>
        @foreach($slugTest as $article)
            {{ $article->name}}&emsp;||
            &emsp;{{ $article->latestSlug->value }}<br>
        @endforeach


        

        <script>
            var imgs = document.getElementsByTagName('img');
            for (var i = 0; i < imgs.length; i++) {
                var img = imgs[i];
                var widthSpan = document.createElement('span');
                widthSpan.textContent = img.naturalWidth;
                var heightSpan = document.createElement('span');
                heightSpan.textContent = img.naturalHeight;
                var widthLabel = document.createTextNode('Actual image width: ');
                var heightLabel = document.createTextNode('Actual image height: ');
                img.parentNode.insertBefore(widthLabel, img);
                img.parentNode.insertBefore(widthSpan, img);
                img.parentNode.insertBefore(document.createElement('br'), img);
                img.parentNode.insertBefore(heightLabel, img);
                img.parentNode.insertBefore(heightSpan, img);
                img.parentNode.insertBefore(document.createElement('br'), img);
            }
        </script>


        
        
    </body>
</html>