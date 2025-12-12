@extends('layouts.app')

@section('styles')
<style>
    .valLabel {
        width: 100%;
        font-size: 17px;
        color: #777777;
        line-height: 18px;

    }

    .valMain {
        width: 100%;
        font-size: 24px;
        color: #D9D9D9;
        line-height: 25px;
        
    }

    .sectionMain {
        color: #FFFFFF;
        font-size: 25px;
        font-weight: bold;
    }

    .sectionHead {
        color: #AAAAAA;
        font-size: 25px;
        font-weight: bold;
    }

    .txtLink {
        color: #3aa4f3;
        text-decoration: none;
    }

    ul.no-bullets {
        list-style-type: none;
        padding-left: 0;
    }
</style>
@endsection

@section('content')

<div class="bg_black25 registration-fields">
    <div class="container-fluid login-container">
        <div class="row">
        @include('components.half_pane_works')
            <div class="col-xs-12 col-lg-6">
                <section>
                    <div class="row">
                        <div class="col-12 text-center">
                            <h1>Registration Summary</h1>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-12">
                            <span class="sectionMain">Basic Information</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="valLabel">Display Name</label>
                            <span class="valMain" id="dispName">{{ $profile->dispName ?: '-' }}</span>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="valLabel">First Name</label>
                            <span class="valMain" id="firstname">{{ $profile->first_name ?: '-' }}</span>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="valLabel">Last Name</label>
                            <span class="valMain" id="firstname">{{ $profile->last_name ?: '-' }}</span>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="valLabel">Gender</label>
                            <span class="valMain" id="gender">{{ ucwords($profile->gender) ?: '-' }}</span>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="valLabel">E-mail</label>
                            <span class="valMain" id="email">{{ $profile->user->email ?: '-' }}</span>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="valLabel">Alternate E-mail</label>
                            @php
                                $emailAlt = $profile->emails->where('value', '!=', $profile->user->email)->first();
                            @endphp
                            <span class="valMain" id="email-alternate">{{ $emailAlt ?: '-' }}</span>
                        </div>

                        @php
                            $numPrimary = '';
                            $numAlt = '';
                            $numLandline = '';
                        @endphp
                        @if($profile->numContacts->count() > 0)
                            @foreach($profile->numContacts as $contact)
                                @if($contact->type == 'primary')
                                    @php $numPrimary = $contact->number; @endphp
                                @elseif($contact->type == 'alternate')
                                    @php $numAlt = $contact->number; @endphp
                                @elseif($contact->type == 'landline')
                                    @php $numLandline = $contact->number; @endphp
                                @endif
                            @endforeach
                        @endif

                        <div class="col-sm-6 mb-3">
                            <label class="valLabel">Mobile No.</label>
                            <span class="valMain" id="mobile">{{ $numPrimary ?: '-' }}</span>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="valLabel">Alternate Mobile No.</label>
                            <span class="valMain" id="mobile-alternate">{{ $numAlt ?: '-' }}</span>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="valLabel">Landline No.</label>
                            <span class="valMain" id="telephone">{{ $numLandline ?: '-' }}</span>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="valLabel">Address</label>
                            @php
                                $addr = '';
                                $addrVar = $profile->addressLatest;
                                if($addrVar){
                                    $addr .= $addrVar->block_lot ? $addrVar->block_lot . ', ' : '';
                                    $addr .= $addrVar->municipality ? $addrVar->municipality . ', ' : '';

                                    if($addrVar->country = 'Philippines'){   
                                        $addr .= $addrVar->province ? $addrVar->province . ', ' : '';
                                        $addr .= $addrVar->region ? $addrVar->region . ', ' : '';
                                    }
                                    else{
                                        $addr .= $addrVar->region ? $addrVar->region . ', ' : '';
                                    }

                                    $addr .= $addrVar->country ? $addrVar->country : '';
                                    $addr .= '  ' . $addrVar->postal_code ? ' ' . $addrVar->postal_code : '';
                                    
                                }

                            @endphp
                            <span class="valMain" id="address">{{ $addr ?: '-' }}</span>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-12">
                            <span class="sectionMain">Representation</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="valLabel">Representation / Category</label>
                            <span class="valMain" id="rep">{{ $profile->uindie->expertise ?: '-' }}</span>
                        </div>
                        
                        @if($profile->uindie->expertise != 'Individual / Independent / Freelance / Student')
                            @php
                                $repLbl = '';

                                if($profile->uindie->expertise != 'Individual / Independent / Freelance / Student')
                                {
                                    $repLbl = $profile->uindie->expertise;
                                }
                            @endphp

                            <div class="col-12 mb-3">
                                <label class="valLabel">{{ $repLbl ?: '' }} Name</label>
                                <span class="valMain" id="org">{{ $profile->company->company_name }}</span>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="valLabel">{{ $repLbl ?: '' }} Address</label>
                                @php
                                    $repAddr= '';
                                    $addrVar2 = $profile->company->addressLatest;
                                    if($addrVar2){
                                        $repAddr.= $addrVar2->block_lot ? $addrVar2->block_lot . ', ' : '';
                                        $repAddr.= $addrVar2->municipality ? $addrVar2->municipality . ', ' : '';

                                        if($addrVar2->country = 'Philippines'){   
                                            $repAddr.= $addrVar2->province ? $addrVar2->province . ', ' : '';
                                            $repAddr.= $addrVar2->region ? $addrVar2->region . ', ' : '';
                                        }
                                        else{
                                            $repAddr.= $addrVar2->region ? $addrVar2->region . ', ' : '';
                                        }

                                        $repAddr.= $addrVar2->country ? $addrVar2->country : '';
                                    }
                                @endphp
                                <span class="valMain" id="repAddress">{{ $repAddr ?: '' }}</span>
                            </div>
                        @endif
                    </div>

                    @if($profile->uindie->expertise != 'Individual / Independent / Freelance / Student')

                        <div class="row mt-5 mb-3">
                            <div class="col-12">
                                <span class="sectionHead">{{ $repLbl ?: '' }} Details</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="valLabel">Company Size</label>
                                <span class="valMain" id="co_size">{{ $profile->company->company_size ?: '-' }}</span>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="valLabel">No. of Direct Workers</label>
                                <span class="valMain" id="co_direct">{{ $profile->company->company_direct_workers ?: '-' }}</span>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="valLabel">No. of Indirect Workers</label>
                                <span class="valMain" id="co_indirect">{{ $profile->company->company_indirect_workers ?: '-' }}</span>
                            </div>
                        </div>

                        <div class="row mt-5 mb-3">
                            <div class="col-12">
                                <span class="sectionHead">Representative Details</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="valLabel">Representative First Name</label>
                                <span class="valMain" id="rep_fname">{{ $profile->company->rep_fname ?: '-' }}</span>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="valLabel">Representative Last Name</label>
                                <span class="valMain" id="rep_lname">{{ $profile->company->rep_lname ?: '-' }}</span>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="valLabel">Representative Gender</label>
                                <span class="valMain" id="rep_gender">{{ ucwords($profile->company->rep_gender) ?: '-' }}</span>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="valLabel">Representative E-mail Address</label>
                                <span class="valMain" id="rep_email">{{ $profile->company->rep_email ?: '-' }}</span>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="valLabel">Representative Mobile No.</label>
                                <span class="valMain" id="rep_mobile">{{ $profile->company->rep_mobile ?: '-' }}</span>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="valLabel">Job Title/Designation</label>
                                @php
                                    $jobs = '';
                                    if($profile->jobTitles)
                                    {
                                        $jobs = $profile->jobTitles->pluck('value')->implode(', ');
                                    }
                                @endphp
                                <span class="valMain" id="jobs">{{ $jobs ?: '-' }}</span>
                            </div>
                        </div>

                        <div class="row mt-5 mb-3">
                            <div class="col-12">
                                <span class="sectionHead">Owner Details</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <span class="valLabel">Same as Representative Details: </span>
                                @php
                                    if($profile->company->same_rep_owner == 1){
                                        $sameAsRep = 'Yes';
                                    }
                                    else{
                                        $sameAsRep = 'No';
                                    }
                                @endphp
                                <span class="valMain">{{ $sameAsRep ?: '-' }}</span>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="valLabel">Owner First Name</label>
                                <span class="valMain" id="owner_fname">{{ $profile->company->owner_fname ?: '-' }}</span>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="valLabel">Owner last Name</label>
                                <span class="valMain" id="owner_lname">{{ $profile->company->owner_lname ?: '-' }}</span>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="valLabel">Owner Gender</label>
                                <span class="valMain" id="owner_gender">{{ $profile->company->owner_gender ?: '-' }}</span>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="valLabel">Owner E-mail</label>
                                <span class="valMain" id="owner_email">{{ $profile->company->owner_email ?: '-' }}</span>
                            </div>
                            
                        </div>

                    @endif
                    
                    <hr>

                    <div class="row mb-3">
                        <div class="col-12">
                            <span class="sectionMain">Categories</span>
                        </div>
                    </div>
                    @php
                        $expertises = '';
                        $main_expertise = '';
                        if($profile->uindie->expertises){
                            $expertises = $profile->uindie->expertises->where('type', 'expertise')->pluck('value')->implode(', ');
                            $main_expertise = $profile->uindie->expertises->where('type', 'main')->first();
                        }
                    @endphp
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="valLabel">Area of Expertise</label>
                            <span class="valMain" id="expertises">{{ $expertises ?: '-' }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="valLabel">Main Creative Services Offered</label>
                            <span class="valMain" id="main-expertise">{{ $main_expertise->value ?: '-' }}</span>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-12">
                            <span class="sectionMain">Uploaded Requirements</span>
                        </div>
                    </div>
                    <div class="row mt-5 mb-3">
                        <div class="col-12">
                            <span class="sectionHead">Sample Works</span>
                        </div>
                    </div>
                    
                    @if(substr($profile->upload_drive_date, 0, 10) == $dateToday->toDateString())
                        <div class="row">
                            <div class="col-12 mb-3">
                                <span class="valLabel">Drive Link: </span>
                                <span class="valMain">
                                    <a href="{{ $profile->upload_drive_link }}" class="txtLink" target="_blank" rel="noopener noreferrer">
                                        {{ $profile->upload_drive_link }}
                                    </a>
                                    
                                </span>
                            </div>
                        </div>
                    @endif
                    
                    <div class="row groupUpload">
                        <div class="col-12 mb-3">
                            <label class="valLabel">Sample Works Upload:</label>
                            <span class="valMain" id="uploadWorks">
                                -
                            </span>
                        </div>
                    </div>

                    <div class="row mt-3 mb-3 groupUpload">
                        <div class="col-12">
                            <span class="sectionHead" id="headGov">-</span>
                        </div>
                    </div>

                    <div class="row groupUpload">
                        <div class="col-12 mb-3">
                            <span class="valMain" id="uploadGov">
                                -
                            </span>
                        </div>
                    </div>

                    <div class="row mt-3 mb-3 groupUpload groupBir">
                        <div class="col-12">
                            <span class="sectionHead" id="headBir">BIR Certificate of Registration</span>
                        </div>
                    </div>

                    <div class="row groupUpload groupBir">
                        <div class="col-12 mb-3">
                            <span class="valMain" id="uploadBir">
                                -
                            </span>
                        </div>
                    </div>

                    <div class="row mt-5 mb-3">
                        <div class="col-12 text-end">
                            
                            <form method="POST" action="{{ route('user.register.registrationSubmission') }}">
                            @csrf
                                <input type="hidden" name="reg_type" value="{{ $reg_type }}">
                                <a href='{{ route('user.register.upload-verified', ['type' => $reg_type]) }}' class="btn btn-secondary btn-lg">Back</a>
                                <button class="btn btn-primary btn-lg">Submit</button>
                            </form>
                            
                            
                        </div>
                    </div>


                </section>
                        
            </div>
        </div>
        
        
        
    </div>
</div>

@endsection

@section('scripts-bottom')
<script>
    function presets(){
        @if($profile->user->uploadedRequirements->count() == 0)
            $('.groupUpload').hide();
        @else
            @php 
                $works = $profile->user->uploadedRequirements->where('type', 'portfolio');
                $govs = $profile->user->uploadedRequirements->where('type', 'goverment-document');
                $birs = $profile->user->uploadedRequirements->where('type', 'bir-document');
            @endphp
            
            @if($works->count() > 0)
                var $ulWorks = $('<ul class="no-bullets"></ul>');
                $('#uploadWorks').html($ulWorks);
                @foreach($works as $work)
                    $ulWorks.append('<li><a class="txtLink" href="' + '{{ asset('folder_requirements/' . $profile->user->id . '/requirements/' . $work->file) }}' + '" target="_blank" rel="noopener noreferrer">' + '{{ $work->file }}' + '</a></li>');
                @endforeach
            @endif

            @if($reg_type == 'creative')
                $('#headGov').text('Business Permit/ID Upload');

                @if($birs->count() > 0)
                    var $ulBir = $('<ul class="no-bullets"></ul>');
                    $('#uploadBir').html($ulBir);
                    @foreach($birs as $bir)
                        $ulBir.append('<li><a class="txtLink" href="' + '{{ asset('folder_requirements/' . $profile->user->id . '/requirements/' . $bir->file) }}' + '" target="_blank" rel="noopener noreferrer">' + '{{ $bir->file }}' + '</a></li>');
                    @endforeach
                @endif

            @elseif($reg_type == 'exhibitor')
                $('#headGov').text('Permit to Operate Upload');
                $('.groupBir').hide();
            @endif

            @if($govs->count() > 0)
                var $ulGov = $('<ul class="no-bullets"></ul>');
                $('#uploadGov').html($ulGov);
                @foreach($govs as $gov)
                    $ulGov.append('<li><a class="txtLink" href="' + '{{ asset('folder_requirements/' . $profile->user->id . '/requirements/' . $gov->file) }}' + '" target="_blank" rel="noopener noreferrer">' + '{{ $gov->file }}' + '</a></li>');
                @endforeach
            @endif
        @endif

    }

    $(document).ready(function(){
        presets();
    });
</script>
@endsection