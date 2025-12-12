@extends('admin.index')

@section('styles')
    <!-- for multiple select -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link href="{{ asset('plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/user/profile/account.css?ver='.time()) }}">
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
                    @if($displayType == 'exhibitor')
                        <h1>EXHIBITOR INFORMATION</h1>
                    @else
                        <h1>ACCOUNT INFORMATION</h1>
                    @endif
                </div>
            </div>
            <div class="row">
                @if($displayType == 'creative')
                    <div class="col mb-4 text-right">
                        <button id="btn-deny" type="button" class="btn btn-warning actBtn">Deny Request</button>
                        <button id="btn-approve" type="button" class="btn btn-secondary actBtn">Approve</button>
                        <button id="btn-disapprove" type="button" class="btn btn-secondary actBtn">Disapprove</button>
                        <button id="btn-unverified" type="button" class="btn btn-primary actBtn">to Unverified</button>
                        <button id="btn-verified" type="button" class="btn btn-primary actBtn">to Verified</button>
                    </div>
                @elseif($displayType == 'exhibitor')
                    <div class="col mb-4 text-right" id="btnGroupExb">
                    @if(in_array($profile->attendanceLatest->status, [2]))
                        <button id="btn-exb-approve" type="button" class="btn btn-primary actBtnExb">Approve</button>
                        <button id="btn-exb-deny" type="button" class="btn btn-warning actBtnExb">Deny</button>
                    @endif
                    </div>
                @endif
            </div>

            <!-- <form class="mt-30" id="frm-user-account" method="POST" action="{{route('admin.edit-details.process')}}" enctype="multipart/form-data"> -->
            <form id="frm-user-account" method="POST" action="{{route('shd.profile.edit-account.process')}}" enctype="multipart/form-data">
                @csrf

                @include('dashboard.content.account-form-content')

                
            </form>
        </div>
    </div>
    </div>
<section>
@endsection


@section('scripts-bottom')
    <!-- for multiple select -->
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('js/shared/address.js?ver='.time()) }}"></script>
    <script src="{{ asset('js/shared/categories.js?ver='.time()) }}"></script>
    <script src="{{ asset('js/userdash/accountFormLoad.js?ver='.time()) }}"></script>
    <script src="{{ asset('js/admin/user_account.js?ver='.time()) }}"></script>

    <script>

        function setStates()
        {
            $('#accStates').append('<div class="col-md-3 mb-4"><h4>Approved</h4><span id="lbl-approved">-</span></div>');

            @if($displayType == 'creative')

                @if($uState->approved == 1)
                    statusButtonHandler('approved', 1);
                @elseif($uState->approved == 0)
                    statusButtonHandler('approved', 0);
                @else
                    statusButtonHandler('approved', -1);
                @endif

                @if($uState->verified == -1)
                    statusButtonHandler('verified', -1);
                @elseif($uState->verified == 0)
                    statusButtonHandler('verified', 0);
                @elseif($uState->verified == 1)
                    statusButtonHandler('verified', 1);
                @else
                    statusButtonHandler('verified', 1);
                @endif

                @if($uState->requests > 0)
                    statusButtonHandler('deny', 1);
                @else
                    statusButtonHandler('deny', 0);
                @endif
                
            @endif
            
            
        }

    </script>
@endsection