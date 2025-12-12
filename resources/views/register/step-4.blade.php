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

        #otherCategoryModal {
            position: fixed;
            /* top: 0;
            left: 0;
            width: 100%;
            height: 100%; */
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

        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            background-color: #3E3E3E;
            border: 0;
            border-radius: 8px;

        }

        .select2-container--default .select2-selection--single .select2-selection__arrow,
        .select2-container--default .select2-selection--multiple .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 11px;
            right: 1px;
            width: 30px;
        }

        /* X Button in selected */
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #7aabff;
            padding-right: 2px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #d12f2f;
        }
        /* END X Button in selected */

        .select2-results__group {
            background-color: #a7c7ff;
        }

        
        .select2-container--default .select2-search--inline .select2-search__field {
            color: #FFFFFF;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered,
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {

            background-color: #3E3E3E;
            color: #FFFFFF;
            padding: 10px 10px;
            border: 0;
            border-radius: 8px;
            font-size: 1.2em;
            font-weight: 400;
        }
        
        .select2-selection__choice{ 
            background-color: blue;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #FFFFFF;
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

<div class="modal" id="otherCategoryModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark">
            <div class="container p-5 text-white">
                <div class="row">
                    <div class="col-12 mb-3">
                        <h3>
                            Other Category
                        </h3>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="othMainCat">Expertise Category <span style="color: red;">*</span></label>
                        <select id="othMainCat" class="form-control" required>
                            <option value="">-</option>
                        </select>
                        <div class="error-message text-danger pt-1" id="othMainCat-error"></div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 mb-3">
                        <label for="othNew">Expertise <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="othNew" maxlength="100">
                        <div class="error-message text-danger pt-1" id="othNew-error"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-3 text-right">
                        <button class="btn btn-lg btn-primary" type="button" id="btnOthAdd">ADD</button>
                        <button class="btn btn-lg btn-secondary" type="button" id="btnOthCancel">Cancel</button>
                    </div>
                </div>
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
                    <form id="step4-frm" class="mt-60" method="POST" action="{{ route('user.register.step-four.validate') }}">
                    @csrf

                        <input type="hidden" name="reg_type" value="{{ $reg_type }}">
                        <input type="hidden" name="oth" id="oth">
                        <div class="row mb-5">
                            <div class="col-12 mb-3">
                                <h3>
                                    Categories  
                                </h3>
                            </div>

                            
                            <div class="col-12 mb-3">
                                <label for="expertises">Area of Expertise <span style="color: red;">*</span></label>
                                    
                                <select name="expertises[]" id="expertises" class="form-control select2" multiple="multiple" required>
                                    <option value="">-</option>
                                </select>
                                <div class="p-2">
                                    <button type="button" id="btnOthExp" class="btn btn-secondary">Other Expertise (Not in List)</button>
                                </div>
                                <div class="error-message text-danger pt-1" id="expertises-error"></div>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="expertises">Main Creative Services Offered <span style="color: red;">*</span></label>
                                <select name="main-expertise" id="main-expertise" class="form-control select2" required>
                                    <option value="">-</option>
                                </select>
                                <div class="p-2 mt-4">
                                    <button type="button" id="btnOthMainExp" class="btn btn-secondary">Other Main Services Offered (Not in List)</button>
                                </div>
                                <div class="error-message text-danger pt-1" id="main-expertise-error"></div>
                            </div>
                        </div>



                        <div class="row mb-3">
                            <div class="col text-end">
                                <a class="btn btn-lg btn-secondary" href="{{ route('user.register.step-three', ['type' => $reg_type]) }}">BACK</a>
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

        
    function presets()
    {

        $.ajax({
            url: "{{ route('user.register.step-four.data') }}",
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {

                
                if(response.uindie.expertises)
                {
                    $expList = [];
                    $main_exp = '';

                    $.each(response.uindie.expertises, function(index, expertise) {
                        
                        if(expertise.type == 'expertise')
                        {
                            $expList.push(expertise.list_state + "|745|" + expertise.category +"|745|"+ expertise.value);
                        }
                        else if(expertise.type == 'main')
                        {
                            $main_exp = expertise.list_state + "|745|" + expertise.category + "|745|" + expertise.value;
                        }

                    });

                    $('#expertises').val($expList).trigger('change'); 
                    $('#main-expertise').val($main_exp).trigger('change');
                    // setTimeout(function() {
                        
                    // }, 100);
                    
                }

            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        
        

    }



    </script>
    
    <script src="{{ asset('js/shared/categories.js?ver='.time()) }}"></script>

    <script src="{{ asset('js/registration/registration_step04.js?ver='.time()) }}"></script>

   
@endsection