


@extends('admin.index')

@section('styles')
<!-- for multiple select -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

<style>
    .select2-selection__choice{
        background-color: blue;
    }

    .removeX {
        color: red;
        cursor: pointer;
    }

    .removeX:hover {
        cursor: pointer;
    }

    /* .clientX:hover {
        
    }

    .awardX:hover {
        cursor: pointer;
    } */

    #loadingModal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
    }

    .modal-content {
        background-color: transparent;
        box-shadow: none;
        border: none;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #0d6efd;
    }
    
</style>

@endsection

@section('scripts-bottom')

    <!-- for multiple select -->
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script>

        function presets()
        {
            @if($profile->user->requests == 0)
                $('#btn-deny').hide();
            @else
                $('#btn-deny').show();
            @endif

            @if($profile->user->approved == 1)
                $('#btn-approve').hide();
                $('#btn-disapprove').show();
            @else
                $('#btn-approve').show();
                $('#btn-disapprove').hide();
            @endif

            @if($profile->user->verified == -1)
                $('#btn-unverified').show();
                $('#btn-verified').hide();
            @elseif($profile->user->verified == 0)
                $('#btn-unverified').hide();
                $('#btn-verified').show();
            @else
                $('#btn-unverified').hide();
                $('#btn-verified').hide();
            @endif

            @if($profile->first_name != '')
                $('#fname').val('{{ $profile->first_name }}');
            @endif

            @if($profile->last_name != '')
                $('#lname').val('{{ $profile->last_name }}');
            @endif

            @if($profile->user->email != '')
                $('#email').val('{{ $profile->user->email }}');
            @endif


            @if($profile->emails->count() > 0)
                @php
                    $emailAlt = $profile->emails->where('value', '!=', $profile->user->email)->first();
                @endphp

                @if(isset($emailAlt))
                    $('#email-alternate').val('{{ $emailAlt->value }}');
                @endif
            @endif
            


            // Mobile / Contact
                @if($profile->numContacts->count() > 0)
                    @foreach($profile->numContacts as $contact)
                        @if($contact->type == 'primary')
                            $('#mobile').val('{{ $contact->number }}');
                        @elseif($contact->type == 'alternate')
                            $('#mobile-alternate').val('{{ $contact->number }}');
                        @elseif($contact->type == 'landline')
                            $('#telephone').val('{{ $contact->number }}');
                        @endif
                    @endforeach
                @endif
            // END Mobile / Contact

            // Mobile Type
                @if($profile->numContactTypes->count() > 0)
                    @foreach($profile->numContactTypes as $cType)
                        @if($cType->type === 'primary')
                            @if($cType->value === 'Viber')
                                $('#m_viber').prop('checked', true);
                            @elseif($cType->value === 'Whatsapp')
                                $('#m_whatsapp').prop('checked', true);
                            @endif
                        @elseif($cType->type === 'other')
                            $('#m_others').prop('checked', true);
                            @if(isset($cType->value))
                                $('#m_text').show();
                                $('#m_text').val('{{ $cType->value }}');
                            @endif
                        @endif
                    @endforeach
                @endif

                if (!$('#m_others').is(':checked'))
                {
                    $('#m_text').val('');
                    $('#m_text').hide();
                }

                $('#m_others').change(function() {
                    // Toggle input visibility when checkbox state changes
                    toggleInputVisibility();
                });

                function toggleInputVisibility() {
                    // Check if the checkbox is checked
                    if ($('#m_others').is(':checked')) {
                        // If checked, show the input and clear its content
                        $('#m_text').show();
                        $('#m_text').val('');
                        $('#m_text').focus();
                        
                    } else {
                        // If unchecked, hide the input and clear its content
                        $('#m_text').val('');
                        $('#m_text').hide();
                        
                    }
                }
            // END Mobile Type


            // Address
                // Preset Options loaded directly
                @if(isset($profile->addressLatest))
                    $("#country").val('{{ $profile->addressLatest->country }}').trigger("change.select2");
                @else
                    $("#country").val('');
                @endif




            // END Address


            // PRIVACY
                @if($profile->hide_email === 1)
                    $('#hEmail').prop('checked', true);
                @else
                    $('#hEmail').prop('checked', false);
                @endif

                @if($profile->hide_contact === 1)
                    $('#hContact').prop('checked', true);
                @else
                    $('#hContact').prop('checked', false);
                @endif

                @if($profile->hide_address === 1)
                    $('#hAddress').prop('checked', true);
                @else
                    $('#hAddress').prop('checked', false);
                @endif
            // END PRIVACY


            // Company Name
                @if($profile->company_name !== '')
                    $('#org').val('{{ $profile->company_name }}');
                @endif
            // END Company Name

            // Jobs
                @if($profile->jobTitles->count() > 0)
                    if($('#jobsList').is(':hidden'))
                    {
                        $('#jobsList').show();
                    }
                    @foreach($profile->jobTitles as $job)
                        $('#jobsList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td>{{ $job->value }}</td></tr>');
                    @endforeach
                @endif

                if ($('#jobsList tbody tr').length > 0)
                {
                    $('#jobsList').on('click', '.removeX', function(){
                        $(this).closest("tr").remove();
                        if($('#jobsList tr').length == 1)
                        {
                            $('#jobsList').hide();
                        }
                    });
                }

                $('#jobsAdd').on('click', function(e){
                    
                    
                    var job = $('#job').val().trim();

                    if(job != "")
                    {
                        if(job.length >150)
                        {
                            $('#jobsArr-error').html('Exceeded allowed number of characters. Try again.');
                        }
                        else
                        {
                            if($('#jobsList').is(':hidden'))
                            {
                                $('#jobsList').show();
                            }

                            $('#jobsArr-error').html('');
                            $('#jobsList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td>' + job + '</td></tr>');
                            $('#job').val('');

                            $('#jobsList').on('click', '.removeX', function(){
                                $(this).closest("tr").remove();
                                if($('#jobsList tr').length == 1)
                                {
                                    $('#jobsList').hide();
                                }
                            });
                        }
                        

                        $('#job').focus();
                    }
                });
            // END Jobs

            // Socials
                @if($profile->socials->count() > 0)
                    @foreach($profile->socials as $social)
                        @if($social->type == 'Facebook')
                            $('#facebook').val('{{ $social->value }}');
                        @elseif($social->type == 'Instagram')
                            $('#instagram').val('{{ $social->value }}');
                        @elseif($social->type == 'Twitter')
                            $('#twitter').val('{{ $social->value }}');
                        @elseif($social->type == 'Youtube')
                            $('#youtube').val('{{ $social->value }}');
                        @elseif($social->type == 'Tiktok')
                            $('#tiktok').val('{{ $social->value }}');
                        @elseif($social->type == 'Behance')
                            $('#behance').val('{{ $social->value }}');
                        @endif
                    @endforeach
                @endif
            // END Socials


            // Web
            @if($profile->websites->count() > 0)
                    if($('#webList').is(':hidden'))
                    {
                        $('#webList').show();
                    }
                    @foreach($profile->websites as $web)
                        $('#webList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td><a href="{{ $web->value }}" target="_blank" rel="noopener noreferrer">{{ $web->value }}</a></td></tr>');
                    @endforeach
                @endif

                if ($('#webList tbody tr').length > 0)
                {
                    $('#webList').on('click', '.removeX', function(){
                        $(this).closest("tr").remove();
                        if($('#webList tr').length == 1)
                        {
                            $('#webList').hide();
                        }
                    });
                }

                $('#webAdd').on('click', function(e){
                    
                    
                    var web = $('#web').val().trim();

                    var urlRegex = /^(https?:\/\/)?([\w-]+\.+[\w-]+)+([\w.,@?^=%&:/~+#-]*[\w@?^=%&/~+#-])?$/;

                    if(web != "")
                    {
                        if(web.length >150)
                        {
                            $('#webArr-error').html('Exceeded allowed number of characters. Try again.');
                        }
                        else if(!(urlRegex.test(web) && (web.startsWith("http://") || web.startsWith("https://")))){
                            $('#webArr-error').html('Value must be a valid website (https://...). Try again.');
                        }
                        else
                        {
                            if($('#webList').is(':hidden'))
                            {
                                $('#webList').show();
                            }

                            $('#webArr-error').html('');
                            $('#webList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td>' + web + '</td></tr>');
                            $('#web').val('');

                            $('#webList').on('click', '.removeX', function(){
                                $(this).closest("tr").remove();
                                if($('#webList tr').length == 1)
                                {
                                    $('#webList').hide();
                                }
                            });
                        }
                        

                        $('#web').focus();
                    }
                });
            // END Web


            // Representation
                @if(isset($profile->uindie))
                    @if($profile->uindie->expertise !== '')
                        $('#rep').val('{{ $profile->uindie->expertise }}');
                    @else
                        $('#rep').val('');
                    @endif
                @endif
            // END Representation

            // Display Name
                @if($profile->display_name === 'fullname')
                    $('#nameRadioFull').prop('checked', true);
                @elseif($profile->display_name === 'company_name')
                    $('#nameRadioCompany').prop('checked', true);
                @elseif($profile->display_name === 'other_name')
                    $('#nameRadioOther').prop('checked', true);
                    $('input[name="name-other"]').val('{{ $profile->other_name }}').prop({
                        'disabled': false,
                        'hidden': false
                    });
                @endif
            // END Display Name


            // INTERESTS AND EXPERTISES
                $("#interests").select2({
                    placeholder: 'Select an option'
                });

                $("#expertises").select2({
                    placeholder: 'Select an option'
                });

                var intList = [];
                @foreach($profile->sectors as $interest)
                    intList.push('{{ $interest->category . "|745|" . $interest->value }}');
                @endforeach
                
                $('#interests').val(intList);
                $('#interests').trigger('change');

                @if($profile->uindie)
                    @if($profile->uindie->expertises->count() > 0)
                        var expList = [];
                        @foreach($profile->uindie->expertises as $expertise)
                            expList.push('{{ $expertise->category . "|745|" . $expertise->value }}');
                        @endforeach
                        
                        $('#expertises').val(expList);
                        $('#expertises').trigger('change');
                    @endif
                @endif

            // END  INTERESTS AND EXPERTISES
            

            // Client List
                @if($profile->uindie)
                    @if($profile->uindie->clients->count() > 0)
                        if($('#clientsList').is(':hidden'))
                        {
                            $('#clientsList').show();
                        }
                        @foreach($profile->uindie->clients as $client)
                            $('#clientsList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td>{{ $client->name }}</td></tr>');
                        @endforeach
                    @endif
                @endif

                if ($('#clientsList tbody tr').length > 0)
                {
                    $('#clientsList').on('click', '.removeX', function(){
                        $(this).closest("tr").remove();
                        if($('#clientsList tr').length == 1)
                        {
                            $('#clientsList').hide();
                        }
                    });
                }

                $('#clientAdd').on('click', function(e){
                    
                    
                    var client = $('#clientName').val().trim();

                    if(client != "")
                    {
                        if(client.length >150)
                        {
                            $('#clientsArr-error').html('Exceeded allowed number of characters. Try again.');
                        }
                        else
                        {
                            if($('#clientsList').is(':hidden'))
                            {
                                $('#clientsList').show();
                            }

                            $('#clientsArr-error').html('');
                            $('#clientsList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td>' + client + '</td></tr>');
                            $('#clientName').val('');

                            $('#clientsList').on('click', '.removeX', function(){
                                $(this).closest("tr").remove();
                                if($('#clientsList tr').length == 1)
                                {
                                    $('#clientsList').hide();
                                }
                            });
                        }
                        

                        $('#clientName').focus();
                    }
                });
            // END Client List


            // Awards List
            @if($profile->awards->count() > 0)
                    if($('#awardsList').is(':hidden'))
                    {
                        $('#awardsList').show();
                    }
                    @foreach($profile->awards as $award)
                        $('#awardsList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td>{{ $award->name }}</td><td>{{ $award->source }}</td><td>{{ $award->year }}</td></tr>');
                    @endforeach
                @endif

                if ($('#awardsList tbody tr').length > 0)
                {
                    $('#awardsList').on('click', '.removeX', function(){
                        $(this).closest("tr").remove();
                        if($('#awardsList tr').length == 1)
                        {
                            $('#awardsList').hide();
                        }
                    });
                }

                $('#awardAdd').on('click', function(e){

                    $('#awardsArr-error').html('');
                    
                    var name = $('#award').val().trim();
                    var source = $('#presenter').val().trim();
                    var year = $('#presentYear').val().trim();

                    
                    if(name == "" || source == "" || year == "")
                    {
                        $('#awardsArr-error').html('Please fill all Awards/Recognition Fields');
                    }
                    else if(name.length > 150 || source.length > 150 || year.length > 150)
                    {
                        $('#awardsArr-error').html('Exceeded allowed number of characters. Try again.');
                    }
                    else if(!($.isNumeric(year) && year.length === 4))
                    {
                        $('#awardsArr-error').html('Year Given must be a valid Year value.');
                    }
                    else
                    {
                        if($('#awardsList').is(':hidden'))
                        {
                            $('#awardsList').show();
                        }

                        $('#awardsArr-error').html('');
                        $('#awardsList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td>' + name + '</td><td>' + source + '</td><td>' + year + '</td></tr>');
                        $('#award').val('');
                        $('#presenter').val('');
                        $('#presentYear').val('');

                        $('#awardsList').on('click', '.removeX', function(){
                            $(this).closest("tr").remove();
                            if($('#awardsList tr').length == 1)
                            {
                                $('#awardsList').hide();
                            }
                        });

                        $('#award').focus();
                    }
                    
                });
            // END Awards List

            // Portfolio
                @if($profile->user->uploadedRequirements->where('type', 'portfolio')->count() === 0)
                    $('#portfolioList').hide();
                    $('#portfolioList-error').html('No Sample Works');
                @else
                    $('#portfolioList').show();
                    $('#portfolioList-error').html('');

                    @foreach($profile->user->uploadedRequirements->where('type', 'portfolio') as $portfolio)
                        @php 
                            $fileAddress = asset('folder_requirements/' . $profile->user->id . '/requirements/' . $portfolio->file);
                            $fileDate = \Carbon\Carbon::parse($portfolio->created_at)->format('F d, Y');
                        @endphp
                        $('#portfolioList').append('<tr><td><a href="{{ $fileAddress }}" target="_blank" rel="noopener noreferrer">{{ $portfolio->file }}</a></td><td>{{ $fileDate }}</td></tr>');
                    @endforeach
                @endif

            // END Portfolio


            // Identification upload
                @if($profile->user->uploadedRequirements->where('type', 'goverment-document')->count() === 0)
                    $('#govDocList').hide();
                    $('#govDocList-error').html('No Business Permit / Identification');
                @else
                    $('#govDocList').show();
                    $('#govDocList-error').html('');

                    @foreach($profile->user->uploadedRequirements->where('type', 'goverment-document') as $rowData)
                        @php 
                            $fileAddress = asset('folder_requirements/' . $profile->user->id . '/requirements/' . $rowData->file);
                            $fileDate = \Carbon\Carbon::parse($rowData->created_at)->format('F d, Y');
                        @endphp
                        $('#govDocList').append('<tr><td><a href="{{ $fileAddress }}" target="_blank" rel="noopener noreferrer">{{ $rowData->file }}</a></td><td>{{ $fileDate }}</td></tr>');
                    @endforeach
                @endif
            // END Identification upload


            // BIR upload
            @if($profile->user->uploadedRequirements->where('type', 'bir-document')->count() === 0)
                    $('#birList').hide();
                    $('#birList-error').html('No Certificate of Registration');
                @else
                    $('#birList').show();
                    $('#birList-error').html('');

                    @foreach($profile->user->uploadedRequirements->where('type', 'bir-document') as $rowData)
                        @php 
                            $fileAddress = asset('folder_requirements/' . $profile->user->id . '/requirements/' . $rowData->file);
                            $fileDate = \Carbon\Carbon::parse($rowData->created_at)->format('F d, Y');
                        @endphp
                        $('#birList').append('<tr><td><a href="{{ $fileAddress }}" target="_blank" rel="noopener noreferrer">{{ $rowData->file }}</a></td><td>{{ $fileDate }}</td></tr>');
                    @endforeach
                @endif
            // END BIR upload
        }


        function presets2()
        {
          
            
            // Address 2
                if($('#country').val() == 'Philippines')
                {
                    
                    
                    resetAddress('local', true);

                    
                    
                    var valueToCheck = '{{ $profile->addressLatest->region ?? '' }}';
                    getAddressDetail($('#regionM'), 'region', 'Philippines', valueToCheck);
                    // $("#regionM").val(valueToCheck).change();
                    // if (valueToCheck !== null && valueToCheck.length !== 0)
                    // {

                    //     // $("#regionM").val("'" + valueToCheck + "'");

                    //     // if($('#regionM option[value="' + valueToCheck + '"]').length > 0)
                    //     // if($('#regionM option[value="NCR"]').length > 0)
                    //     // {

                    //     //     alert(valueToCheck);
                            
                    //         $("#regionM").val(valueToCheck).trigger("change.select2");
                    //     //     // $("#regionM").val(valueToCheck).change();
                    //     //     // $('#regionM option[value="' + valueToCheck + '"]').prop('selected', true);
                    //     //     // $('#regionM option[value=' + valueToCheck + ']').attr('selected','selected');
                    //     //     $("#regionM").val('NCR').change();
                            
                    //     // }
                    // }

                    var valueToCheck2 = '{{ $profile->addressLatest->province ?? '' }}';
                    getAddressDetail($('#provinceM'), 'province', valueToCheck, valueToCheck2);
                    // if($('#regionM').val() && $('#regionM').val().length > 0)
                    // {
                    //     getAddressDetail($('#provinceM'), 'province', $('#regionM').val());
                    // }
                    // if (valueToCheck !== null && valueToCheck.length !== 0 && $('#regionM').val() && $('#regionM').val().length > 0)
                    // {
                    //     if($('#provinceM option[value="' + valueToCheck + '"]').length > 0)
                    //     {
                    //         $("#provinceM").val(valueToCheck).trigger("change.select2");
                    //     }
                    // }

                    valueToCheck = '{{ $profile->addressLatest->municipality ?? '' }}';
                    getAddressDetail($('#cityM'), 'city_town', valueToCheck2, valueToCheck);
                    // if($('#provinceM').val() && $('#provinceM').val().length > 0)
                    // {
                    //     getAddressDetail($('#cityM'), 'city_town', $('#provinceM').val());
                    // }
                    // if (valueToCheck !== null && valueToCheck.length !== 0 && $('#provinceM').val() && $('#provinceM').val().length > 0)
                    // {
                    //     if($('#cityM option[value="' + valueToCheck + '"]').length > 0)
                    //     {
                    //         $("#cityM").val(valueToCheck).trigger("change.select2");
                    //     }
                    // }
                    

                }
                else
                {
                    resetAddress('intl', true);
                    $('#regionI').val('{{ $profile->addressLatest->region ?? '' }}');
                    $('#cityI').val('{{ $profile->addressLatest->municipality ?? '' }}');
                }

                $('#addr1').val('{{ $profile->addressLatest->block_lot ?? '' }}');
                $('#addr2').val('{{ $profile->addressLatest->street ?? '' }}');
                $('#zip').val('{{ $profile->addressLatest->postal_code ?? '' }}');
            // END Address 2

        }

        
    </script>

<script src="{{ asset('js/admin/user_account.js?ver='.time()) }}"></script>
    
@endsection

@section('contentAdmin')
 
<section>


    <!-- Full-screen modal -->
    <div class="modal" id="loadingModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-white">
                <div class="modal-body text-center">
                    <i class="fas fa-spinner fa-spin fa-3x text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <h1>Account Information</h1>
    <hr>
    <div class="mt-60 mb-60" id="main-content" style="display: none;">
        <button id="btn-deny" type="button" class="btn btn-warning actBtn">Deny Request</button>
        <button id="btn-approve" type="button" class="btn btn-secondary actBtn">Approve</button>
        <button id="btn-disapprove" type="button" class="btn btn-secondary actBtn">Disapprove</button>
        <button id="btn-unverified" type="button" class="btn btn-primary actBtn">to Unverified</button>
        <button id="btn-verified" type="button" class="btn btn-primary actBtn">to Verified</button>
        <form class="mt-30" id="frm-user-account" method="POST" action="{{route('admin.edit-details.process')}}" enctype="multipart/form-data">
        @csrf
            <input type="hidden" name="uEmail" id="uEmail" value="{{ $profile->user->email }}">
            <input type="hidden" name="uID" id="uID" value="{{ $profile->user->id }}">
            <h2>Basic Information</h2>
            
            <div class="row mb-40 form-group">
                <div class="col-3">
                    <h4>Account Type</h4>
                    <span id="lbl-verified">
                        @if($profile->user->verified == -1)
                            Member
                        @elseif($profile->user->verified == 0)
                            Unverified
                        @elseif($profile->user->verified == 1)
                            Verified
                        @endif
                    </span>
                </div>
                <div class="col-3">
                    <h4>Approved</h4>
                    <span id="lbl-approved">
                        @if($profile->user->approved == 1)
                            YES
                        @else
                            NO
                        @endif
                    </span>
                </div>
            </div>
            
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="fname">First Name <span style="color: red;">*</span></label>
                    <input class="form-control form-control-lg" type="text" id="fname" name="fname" placeholder="First Name" required>
                    <div class="error-message text-danger pt-1" id="fname-error"></div>
                </div>
                <div class="col">
                    <label for="lname">Last Name <span style="color: red;">*</label>
                    <input class="form-control form-control-lg" type="text" id="lname" name="lname" placeholder="Last Name" required>
                    <div class="error-message text-danger pt-1" id="lname-error"></div>
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="email">Email Address <span style="color: red;">*</label>
                    <input class="form-control form-control-lg" type="email" id="email" name="email" placeholder="Email Address" required disabled>
                    <div class="error-message text-danger pt-1" id="email-error"></div>
                </div>
                <div class="col">
                    <label for="email-alternate">Alternate Email Address</label>
                    <input class="form-control form-control-lg" type="email" placeholder="Alternate Email Address" id="email-alternate" name="email-alternate">
                    <small class="form-text text-muted">&emsp;&emsp;optional</small>
                    <div class="error-message text-danger pt-1" id="email-alternate-error"></div>
                </div>
            </div>
            <div class="row mb-20">
                <div class="col-xs-12 col-sm-9">
                    <div class="col">
                        <label for="mobile">Mobile number <span style="color: red;">*</span></label>
                        <input type="tel" pattern="[0-9]*" id="mobile" name="mobile" class="form-control form-control-lg" placeholder="Mobile number" required>
                        <div class="error-message text-danger pt-1" id="mobile-error"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-20">
                <div class="col-xs-12 col-sm-9 pl-5">
                    <div class="col">
                        <input class="form-check-input " type="checkbox" value="viber" id="m_viber" name="m_viber">
                        <label class="form-check-label" for="m_viber">
                            Viber
                        </label>
                    </div>
                    <div class="col">
                        <input class="form-check-input" type="checkbox" value="whatsapp" id="m_whatsapp" name="m_whatsapp">
                        <label class="form-check-label" for="m_whatsapp">
                            WhatsApp
                        </label>
                    </div>
                    <div class="col">
                        <input class="form-check-input" type="checkbox" value="others" id="m_others" name="m_others">
                        <label class="form-check-label" for="m_others">
                            Others:
                        </label>
                        <br>
                        <input type="text" class="form-control form-control-lg" placeholder="Please specify" id="m_text" name="m_text">
                    </div>
                    <br>
                </div>
            </div>
            <div class="row mb-40">
                <div class="col-xs-12 col-sm-9">
                    <div class="col">
                        <label for="mobile-alternate">Alternate Mobile number</label>
                        <input type="tel" pattern="[0-9]*" id="mobile-alternate" name="mobile-alternate" class="form-control form-control-lg" placeholder="Alternate Mobile Number">
                        <small class="form-text text-muted">&emsp;&emsp;optional</small>
                        <div class="error-message text-danger pt-1" id="mobile-alternate-error"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-40">
                <div class="col-xs-12 col-sm-9">
                    <div class="col">
                        <label for="telephone">Landline number</label>
                        <input type="text" pattern="[0-9]*" id="telephone" name="telephone" class="form-control form-control-lg" placeholder="Telephone number" >
                        <small class="form-text text-muted">&emsp;&emsp;optional</small>
                        <div class="error-message text-danger pt-1" id="telephone-error"></div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <h3>
                        Address <span style="color: red;">*</span>
                    </h3>
                </div>
            </div>

            <div class="row mb-20">
                <div class="col-xs-12 col-sm-9">
                    <div class="col">
                        <label for="country">Country</label>
                        <select class="form-control form-control-lg" name="country" id="country" required>
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->name }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <div class="error-message text-danger pt-1" id="country-error"></div>
                    </div>
                </div>
            </div>

            <div id="addrLocal">
                <div class="row mb-20">
                    <div class="col-xs-12 col-sm-9">
                        <div class="row">
                            <div class="col" id="regionM-C mb-5">
                                <label for="regionM">Region</label>
                                <select class="form-control form-control-lg" name="regionM" id="regionM" disabled>
                                </select>
                                <div class="error-message text-danger pt-1" id="regionM-error"></div>
                            </div>
                            <div class="col" id="provinceM-C mb-5">
                                <label for="provinceM">Province</label>
                                <select class="form-control form-control-lg" name="provinceM" id="provinceM" disabled>
                                </select>
                                <div class="error-message text-danger pt-1" id="provinceM-error"></div>
                            </div>
                        </div>
                        
                        <div class="col" id="cityM-C">
                            <label for="cityM">City/Municipality</label>
                            <select class="form-control form-control-lg" name="cityM" id="cityM" disabled>
                            </select>
                            <div class="error-message text-danger pt-1" id="cityM-error"></div>
                        </div>
                        <!-- <div class="col" id="brgyM-C">
                            <label for="country">Barangay</label>
                            <select class="form-control form-control-lg" name="brgyM" id="brgyM" required disabled>
                            </select>
                            <div class="error-message text-danger pt-1" id="brgyM-error"></div>
                        </div> -->
                    </div>
                </div>
            </div>

            <div id="addrIntl">
                <div class="row mb-20">
                    <div class="col-xs-12 col-sm-9">
                        <div class="col">
                            <label for="regionI">State/Province/Region</label>
                            <input class="form-control form-control-lg" type="text" id="regionI" name="regionI"  placeholder="State/Province/Region">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-9">
                        <div class="col">
                            <label for="cityI">City</label>
                            <input class="form-control form-control-lg" type="text" id="cityI" name="cityI"  placeholder="City">
                        </div>
                    </div>
                </div>
            </div>
            



            <div class="row mb-20">
                <div class="col-xs-12 col-sm-9">
                    <div class="col">
                        <label for="">Address Line 1</label>
                        <input class="form-control form-control-lg" type="text" id="addr1" name="addr1"  placeholder="Address Line 1">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-9">
                    <div class="col">
                        <label for="">Address Line 2</label>
                        <input class="form-control form-control-lg" type="text" id="addr2" name="addr2"  placeholder="Address Line 2">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="col">
                        <label for="">Zipcode</label>
                        <input class="form-control form-control-lg" type="text" id="zip" name="zip" placeholder="Zipcode">
                    </div>
                </div>
            </div>
            
            <hr>
            <div class="row">
                <div class="col">
                    <h3>
                        Privacy
                    </h3>
                </div>
            </div>
            <div class="row mb-40">
                <div class="col-xs-12 col-sm-9 pl-4">
                    <div class="col">
                        <input class="form-check-input " type="checkbox" value="viber" id="hEmail" name="hEmail">
                        <label class="form-check-label" for="hEmail">
                            Hide E-mail
                        </label>
                    </div>
                    <div class="col">
                        <input class="form-check-input" type="checkbox" value="whatsapp" id="hContact" name="hContact">
                        <label class="form-check-label" for="hContact">
                            Hide Contact Numbers
                        </label>
                    </div>
                    <div class="col">
                        <input class="form-check-input" type="checkbox" value="others" id="hAddress" name="hAddress">
                        <label class="form-check-label" for="hAddress">
                            Hide Address
                        </label>
                    </div>
                    <br>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <h3>
                        Representation Details
                    </h3>
                </div>
            </div>
            <div class="row mt-30 mb-40">
                <div class="col-xs-12 col-sm-9">
                    <label for="">Name of Company / Academe / Association / Group / Agency</label>
                    <input type="text" id="org" name="org" class="form-control form-control-lg" placeholder="Name of Company / Academe / Association / Group / Agency">
                    <div class="error-message text-danger pt-1" id="org-error"></div>
                </div>
            </div>
            <div class="row mb-40">
                <div class="col-xs-12 col-sm-9">
                    <label for="">Job Title/Designation <span style="color: red;">*</span></label>
                    <input type="text" id="job" name="job" class="form-control form-control-lg mb-1" placeholder="">
                    <button type="button" id="jobsAdd" class="btn btn-secondary">Add Job Title/Designation</button>
                    <br><br>
                    <table id="jobsList" class="table table-hover" style="display: none;">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Job Title/Designation</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <input type="hidden" name="jobsArr" id="jobsArr" name="jobsArr">
                    <div class="error-message text-danger pt-1" id="jobsArr-error"></div>
                </div>
            </div>
            <div class="row mb-40">
                <div class="col-xs-12 col-sm-9">
                    <label for="rep">Representation / Category <span style="color: red;">*</span></label>
                    <select id="rep" name="rep" class="form-control form-control-lg" required>
                        <option value="">Select Representation / Category</option>
                        <option value="Individual / Independent / Freelance / Student">Individual / Independent / Freelance / Student</option>
                        <option value="Creative Organization / Association / Group">Creative Organization / Association / Group</option>
                        <option value="Academe / Learning Institution">Academe / Learning Institution</option>
                        <option value="Business / Company">Business / Company</option>
                        <option value="Government Agency">Government Agency</option>
                        <option value="Others">Others</option>
                    </select>
                    <div class="error-message text-danger pt-1" id="rep-error"></div>
                    
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col">
                    <h3>
                        Social Media Accounts and Website
                    </h3>
                </div>
            </div>

            <div class="row mb-40">
                <div class="col-xs-12 col-sm-9 col-md-6">
                    <label for="facebook">Facebook</label>
                    <input type="text" id="facebook" name="facebook" class="form-control form-control-lg mb-1" placeholder="">
                    <div class="error-message text-danger pt-1" id="facebook-error"></div>
                </div>
                <div class="col-xs-12 col-sm-9 col-md-6">
                    <label for="instagram">Instagram</label>
                    <input type="text" id="instagram" name="instagram" class="form-control form-control-lg mb-1" placeholder="">
                    <div class="error-message text-danger pt-1" id="instagram-error"></div>
                </div>
            </div>

            <div class="row mb-40">
                <div class="col-xs-12 col-sm-9 col-md-6">
                    <label for="twitter">Twitter</label>
                    <input type="text" id="twitter" name="twitter" class="form-control form-control-lg mb-1" placeholder="">
                    <div class="error-message text-danger pt-1" id="twitter-error"></div>
                </div>
                <div class="col-xs-12 col-sm-9 col-md-6">
                    <label for="youtube">Youtube</label>
                    <input type="text" id="youtube" name="youtube" class="form-control form-control-lg mb-1" placeholder="">
                    <div class="error-message text-danger pt-1" id="youtube-error"></div>
                </div>
            </div>

            <div class="row mb-40">
                <div class="col-xs-12 col-sm-9 col-md-6">
                    <label for="tiktok">Tiktok</label>
                    <input type="text" id="tiktok" name="tiktok" class="form-control form-control-lg mb-1" placeholder="">
                    <div class="error-message text-danger pt-1" id="tiktok-error"></div>
                </div>
                <div class="col-xs-12 col-sm-9 col-md-6">
                    <label for="behance">Behance</label>
                    <input type="text" id="behance" name="behance" class="form-control form-control-lg mb-1" placeholder="">
                    <div class="error-message text-danger pt-1" id="behance-error"></div>
                </div>
            </div>


            <div class="row mb-40">
                <div class="col-xs-12 col-sm-9">
                    <label for="">Website</label>
                    <input type="url" id="web" name="web" class="form-control form-control-lg mb-1" placeholder="">
                    <button type="button" id="webAdd" class="btn btn-secondary">Add Website</button>
                    <br><br>
                    <table id="webList" class="table table-hover" style="display: none;">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Websites</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <input type="hidden" name="webArr" id="webArr">
                    <div class="error-message text-danger pt-1" id="webArr-error"></div>
                </div>
            </div>







            <hr>
            <div class="row mb-40">
                <div class="col-xs-12 col-sm-9">
                    <div class="col">
                        <h3>
                            Display Name <span style="color: red;">*</span>
                        </h3>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="fullname" name="dispName" id="nameRadioFull">
                            <label class="form-check-label" for="nameRadioFull">
                                Full Name
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="company_name" name="dispName" id="nameRadioCompany">
                            <label class="form-check-label" for="nameRadioCompany">
                                Name of Company / Academe / Association / Group / Agency
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="other_name" name="dispName" id="nameRadioOther">
                            <label class="form-check-label" for="nameRadioOther">
                                Others:
                            </label>
                            <br>
                            <input type="text" class="form-control form-control-lg" placeholder="Please specify" id="name-other" name="name-other" disabled hidden>
                            <div class="error-message text-danger pt-1" id="name-other-error"></div>
                        </div>
                        <div class="error-message text-danger pt-1" id="dispName-error"></div>
                    </div>
                </div>
            </div>
            <hr>
            <h2>Sectors of Interest <span style="color: red;">*</span></h2>
            <div class="row mb-40">
                <div class="col-xs-12 col-sm-9">
                    <select name="interests[]" id="interests" class="form-control form-control-lg" multiple="multiple" style="width: 100%;" required>
                        @foreach($sectors->groupBy('category') as $category => $items)
                            <optgroup label="{{ strtoupper($category) }}">
                                @foreach($items as $item)
                                    <option value="{{ $category }}|745|{{ $item->value }}">{{ $item->value }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <div class="error-message text-danger pt-1" id="interests-error"></div>
                </div>
            </div>
            <h2>Area of Expertise <span style="color: red;">*</span></h2>
            <div class="row mb-40">
                <div class="col-xs-12 col-sm-9">
                    <select name="expertises[]" id="expertises" class="form-control form-control-lg" multiple="multiple" style="width: 100%;" required>
                        @foreach($sectors->groupBy('category') as $category => $items)
                            <optgroup label="{{ strtoupper($category) }}">
                                @foreach($items as $item)
                                    <option value="{{ $category }}|745|{{ $item->value }}">{{ $item->value }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <div class="error-message text-danger pt-1" id="expertises-error"></div>
                </div>
            </div>
            

            <hr>
            <h2>List of Clients <span class="text-muted">(optional)</span></h2>
            <div class="row mb-40">
                <div class="col-xs-12 col-sm-9">
                    <label for="clientName">Enter Client Name:</label>
                    <input type="text" id="clientName" name="clientName" class="form-control form-control-lg mb-1" maxlength="150">
                    <button type="button" id="clientAdd" class="btn btn-secondary">Add Client</button>
                    <br><br>
                    <table id="clientsList" class="table table-hover" style="display: none;">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Client Names</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <input type="hidden" name="clientsArr" id="clientsArr" name="clientsArr">
                    <div class="error-message text-danger pt-1" id="clientsArr-error"></div>
                </div>
            </div>

            <hr>
            <h2>Awards and Recognitions <span class="text-muted">(optional)</span></h2>
            <div class="row mb-40">
                <div class="col-xs-12 col-sm-9">
                    <label for="award">Name of Award or Recognition:</label>
                    <input type="text" id="award" name="award" class="form-control form-control-lg mb-3" />
                    <label for="presenter">Presented or Given By:</label>
                    <input type="text" maxlength="50" id="presenter" name="presenter" class="form-control form-control-lg mb-3"  />
                    <label for="presentYear">Year Given:</label>
                    <input type="number" min="1000" max="9999" pattern="\d{4}" id="presentYear" name="presentYear" class="form-control form-control-lg mb-1"   />
                    <button type="button" id="awardAdd" class="btn btn-secondary">Add Award / Recognition</button>
                    <br><br>
                    <table id="awardsList" class="table table-hover" style="display: none;">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Award</th>
                                <th>Presented By</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <input type="hidden" name="awardsArr" id="awardsArr">
                    <div class="error-message text-danger pt-1" id="awardsArr-error"></div>

                </div>
            </div>


            <hr>
            <h2>Document Requirements</h2>
            <div class="row mb-40 vWork-1">
                <div class="col">
                    <div class="row mt-2 mb-4">
                        <div>
                            <h3>Sample Works</h3>
                            <table id="portfolioList" class="table table-hover" style="display: none;">
                                <thead>
                                    <tr>
                                        <th>Filename</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div class="error-message text-danger pt-1" id="portfolioList-error"></div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div>
                            <h3>Business Permit / Identification</h3>
                            <table id="govDocList" class="table table-hover" style="display: none;">
                                <thead>
                                    <tr>
                                        <th>Filename</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div class="error-message text-danger pt-1" id="govDocList-error"></div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div>
                            <h3>Certification of Registration</h3>
                            <table id="birList" class="table table-hover" style="display: none;">
                                <thead>
                                    <tr>
                                        <th>Filename</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div class="error-message text-danger pt-1" id="birList-error"></div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div>
                            <h3>Drive Link</h3>
                            @if($profile->upload_drive_link && $profile->upload_drive_link != '')
                                <a href="{{ $profile->upload_drive_link }}" target="_blank" rel="noopener noreferrer">{{ $profile->upload_drive_link }}</a>
                            @else
                                <div class="text-danger pt-1">No link</div>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>



            <div class="row mb-40 form-group">
                <div class="col">
                    <button type="submit" class="btn btn-primary btn-lg">Update</button>
                    <!-- <a class="btn btn-disabled" href="{{ url('dashboard/account') }}">CANCEL</a> -->
                </div>
            </div> 
        </form>
    </div>
</section>

@if(session('success'))
    <script>
        alert('{{ session('success') }}');
    </script>
@endif


@endsection