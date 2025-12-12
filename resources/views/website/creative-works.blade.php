<div class="works-container">
    <!-- <h2>
        Images
    </h2>
    <hr> -->

    @if($articles->isEmpty())
    No uploaded Creative Works

    @else
    
    <div class="works-list">
        <div class="image-container">
              @foreach($articles as $story)
                  
                  <div class="image">
                    <a href="{{ route('creative-works.view', ['slug' => $story->latestSlug->value]) }}">
                      <img src="{{ asset('folder_user-uploads/' . $story->ownerable_id . '/stories/' . $story->cover_image) }}" alt="{{ $story->latestSlug->value }}" />
                      <div class="image-caption">{{ $story->title }}</div>
                    </a>
                  </div>
                  
              @endforeach
        </div>
    </div>

    @endif
    
    <div class="mt-50 mb-50"></div>

    {{--
    <h2>
        Videos
    </h2>
    <hr>

    @if($videos->isEmpty())
    No uploaded Videos

    @else

    <div class="works-list">
        <div class="image-container">
            @foreach($videos as $story)
                
                <div class="image">
                  <a href="{{ route('creative-works.view', ['slug' => $story->latestSlug->value]) }}">
                    <img src="{{ asset('folder_user-uploads/' . $story->ownerable_id . '/stories/' . $story->cover_image) }}" alt="{{ $story->latestSlug->value }}" />
                    <div class="image-caption">{{ $story->title }}</div>
                  </a>
                </div>
                
            @endforeach
        </div>        
    </div>

    @endif

    <div class="mt-50 mb-50"></div>
    --}}

    <!-- <h2>
        Drafts
    </h2>
    <hr>
    <div class="works-list">
        <div class="image-container">
            <div class="image">
              <img src="https://createphilippines.com/upload/stories/Screenshot%20(563)-CyvOfP1W.png" alt="Insert work title here" />
              <div class="image-caption">Insert work title here</div>
            </div>
            <div class="image">
              <img src="https://createphilippines.com/upload/stories/Photo-PXJU1yfr.png" alt="Insert work title here" />
              <div class="image-caption">Insert work title here</div>
            </div>
            <div class="image">
              <img src="https://createphilippines.com/upload/stories/Screenshot%20(563)-CyvOfP1W.png" alt="Insert work title here" />
              <div class="image-caption">Insert work title here</div>
            </div>
            <div class="image">
              <img src="https://createphilippines.com/upload/stories/30th%20year%20KV-wh5O8ZTV.JPG" alt="Insert work title here" />
              <div class="image-caption">Insert work title here</div>
            </div>
            <div class="image">
              <img src="https://createphilippines.com/upload/stories/Screenshot%20(563)-CyvOfP1W.png" alt="Insert work title here" />
              <div class="image-caption">Insert work title here</div>
            </div>
            <div class="image">
              <img src="https://createphilippines.com/upload/stories/Photo-PXJU1yfr.png" alt="Insert work title here" />
              <div class="image-caption">Insert work title here</div>
            </div>
            <div class="image">
              <img src="https://createphilippines.com/upload/stories/Screenshot%20(563)-CyvOfP1W.png" alt="Insert work title here" />
              <div class="image-caption">Insert work title here</div>
            </div>
        </div>        
    </div> -->
</div>