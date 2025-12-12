@extends('dashboard.index')

@section('styles')
<!-- for multiple select -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/user/profile/account.css?ver='.time()) }}">


@endsection

@section('scripts-bottom')

    <!-- for multiple select -->
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/address.js?ver='.time()) }}"></script>
    <script src="{{ asset('js/userdash/account.js?ver='.time()) }}"></script>
    <script src="{{ asset('js/userdash/accountFormLoad.js?ver='.time()) }}"></script>
    
@endsection

@section('userDashboard')
 


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

    <div class="card col-lg-12 col-xl-10 mx-auto">
    <div class="card-body">
        <div class="container" id="main-content" style="display: none;">
            <div class="row">
                <div class="col mt-4 mb-4 text-center">
                    <h1>ACCOUNT INFORMATION</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-12">
                            <div id="banner">
                                <!-- <h1>Your Banner Title</h1>
                                <p>Your banner content goes here.</p> -->
                                <img id="profile-image" src="{{ asset('img/default_profile_img.png') }}" alt="Profile Image">
                            </div>
                        </div>
                        <div class="col-12 text-right pt-2">
                            <button type="button" class="btn btn-secondary btn-upd" id="profilePhoto_btn">Upload Profile Photo</button>
                            <button type="button" class="btn btn-secondary  btn-upd" id="banner_btn">Upload Banner Image</button>
                            
                            <input type="file" id="profilePhoto" name="profilePhoto" accept=".png, .jpg" hidden>
                            <input type="file" id="bannerUpd" name="bannerUpd" accept=".png, .jpg" hidden>
                        </div>
                        <div class="col-6"></div>
                        <div class="col-6 text-right">
                            <div class="error-message text-danger pt-1" id="photoUpload-error"></div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
            

            <form id="frm-user-account" method="POST" action="{{route('user.edit-account.process')}}">
                @csrf

                @include('dashboard.content.account-form-content')
            </form>
        </div>
    </div>
    </div>
<section>

{{--
@if(session('success'))
    <script>
        alert('{{ session('success') }}');
    </script>
@endif
--}}


@endsection