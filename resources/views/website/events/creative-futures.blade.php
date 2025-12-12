<div class="events-container">
    @foreach($creativeFutures as $creativeFuture)
    <article>
        <div class="session">
            <p>{{ \Carbon\Carbon::parse($creativeFuture->event_start)->format('F d, Y') }}</p>
            <img src="{{ asset('folder_events/' . $creativeFuture->asset->path) }}" alt="Event title" class="img-fluid">
            <h3>
                {{ $creativeFuture->name }}
            </h3>
        </div>
        <a href="{{ route('events.creative-futures-session', ['slug' => $creativeFuture->latestSlug->value]) }}" style="text-decoration: none;">
            <div class="link-to-session">
                <h4>
                {{ $creativeFuture->blurb }}<span class="fas fa-external-link-square-alt"></span>
                </h4> 
            </div>
        </a>
    </article>
    @endforeach

    <!-- <article>
        <div class="session">
            <p>Month XX, XXXX</p>
            <img src="https://createphilippines.com/upload/assets/KeWoVh0MLiLNyZH4sJtk7Rt6HzxBWURafGyUCp2i2Za15C2OM7.jpg" alt="Event title" class="img-fluid">
            <h3>
                Event title 
                <br>Event randomlongtextforchecking
                <br>Event title
            </h3>
        </div>
        <a href="{{ url('events/creative-futures/sessions/asf') }}">
            <div class="link-to-session">
                <h4>
                    Event description<span class="fas fa-external-link-square-alt"></span>
                </h4> 
            </div>
        </a>
    </article> -->
    
    
</div>