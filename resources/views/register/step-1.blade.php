@extends('layouts.app')

@section('styles')
<style>
    #terms-close-btn {
        position: absolute;
        top: 15px;
        right: 20px;
        color: #333;
        font-size: 30px;
        font-weight: bold;
        cursor: pointer;
        z-index: 999;
    }

    .btn-show {
        background-color: transparent;
        border: 0;
        color: #FFFFFF;

    }
</style>
    
@endsection

@section('content')

<!-- <script src="/js/jquery.min.js"></script> -->
@section('reg_step01')
<script src="{{ asset('js/registration/registration_step01.js?ver='.time()) }}"></script>

<script>
    $(document).ready(function(){

        $('.terms').on('click', function(e){
            e.preventDefault();
            $('#modal-terms').modal('show');
        });

        $('#terms-close-btn').on('click', function(){
            $('#modal-terms').modal('hide');
        });

        $('.btn-show').on('click', function(e){
            e.preventDefault();
            const type = $('#password').attr('type') === "password" ? "text" : "password";
            $('.pswd').attr('type', type);
            $('.btn-show').text(type === "password" ? "Show Password" : "Hide Password");
            

        });
    });
    
    
</script>
@endsection

<div class="bg_black25 registration-fields">
    <div class="container-fluid login-container">
        <div class="row">
            @include('components.half_pane_works')
            <div class="col-xs-12 col-lg-6">
                <section>
                    <h1>
                        CREATE Your Account Now!
                    </h1>
                    <hr>
                    <form id="registration-form-01" method="POST" action="{{ route('register.submit') }}" class="mt-60">
                    {{-- <form id="registration-form-01" method="POST" class="mt-60"> --}}
                    @csrf 
                        <div class="row mb-30">
                            <div class="col">
                                <input type="text" name="firstname" class="form-control" placeholder="First name">
                                <p class="error-message"></p>
                            </div>
                            <div class="col">
                                <input type="text" name="lastname" class="form-control" placeholder="Last name">
                                <p class="error-message"></p>
                            </div>
                        </div>
                        <div class="row mb-30">
                            <div class="col">
                                <input type="email" name="email" class="form-control" placeholder="Email address">
                                <p class="error-message"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-end">
                                <a href=""><button class="btn-show">Show Password</button></a>
                            </div>
                        </div>
                        <div class="row mb-30">
                            <div class="col">
                                <input type="password" name="password" id="password" class="form-control pswd" placeholder="Password">
                                <p class="error-message"></p>
                            </div>
                            <div class="col">
                                <input type="password" name="re_password" class="form-control  pswd" placeholder="Confirm password">
                            </div>
                        </div>
                        
                        <div class="row mb-30">
                            <div class="col">
                                <input class="form-check-input" name="termsCheck" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  I agree to the <a href="#" class="text-white terms">terms and conditions</a>.
                                </label>
                                <p class="error-message"></p>
                            </div>
                        </div>

                        <div class="row mb-30" id="passwordConditions" style="display: none;">
                            <div><i id="lengthIcon" class="fas fa-check" style="color: green;"></i>&nbsp;<span>Minimum 8 characters</span></div>
                            <div><i id="uppercaseIcon" class="fas fa-check" style="color: green;"></i>&nbsp;<span>One uppercase letter</span></div>
                            <div><i id="lowercaseIcon" class="fas fa-check" style="color: green;"></i>&nbsp;<span>One lowercase letter</span></div>
                            <div><i id="numberIcon" class="fas fa-check" style="color: green;"></i>&nbsp;<span>One number</span></div>
                            <div><i id="specialCharIcon" class="fas fa-check" style="color: green;"></i>&nbsp;<span>One special character</span></div>
                        </div>

                        <div class="row mb-30">
                            <div class="col">
                                <button class="btn btn-primary" type="submit">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
        
    </div>
</div>




<div class="modal fade" id="modalRegistration">
    <div class="modal-dialog">
        <div class="modal-content bg-light text-black" style="margin-top: 10px;">
        <div class="modal-header">
            <h4 class="modal-title">CREATEPhilippines Registration.</h4>
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
            <!-- <span aria-hidden="true">&times;</span> -->
            </button>
        </div>
        <div class="modal-body">
            <p>
                We sent a confirmation email. Click the link in the email to proceed.
            </p>
            
        </div>
        <!-- <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline-light">Save changes</button>
        </div> -->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@include('register.terms')



<style>
    .is-invalid {
        border-color: red;
    }
</style>

@endsection
