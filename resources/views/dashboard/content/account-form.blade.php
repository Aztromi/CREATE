@extends('dashboard.index')

@section('styles')
<!-- for multiple select -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link href="{{ asset('plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/user/profile/account.css?ver='.time()) }}">

   


@endsection

@section('scripts-bottom')

    <!-- for multiple select -->
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('js/shared/address.js?ver='.time()) }}"></script>
    <script src="{{ asset('js/shared/categories.js?ver='.time()) }}"></script>
    <script src="{{ asset('js/userdash/accountFormLoad.js?ver='.time()) }}"></script>
    <script src="{{ asset('js/userdash/account.js?ver='.time()) }}"></script>
    
    
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


    <!-- Other Category modal -->
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

    <div class="card col-lg-12 col-xl-10 mx-auto">
    <div class="card-body">
        <div class="container" id="main-content" style="display: none;">
            <div class="row">
                <div class="col mt-4 mb-4 text-center">
                    <h1>ACCOUNT INFORMATION</h1>
                </div>
            </div>

            
            

            <form id="frm-user-account" method="POST" action="{{route('shd.profile.edit-account.process')}}" enctype="multipart/form-data">
                @csrf

                <!-- IMAGES -->
                <div class="row">
                    <div class="col-12 mb-4" id="profile-images">
                        <div class="row">
                            <div class="col-12">
                                <div id="banner">
                                    <!-- <img id="profile-image" src="{{ asset('img/default_profile_img.png') }}" alt="Profile Image"> -->
                                    <!-- <input type="file" id="masthead" name="masthead" class="dropify" data-max-file-size="5M" data-allowed-file-extensions="gif png jpg jpeg" @if(!empty($enabler->masthead)) data-default-file="/assets/images/export/companies/masthead/{{$enabler->masthead}}" @endif data-height="200" data-errors-position="outside"/> -->
                                    <input type="file" id="masthead" name="masthead" class="dropify" data-max-file-size="5M" data-allowed-file-extensions="png jpg jpeg" data-height="200" @if(!empty($p_images->cover_photo)) data-default-file="{{ asset('folder_user-uploads/'.$uID.'/Profile/'.$p_images->cover_photo) }}" @endif data-errors-position="outside"/>
                                    <input type="hidden" id="masthead-change" name="masthead-change">
                                </div>
                                <div id="profile-image">
                                    <input type="file" id="profile-photo" name="profile-photo" class="dropify" data-max-file-size="5M" data-allowed-file-extensions="png jpg jpeg" data-height="200" @if(!empty($p_images->display_photo)) data-default-file="{{ asset('folder_user-uploads/'.$uID.'/Profile/'.$p_images->display_photo) }}" @endif data-errors-position="outside"/>
                                    <input type="hidden" id="profile-photo-change" name="profile-photo-change">

                                </div>
                            </div>
                            <!-- <div class="col-12 text-right pt-2">
                                <button type="button" class="btn btn-secondary btn-upd" id="profilePhoto_btn">Upload Profile Photo</button>
                                <button type="button" class="btn btn-secondary  btn-upd" id="banner_btn">Upload Banner Image</button>
                                
                                <input type="file" id="profilePhoto" name="profilePhoto" accept=".png, .jpg" hidden>
                                <input type="file" id="bannerUpd" name="bannerUpd" accept=".png, .jpg" hidden>
                            </div> -->
                            <div class="col-6"></div>
                            <div class="col-12 text-right">
                                <div class="error-message text-danger pt-1" id="masthead-error"></div>
                            </div>
                            <div class="col-12 text-right">
                                <div class="error-message text-danger pt-1" id="profile-photo-error"></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <br><br>

                @include('dashboard.content.account-form-content')
            </form>
        </div>
    </div>
    </div>
</section>



@endsection