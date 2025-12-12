<div class="profile-container creative-profile">
    <h2>
        Contact Details
    </h2>
    <dl>
        <dd>NAME & DESIGNATION</dd>
            {{-- Insert Contact Person Name and designation --}}
            <dt>
                {{ $profileData->dispName }}
                @if($profileData->jobTitleLatest)
                <br><span>{{ $profileData->jobTitleLatest->value }}</span>
                @endif
                
            </dt>
        
            
            @if($profileData->hide_email != 1)
            <dd>EMAIL ADDRESS</dd>
                <dt>
                    @if($profileData->emails->count() === 0)
                        <a href="mailto:{{ $profileData->user->email }}">{{ $profileData->user->email }}</a>
                    @else
                        @foreach($profileData->emails as $email)
                            <a href="mailto:{{ $email->value }}">{{ $email->value }}</a><br>
                        @endforeach
                    @endif
                </dt>
            @endif
    </dl>

    @if(strlen(trim($profileData->about))>0)
    <hr>
    <h4>
        About {{ $profileData->dispName }}
    </h4>
    <p>
        {{ $profileData->about }}
    </p>
    @endif
</div>
<div class="profile-container creative-profile mt-60">
    <h2>
        Expertise Classification
    </h2>
    <dl>
        @if(!empty($profileData->uindie->expertise))
        <dd>CATEGORY</dd>
            <dt>
                {{ $profileData->uindie->expertise }}
            </dt>
        @endif
        @if(!$profileData->uindie->expertises->isEmpty())
        <hr>
        <dd>EXPERTISE AND SERVICES</dd>
            <dt>
                {{ $profileData->uindie->expertises->pluck('value')->implode(', ') }}
            </dt>
        @endif
        {{--
        @if($profileData->sector->isNotEmpty())
        <hr>
        <!-- AREAS OF INTEREST??? -->
        <dd>AREA/S OF EXPERTISE</dd> 
            <dt>
                {{ $profileData->sector->pluck('value')->implode(', ') }}
            </dt>
        @endif

        --}}
    </dl>
</div>