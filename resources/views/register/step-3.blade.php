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

        .removeX {
            color: red;
            cursor: pointer;
        }

        .removeX:hover {
            cursor: pointer;
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
                    <form id="step3-frm" class="mt-60" method="POST" action="{{ route('user.register.step-three.validate') }}">
                    @csrf
                        <input type="hidden" name="reg_type" value="{{ $reg_type }}">
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <h3>
                                    Representation
                                </h3>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 mb-4">
                                <label for="rep">Representation / Category <span style="color: red;">*</span></label>
                                <select id="rep" name="rep" class="form-control select2" required>
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


                        <!-- NEWUPDATES -->

                        <div id="optCompany">
                        
                            <div class="row mb-3">
                                <div class="col-12 mb-4">
                                    <label for="org">Name of Company <span style="color: red;">*</span></label>
                                    <input type="text" id="org" name="org" class="form-control form-control-lg" placeholder="Name of Company / Academe / Association / Group / Agency">
                                    <div class="error-message text-danger pt-1" id="org-error"></div>
                                </div>
                            </div>

                            <br><br>
                            <!-- Company Address -->



                            <div class="row">
                                <div class="col mb-4 text-center">
                                    <h3 id="head_rep_address">Company Address</h3>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12 mb-4">
                                    <label for="co_country">Country <span style="color: red;">*</span></label>
                                    <select class="form-control select2" name="co_country" id="co_country">
                                        <option value="">-</option>
                                    </select>
                                    <div class="error-message text-danger pt-1" id="co_country-error"></div>
                                </div>
                            </div>

                            
                            <div class="row" id="co_addrLocal">
                                <div class="col-md-6 mb-5">
                                    <label for="co_regionM">Region <span style="color: red;">*</span></label>
                                    <select class="form-control select2" name="co_regionM" id="co_regionM" disabled>
                                        <option value="">-</option>
                                    </select>
                                    <div class="error-message text-danger pt-1" id="co_regionM-error"></div>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <label for="co_provinceM">Province <span style="color: red;">*</span></label>
                                    <select class="form-control select2" name="co_provinceM" id="co_provinceM" disabled>
                                        <option value="">-</option>
                                    </select>
                                    <div class="error-message text-danger pt-1" id="co_provinceM-error"></div>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <label for="co_cityM">City/Municipality <span style="color: red;">*</span></label>
                                    <select class="form-control select2" name="co_cityM" id="co_cityM" disabled>
                                        <option value="">-</option>
                                    </select>
                                    <div class="error-message text-danger pt-1" id="co_cityM-error"></div>
                                </div>
                            </div>
                            <div class="row" id="co_addrIntl">
                                <div class="col-md-6 mb-3">
                                    <label for="co_regionI">State/Province/Region <span style="color: red;">*</span></label>
                                    <input class="form-control form-control-lg" type="text" id="co_regionI" name="co_regionI"  placeholder="State/Province/Region">
                                    <div class="error-message text-danger pt-1" id="co_regionI-error"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="co_cityI">City <span style="color: red;">*</span></label>
                                    <input class="form-control form-control-lg" type="text" id="co_cityI" name="co_cityI"  placeholder="City">
                                    <div class="error-message text-danger pt-1" id="co_cityI-error"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-4">
                                    <label for="co_addr1">Address Line 1</label>
                                    <input class="form-control form-control-lg" type="text" id="co_addr1" name="co_addr1"  placeholder="Address Line 1">
                                </div>
                                <!-- <div class="col-12 mb-4">
                                    <label for="addr2">Address Line 2</label>
                                    <input class="form-control form-control-lg" type="text" id="addr2" name="addr2"  placeholder="Address Line 2">
                                </div> -->
                                <div class="col-md-6 mb-4">
                                    <label for="co_zip">Zipcode</label>
                                    <input class="form-control form-control-lg" type="text" id="co_zip" name="co_zip" placeholder="Zipcode">
                                </div>
                            </div>

                            <!-- END Company Address -->

                            <br><br>

                            <div class="row">
                                <div class="col mb-4 text-center">
                                    <h3 id="head_rep_details">Company Details</h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="co_size">Company Size<span style="color: red;">*</span></label>
                                    <select id="co_size" name="co_size" class="form-control select2">
                                        <option value="">Select Size</option>
                                        <option value="Micro (Less than or equal to 3M)">Micro (Less than or equal to 3M)</option>
                                        <option value="Small (More than 3M but Less than or equal to 15M)">Small (More than 3M but Less than or equal to 15M)</option>
                                        <option value="Medium (More than 15M but Less than or equal to 100M)">Medium (More than 15M but Less than or equal to 100M)</option>
                                        <option value="Large (More than 100M)">Large (More than 100M)</option>
                                        <option value="Not Applicable">Not Applicable</option>
                                    </select>
                                    <div class="error-message text-danger pt-1" id="rep-error"></div>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <label for="co_direct">No. of Direct Workers <span style="color: red;">*</span></label>
                                    <input class="form-control form-control-lg" type="number" id="co_direct" name="co_direct" placeholder="Direct Workers">
                                    <div class="error-message text-danger pt-1" id="co_direct-error"></div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="co_indirect">No. of Indirect Workers <span style="color: red;">*</span></label>
                                    <input class="form-control form-control-lg" type="number" id="co_indirect" name="co_indirect" placeholder="Indirect Workers">
                                    <div class="error-message text-danger pt-1" id="co_indirect-error"></div>
                                </div>
                            </div>



                            <br><br>

                            <div class="row">
                                <div class="col mb-4 text-center">
                                    <h3>Representative Details</h3>
                                </div>
                            </div>

                            <div class="row" id="repPersonGroup">
                                <div class="col-md-6 mb-4">
                                    <label for="rep_fname">Representative First Name <span style="color: red;">*</span></label>
                                    <input class="form-control form-control-lg" type="text" id="rep_fname" name="rep_fname" placeholder="First Name">
                                    <div class="error-message text-danger pt-1" id="rep_fname-error"></div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="rep_lname">Representative Last Name <span style="color: red;">*</span></label>
                                    <input class="form-control form-control-lg" type="text" id="rep_lname" name="rep_lname" placeholder="Last Name">
                                    <div class="error-message text-danger pt-1" id="rep_lname-error"></div>
                                </div>
                            
                                <!-- NEWADDS -->
                                <div class="col-md-6 mb-4">
                                    <label for="rep_gender">Gender <span style="color: red;">*</span></label>
                                    <select id="rep_gender" name="rep_gender" class="form-control select2">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="prefer not to say">Prefer not to say/answer</option>
                                        
                                    </select>
                                    <div class="error-message text-danger pt-1" id="rep_gender-error"></div>
                                </div>
                                <!-- END NEW ADDS -->
                            
                                <div class="col-md-6 mb-4">
                                    <label for="rep_email">Representative Email Address <span style="color: red;">*</span></label>
                                    <input class="form-control form-control-lg" type="email" id="rep_email" name="rep_email" placeholder="Email Address">
                                    <div class="error-message text-danger pt-1" id="rep_email-error"></div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="row">
                                        <div class="col">
                                            <label for="rep_mobile">Representative Mobile number <span style="color: red;">*</span></label>
                                            <input type="tel" pattern="[0-9]*" id="rep_mobile" name="rep_mobile" class="form-control form-control-lg" placeholder="Mobile number">
                                            <div class="error-message text-danger pt-1" id="rep_mobile-error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="job">Job Title/Designation <span style="color: red;">*</span></label>
                                            <input type="text" id="job" name="job" class="form-control form-control-lg mb-1" placeholder="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-right">
                                            <button type="button" id="jobsAdd" class="btn btn-secondary">Add Job Title/Designation</button>
                                        </div>
                                    </div>
                                    <div class="row mt-3 px-4">
                                        <div class="col-12">
                                            <table id="jobsList" class="table table-light table-hover" style="display: none;">
                                                <thead class="thead-light">
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
                                </div>
                            </div>

                            <br><br>
                            
                            <div class="row">
                                <div class="col mb-4 text-center">
                                    <h3>Owner Details</h3>
                                </div>
                            </div>

                            <div class="row">
                            
                                <div class="col-12 mb-4">
                                    <input class="form-check-input" type="checkbox" id="same_rep_owner" name="same_rep_owner">
                                    <label class="form-check-label" for="same_rep_owner">
                                        Same as Representative Details
                                    </label>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="owner_fname">Owner First Name <span style="color: red;">*</span></label>
                                    <input class="form-control form-control-lg" type="text" id="owner_fname" name="owner_fname" placeholder="First Name">
                                    <div class="error-message text-danger pt-1" id="owner_fname-error"></div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="owner_lname">Owner Last Name <span style="color: red;">*</span></label>
                                    <input class="form-control form-control-lg" type="text" id="owner_lname" name="owner_lname" placeholder="Last Name">
                                    <div class="error-message text-danger pt-1" id="owner_lname-error"></div>
                                </div>

                                

                                <!-- NEWADDS -->
                                <div class="col-md-6 mb-4">
                                    <label for="owner_gender">Owner Gender <span style="color: red;">*</span></label>
                                    <select id="owner_gender" name="owner_gender" class="form-control select2">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="prefer not to say">Prefer not to say/answer</option>
                                        
                                    </select>
                                    <div class="error-message text-danger pt-1" id="owner_gender-error"></div>
                                </div>
                                <!-- END NEW ADDS -->

                                <div class="col-md-6 mb-4">
                                    <label for="owner_email">Owner Email Address <span style="color: red;">*</span></label>
                                    <input class="form-control form-control-lg" type="email" id="owner_email" name="owner_email" placeholder="Email Address">
                                    <div class="error-message text-danger pt-1" id="owner_email-error"></div>
                                </div>
                                
                            </div>
                            
                        </div>

                        <!-- END NEWUPDATES -->
                        
                        <hr>

                        <div class="row">
                            <div class="col-12 mb-1">
                                <h2>Display Name <span style="color: red;" class="fs-5">*</span></h2>
                                <small><i>Name That Will Appear In Booth Signage, Event Collaterals, and Directory Page</i></small>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-12 pb-2">
                                <div class="row">
                                    <div class="col-1">
                                        <input class="form-check-input" type="radio" value="fullname" name="dispName" id="nameRadioFull">
                                    </div>
                                    <div class="col-11 pt-1">
                                        <label class="form-check-label" for="nameRadioFull">
                                            Full Name
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 pb-2" id="dispNameCompany">
                                <div class="row">
                                    <div class="col-1">
                                        <input class="form-check-input" type="radio" value="company_name" name="dispName" id="nameRadioCompany">
                                    </div>
                                    <div class="col-11 pt-2">
                                        <label class="form-check-label" for="nameRadioCompany">
                                            Name of Company / Academe / Association / Group / Agency
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 pb-2">
                                <div class="row">
                                    <div class="col-1">
                                        <input class="form-check-input" type="radio" value="other_name" name="dispName" id="nameRadioOther">
                                    </div>
                                    <div class="col-11 pt-2">
                                        <label class="form-check-label" for="nameRadioOther">
                                            Others:
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 pb-2">
                                <div class="row">
                                    <div class="col-1"></div>
                                    <div class="col-11 pt-2">
                                        <input type="text" class="form-control form-control-lg" placeholder="Please specify" id="name-other" name="name-other" disabled hidden>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 pb-2">
                                <div class="error-message text-danger pt-1" id="name-other-error"></div>
                            </div>

                            <div class="col-12 pb-2">
                                <div class="error-message text-danger pt-1" id="dispName-error"></div>
                            </div>
                        </div>
                            
                        <div class="row mb-3">
                            <div class="col text-end">
                                <a class="btn btn-lg btn-secondary" href="{{ route('user.register.step-two', ['type' => $reg_type]) }}">BACK</a>
                                <button class="btn btn-lg btn-primary" type="submit">NEXT</button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
        
    </div>
</div>



@endsection


@section('scripts-bottom')
    
    

    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>

    

    <script>

        
    async function presets()
    {
  
        $.ajax({
            url: "{{ route('user.register.step-three.data') }}",
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            xhrFields: {
                withCredentials: true
            },
            success: async function(response) {

                
                if(response.uindie)
                {
                    $('#rep').val(response.uindie.expertise).trigger('change');

                    if(response.uindie.expertise != '' && response.uindie.expertise != 'Individual / Independent / Freelance / Student')
                    {

                        $('#org').val(response.company.company_name);
                        
                        if(response.company.address_latest)
                        {
                            $('#co_country').val(response.company.address_latest.country).trigger('change');
                            await addressReset2('company', response.company.address_latest.country, $('#co_regionM'), false);

                            if(response.company.address_latest.country == 'Philippines')
                            {
                                $('#co_regionM').val(response.company.address_latest.region).trigger('change');
                                await setLocalAddressDetails2('company', 'province', response.company.address_latest.region, $('#co_provinceM'), false);
                                $('#co_provinceM').val(response.company.address_latest.province).trigger('change');
                                await setLocalAddressDetails2('company', 'city_town', response.company.address_latest.province, $('#co_cityM'), false);
                                $('#co_cityM').val(response.company.address_latest.municipality).trigger('change');
                            }
                            else
                            {
                                $('#co_regionI').val(response.company.address_latest.region);
                                $('#co_cityI').val(response.company.address_latest.municipality);
                            }
                            
                            $('#co_addr1').val(response.company.address_latest.block_lot);
                            $('#co_zip').val(response.company.address_latest.postal_code);
                        }
                        else{
                            $('#co_country').val('').trigger('change');
                        }

                        $('#co_size').val(response.company.company_size).trigger('change');
                        $('#co_direct').val(response.company.company_direct_workers);
                        $('#co_indirect').val(response.company.company_indirect_workers);

                        $('#rep_fname').val(response.company.rep_fname);
                        $('#rep_lname').val(response.company.rep_lname);
                        $('#rep_gender').val(response.company.rep_gender).trigger('change');
                        $('#rep_email').val(response.company.rep_email);
                        $('#rep_mobile').val(response.company.rep_mobile);

                        
                        // Jobs

                            if (response.job_titles && response.job_titles.length > 0)
                            {
                                if($('#jobsList').is(':hidden'))
                                {
                                    $('#jobsList').show();
                                }

                                $.each(response.job_titles, function(index, jobTitle) {
                                    // console.log("Job Title:", jobTitle.value);
                                    $('#jobsList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td>' + jobTitle.value + '</td></tr>');
                                });
                            }
                            

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
                        // END Jobs

                        if(response.company.same_rep_owner == 1)
                        {
                            $('#same_rep_owner').prop('checked', true);
                        }
                        
                        $('#owner_fname').val(response.company.owner_fname);
                        $('#owner_lname').val(response.company.owner_lname);
                        $('#owner_gender').val(response.company.owner_gender).trigger('change');
                        $('#owner_email').val(response.company.owner_email);


                    }

                }

                // Display Name
                if(response.display_name)
                {
                    switch(response.display_name)
                    {
                        case 'company_name':
                            $('input[name="dispName"]#nameRadioCompany').prop('checked', true);
                        break;
                        case 'fullname':
                            $('input[name="dispName"]#nameRadioFull').prop('checked', true);
                        break;
                        case 'other_name':
                            $('input[name="dispName"]#nameRadioOther').prop('checked', true);

                            $('#name-other').prop('hidden', false);
                            $('#name-other').prop('disabled', false);
                            $('#name-other').prop('required', true);
                            $('#name-other').val(response.other_name);
                        break;
                    }
                }
                // END Display Name

            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });


        

    }



    </script>
    
    <script src="{{ asset('js/shared/address.js?ver='.time()) }}"></script>

    <script src="{{ asset('js/registration/registration_step03.js?ver='.time()) }}"></script>

   
@endsection