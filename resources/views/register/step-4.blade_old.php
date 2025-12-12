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
                                Do you want to have a directory page on the site to showcase your creative works?
                            </h3>
                        </div>
                        
                        <div class="row mb-30">
                            <div class="col">
                                <a href="{{ route('user.register.upload-type') }}" class="btn btn-secondary btn-lg hover-highlight">Yes, I want to apply as Creative and showcase my works in CREATEPhilippines Directory.</a>
                            </div>
                        </div>
                        
                        <div class="row mb-30">
                            <div class="col">
                                <a href="{{ route('user.register.step-four.member') }}" class="btn btn-secondary btn-lg hover-highlight">No, I just want to explore the site as a CREATEPhilippines Member.</a>
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