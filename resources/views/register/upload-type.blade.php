@extends('layouts.app')



@section('content')

<div class="bg_black25 registration-fields">
    <div class="container-fluid login-container">
        <div class="row">
            @include('components.half_pane_works')
            <div class="col-xs-12 col-lg-6">
                <section>
                        <div class="row mb-30">
                            <h3>
                                ACCOUNT TYPE
                            </h3>
                        </div>
                        <div class="row mb-30">
                            <div class="col">
                                <a href="{{ route('user.register.upload-alt', ['type' => 'basic']) }}" class="btn btn-secondary btn-lg hover-highlight">
                                    <h3>Basic Account</h3>
                                    <p>Creatives with a Basic Account will enjoy increased visibility by having their own dedicated Directory Page. This page will act as a personalized portfolio where they can showcase their works to a wider audience. The Directory Page will offer various customization options, allowing creatives to personalize their page and make it truly representative of their style and brand. CREATEPhilippines Members can also follow and message you through your Directory Page</p>
                                </a>
                            </div>
                        </div>

                        <div class="row mb-30">
                            <div class="col">
                                <a href="{{ route('user.register.upload-alt', ['type' => 'verified']) }}" class="btn btn-secondary btn-lg hover-highlight">
                                    <h3>Verified Account</h3>
                                    <p>On top of the dedicated Directory Page where Creatives can upload and showcase their works and have access to their Inbox, Creatives with Verified Accounts can unlock exclusive features such as access to their page's engagements.</p>
                                    <p>Verified Creatives are provided with an exciting opportunity to be featured in CREATEPhilippines' campaigns and content! This exposure opens doors to reaching a wider audience, including potential clients, partners, and collaborators.</p>
                                </a>
                            </div>
                        </div>
                </section>
            </div>
        </div>
        
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalRegisterLast" tabindex="-1" role="dialog" aria-labelledby="modalRegisterLastLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalRegisterLastLabel">
            Congratulations!
          </h5>
        </div>
        <div class="modal-body">
            <p>
                You are now officially a Member of the CREATEPhilippines community.
            </p>
            <p>
                You may now start exploring the website and start connecting with Creatives.
            </p>
            <div id="dvCountDown" style="display: none">  
                You will be redirected to the home page after <span id="lblCount"></span>&nbsp;seconds.  
            </div>  
        </div>
      </div>
    </div>
</div>

@endsection