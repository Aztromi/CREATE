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

        .select2 {
            /* width: 'resolve'; */
            width: 100% !important;
            
        }

        .select2-container--default .select2-selection--single {
            background-color: #3E3E3E;
            border: 0;
            border-radius: 8px;

        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 11px;
            right: 1px;
            width: 30px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {

            background-color: #3E3E3E;
            color: #FFFFFF;
            padding: 10px 10px;
            border: 0;
            border-radius: 8px;
            font-size: 1.2em;
            font-weight: 400;
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
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <h3>
                                    Basic Information
                                </h3>
                            </div>
                            <div class="col-12 mb-3">
                                <input type="hidden" name="reg_type" value="{{ $reg_type }}">
                                <label for="fname">First name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="fname" id="fname" placeholder="First name" required>
                                    <div class="error-message text-danger pt-1" id="fname-error"></div>
                            </div>
                            <div class="col-12 mb-3">
                            <label for="lname">Last name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="lname" id="lname" placeholder="Last name" required>
                                <div class="error-message text-danger pt-1" id="lname-error"></div>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="gender">Gender <span style="color: red;">*</span></label>
                                <select class="form-select select2" name="gender" id="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="prefer not to say">Prefer not to say/answer</option>
                                    
                                </select>
                                <div class="error-message text-danger pt-1" id="gender-error"></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                            <label for="email-alternate">Alternate E-mail Address</label>
                                <input type="email" class="form-control" aria-describedby="altEmailOption" name="email-alternate" id="email-alternate" placeholder="Alternate Email address" >
                                <small id="altEmailOption" class="form-text text-muted">optional</small>
                                <div class="error-message text-danger pt-1" id="email-alternate-error"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="mobile">Mobile No. <span style="color: red;">*</span></label>
                                <input type="tel" pattern="[0-9]*" class="form-control" name="mobile" id="mobile" placeholder="Mobile number" required>
                                <div class="error-message text-danger pt-1" id="mobile-error"></div>

                            </div>
                        </div>

                        <div class="row mb-3">
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
                        <!-- <div class="row mb-3">
                            <div class="col">
                                <a href="#" class="show-input-altMob btn" id="mobile-toggle-btn">
                                    <i class="fa fa-plus-square"></i> Add another mobile number
                                </a>
                            </div>
                        </div> -->
                        <div class="row mb-3 alt-mobile">
                            <div class="col">
                                <label for="mobile-alternate">Alternate Mobile no.</label>
                                <input type="tel" pattern="[0-9]*" class="form-control" aria-describedby="altMobileOption" placeholder="Alternate mobile number" name="mobile-alternate" id="mobile-alternate">
                                <small id="altMobileOption" class="form-text text-muted">optional</small>
                                <div class="error-message text-danger pt-1" id="mobile-alternate-error"></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="telephone">Landline no.</label>
                                <input type="tel" pattern="[0-9]*" class="form-control" aria-describedby="landlineOption" placeholder="Landline number" name="telephone" id="telephone">
                                <small id="landlineOption" class="form-text text-muted">optional</small>
                                <div class="error-message text-danger pt-1" id="telephone-error"></div>
                            </div>
                        </div>
                        
                        <hr>

                        <div class="col-12 mb-3">
                                <h3>
                                    Address
                                </h3>
                            </div>

                        <div class="row mb-3">
                            <div class="col-12 mb-4">
                                <label for="country">Country <span style="color: red;">*</span></label>
                                <select class="form-control select2" name="country" id="country" required>
                                    <option value="">-</option>
                                </select>
                                <div class="error-message text-danger pt-1" id="country-error"></div>
                                <!-- <p class="error-message"></p> -->
                            </div>
                        </div>
                        
                        <div class="row" id="addrLocal">
                            <div class="col-md-6 mb-4">
                                <label for="regionM">Region <span style="color: red;">*</span></label>
                                <select class="form-control select2" name="regionM" id="regionM" disabled>
                                    <option value="">-</option>
                                </select>
                                <div class="error-message text-danger pt-1" id="regionM-error"></div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="provinceM">Province <span style="color: red;">*</span></label>
                                <select class="form-control select2" name="provinceM" id="provinceM" disabled>
                                    <option value="">-</option>
                                </select>
                                <div class="error-message text-danger pt-1" id="provinceM-error"></div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="cityM">City/Municipality <span style="color: red;">*</span></label>
                                <select class="form-control select2" name="cityM" id="cityM" disabled>
                                    <option value="">-</option>
                                </select>
                                <div class="error-message text-danger pt-1" id="cityM-error"></div>
                            </div>
                        </div>
                        <div class="row" id="addrIntl">
                            <div class="col-md-6 mb-4">
                                <label for="regionI">State/Province/Region <span style="color: red;">*</span></label>
                                <input class="form-control form-control-lg" type="text" id="regionI" name="regionI"  placeholder="State/Province/Region">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="cityI">City <span style="color: red;">*</span></label>
                                <input class="form-control form-control-lg" type="text" id="cityI" name="cityI"  placeholder="City">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-4">
                                <label for="addr1">Address Line 1</label>
                                <input class="form-control form-control-lg" type="text" id="addr1" name="addr1"  placeholder="Address Line 1">
                            </div>
                            <!-- <div class="col-12 mb-4">
                                <label for="addr2">Address Line 2</label>
                                <input class="form-control form-control-lg" type="text" id="addr2" name="addr2"  placeholder="Address Line 2">
                            </div> -->
                            <div class="col-md-6 mb-4">
                                <label for="zip">Zipcode</label>
                                <input class="form-control form-control-lg" type="text" id="zip" name="zip" placeholder="Zipcode">
                            </div>
                        </div>



                        <div class="row mb-3">
                            <div class="col text-end">
                                <a class="btn btn-lg btn-secondary" href="{{ route('user.register.step-two') }}">BACK</a>
                                <button class="btn btn-lg btn-primary" type="submit">NEXT</button>
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
    {{--
    @include('components.recaptcha', ['action' => 'register/step2'])
    --}}

    
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>

    

    <script>

        

        async function presets()
        {
            @if($user->profile->first_name != '')
                $('#fname').val('{{ $user->profile->first_name }}');
            @endif

            @if($user->profile->last_name != '')
                $('#lname').val('{{ $user->profile->last_name }}');
            @endif

            @if($user->profile->gender != '')
                // $("#gender").val('{{ $user->profile->gender }}').trigger("change");
                setTimeout(function() {
                    $("#gender").val('{{ $user->profile->gender }}').trigger("change.select2");
                }, 1000);
                
                
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
                @if(isset($user->profile->addressLatest) && $user->profile->addressLatest->country != '')
                        $('#country').val('{{ $user->profile->addressLatest->country }}').trigger("change");
                        await addressReset2('main', '{{ $user->profile->addressLatest->country }}', $('#regionM'), false);
                    @if($user->profile->addressLatest->country == 'Philippines')
                            $('#regionM').val('{{ $user->profile->addressLatest->region }}').trigger('change');
                            await setLocalAddressDetails2('main', 'province', '{{ $user->profile->addressLatest->region }}', $('#provinceM'), false);
                            $('#provinceM').val('{{ $user->profile->addressLatest->province }}').trigger('change');
                            await setLocalAddressDetails2('main', 'city_town', '{{ $user->profile->addressLatest->province }}', $('#cityM'), false);
                            $('#cityM').val('{{ $user->profile->addressLatest->municipality }}').trigger('change');
                    @else
                        $('#regionI').val('{{ $user->profile->addressLatest->region }}');
                        $('#cityI').val('{{ $user->profile->addressLatest->municipality }}');
                    @endif

                        $('#addr1').val('{{ $user->profile->addressLatest->block_lot }}');
                        $('#zip').val('{{ $user->profile->addressLatest->postal_code }}');
                @else
                    $('#country').val('').trigger("change");
                @endif
            // END Country

            

        }



    </script>

    <script src="{{ asset('js/shared/address.js?ver='.time()) }}"></script>
    <script src="{{ asset('js/registration/registration_step02.js?ver='.time()) }}"></script>
    
   
@endsection