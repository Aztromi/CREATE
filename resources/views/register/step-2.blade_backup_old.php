@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

    <style>
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
        
    </style>
@endsection

@section('scripts-top')

@endsection



@section('content')

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


     
<div class="bg_black25 registration-fields" id="main-content" style="display: none;">
    <div class="container-fluid login-container">
        <div class="row">
            @include('components.half_pane_works')
            
            <div class="col-xs-12 col-lg-6">
                <section>
                    <h1>
                        Setup your account...
                    </h1>
                    <hr>
                    <form id="step2-frm" class="mt-60" method="POST" action="{{ route('user.register.step-two.validate') }}">
                    @csrf
                        <div class="row mb-30">
                            <h3>
                                Basic Information
                            </h3>
                            <div class="col">
                                <label for="fname">First name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="fname" id="fname" placeholder="First name" required>
                                    <div class="error-message text-danger pt-1" id="fname-error"></div>
                            </div>
                            <div class="col">
                            <label for="lname">Last name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="lname" id="lname" placeholder="Last name" required>
                                <div class="error-message text-danger pt-1" id="lname-error"></div>
                            </div>
                        </div>
                        <div class="row mb-30">
                            <div class="col">
                            <label for="email-alternate">Alternate E-mail Address</label>
                                <input type="email" class="form-control" aria-describedby="altEmailOption" name="email-alternate" id="email-alternate" placeholder="Alternate Email address" >
                                <small id="altEmailOption" class="form-text text-muted">optional</small>
                                <div class="error-message text-danger pt-1" id="email-alternate-error"></div>
                            </div>
                        </div>

                        <div class="row mb-30">
                            <div class="col">
                                <label for="mobile">Mobile No. <span style="color: red;">*</span></label>
                                <input type="tel" pattern="[0-9]*" class="form-control" name="mobile" id="mobile" placeholder="Mobile number" required>
                                <div class="error-message text-danger pt-1" id="mobile-error"></div>

                            </div>
                        </div>

                        <div class="row mb-30">
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
                                <div class="error-message text-danger pt-1" id="m_text-error"></div>
                            </div>
                            <br>
                        </div>
                        <!-- <div class="row mb-30">
                            <div class="col">
                                <a href="#" class="show-input-altMob btn" id="mobile-toggle-btn">
                                    <i class="fa fa-plus-square"></i> Add another mobile number
                                </a>
                            </div>
                        </div> -->
                        <div class="row mb-30 alt-mobile">
                            <div class="col">
                                <label for="mobile-alternate">Alternate Mobile no.</label>
                                <input type="tel" pattern="[0-9]*" class="form-control" aria-describedby="altMobileOption" placeholder="Alternate mobile number" name="mobile-alternate" id="mobile-alternate">
                                <small id="altMobileOption" class="form-text text-muted">optional</small>
                                <div class="error-message text-danger pt-1" id="mobile-alternate-error"></div>
                            </div>
                        </div>
                        <div class="row mb-30">
                            <div class="col">
                                <label for="telephone">Landline no.</label>
                                <input type="tel" pattern="[0-9]*" class="form-control" aria-describedby="landlineOption" placeholder="Landline number" name="telephone" id="telephone">
                                <small id="landlineOption" class="form-text text-muted">optional</small>
                                <div class="error-message text-danger pt-1" id="telephone-error"></div>
                            </div>
                        </div>

                        <div class="row mb-30">
                            <div class="col">
                                <label for="country">Country <span style="color: red;">*</span></label>
                                <select class="form-control select2" name="country" id="country" required>
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->name }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <div class="error-message text-danger pt-1" id="country-error"></div>
                                <!-- <p class="error-message"></p> -->
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-30 mb-30">
                            <div class="col-xs-12 col-sm-9">
                                <label for="company">Company / Academe / Association / Group / Agency</label>
                                <input type="text" class="form-control" name="company" id="company" placeholder="Name of Company / Academe / Association / Group / Agency">
                                <div class="error-message text-danger pt-1" id="company-error"></div>
                            </div>
                        </div>

                        <div class="row mb-30">
                            <div class="col-xs-12 col-sm-9">
                                <label for="job">Job Title/Designation</label>
                                <input type="text" class="form-control" placeholder="Job Title/Designation" name="job" id="job">
                                
                            </div>
                        </div>

                        <div class="row mb-30">
                            <div class="col">
                                <label for="rep">Representation / Category <span style="color: red;">*</span></label>
                                <select class="form-control" name="rep" id="rep" required>
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
                        <div class="row mb-30">
                            <div class="col">
                                <h3>
                                    Display Name <span style="color: red;">*</span>
                                </h3>
                                <p class="error-message" id="error-dispName"></p>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="nameRadioFull" name="dispName" value="fullname">
                                    <label for="nameRadio1" class="custom-control-label">Fullname</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="nameRadioCompany" name="dispName" value="company_name">
                                    <label for="nameRadio2" class="custom-control-label">Name of Company / Academe / Association / Group / Agency</label>
                                </div><div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="nameRadioOther" name="dispName" value="other_name">
                                    <label for="nameRadio3" class="custom-control-label">Others:</label>
                                    <input type="text" class="form-control" placeholder="Please specify" name="name-other" id="name-other" disabled hidden>
                                    <div class="error-message text-danger pt-1" id="name-other-error"></div>
                                </div>
                                <div class="error-message text-danger pt-1" id="dispName-error"></div>
                            </div>
                        </div>
                        <!-- 
                        <input type="hidden" name="recaptcha" id="recaptcha">
                         -->
                        <hr>
                        <div class="row mb-30">
                            <div class="col">
                                <button class="btn btn-primary" type="submit">SAVE & CONTINUE</button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
        
    </div>
</div>

<!-- TEMPORARY. FOR TEST -->
{{--
@if(session('success'))
    <script>
        alert('{{ session('success') }}');
    </script>
@endif
--}}


@endsection


@section('scripts-bottom')
    
    @include('components.recaptcha', ['action' => 'register/step2'])

    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>

    

    <script>

        

        function presets()
        {
            @if($user->profile->first_name != '')
                $('#fname').val('{{ $user->profile->first_name }}');
            @endif

            @if($user->profile->last_name != '')
                $('#lname').val('{{ $user->profile->last_name }}');
            @endif


            @if($user->profile->emails->count() > 0)
                @php
                    $emailAlt = $user->profile->emails->where('value', '!=', $user->email)->first();
                @endphp

                @if(isset($emailAlt))
                    $('#email-alternate').val('{{ $emailAlt->value }}');
                @endif
            @endif


            @if($user->profile->numContacts->count() > 0)
                @foreach($user->profile->numContacts as $contact)
                    @if($contact->type == 'primary')
                        $('#mobile').val('{{ $contact->number }}');
                    @elseif($contact->type == 'alternate')
                        $(".alt-mobile").removeAttr("style");
                        $('#mobile-alternate').val('{{ $contact->number }}');
                    @elseif($contact->type == 'landline')
                        $('#telephone').val('{{ $contact->number }}');
                    @endif
                @endforeach
            @endif

            // Mobile Type
                @if($user->profile->numContactTypes->count() > 0)
                    @foreach($user->profile->numContactTypes as $cType)
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


            // Country
                // Preset Options loaded directly
                @if(isset($user->profile->addressLatest))
                    $("#country").val('{{ $user->profile->addressLatest->country }}').trigger("change.select2");
                @else
                    $("#country").val('');
                @endif
            // END Country

            // Company Name
                @if($user->profile->company_name !== '')
                    $('#company').val('{{ $user->profile->company_name }}');
                @endif
            // END Company Name

            // Country
                // Preset Options loaded directly
                @if(isset($user->profile->jobTitleFirst))
                    $("#job").val('{{ $user->profile->jobTitleFirst->value }}');
                @else
                    $("#job").val('');
                @endif
            // END Country


            // REPRESENTATION
                @if(isset($user->profile->uindie))
                    @if($user->profile->uindie->expertise !== '')
                        $('#rep').val('{{ $user->profile->uindie->expertise }}');
                    @else
                        $('#rep').val('');
                    @endif
                @endif
            // END REPRESENTATION


            // Display Name
                @if($user->profile->display_name === 'fullname')
                    $('#nameRadioFull').prop('checked', true);
                @elseif($user->profile->display_name === 'company_name')
                    $('#nameRadioCompany').prop('checked', true);
                @elseif($user->profile->display_name === 'other_name')
                    $('#nameRadioOther').prop('checked', true);
                    $('input[name="name-other"]').val('{{ $user->profile->other_name }}').prop({
                        'disabled': false,
                        'hidden': false
                    });
                @endif
            // END Display Name

            

        }



    </script>


    <script src="{{ asset('js/registration/registration_step02.js?ver='.time()) }}"></script>

   
@endsection