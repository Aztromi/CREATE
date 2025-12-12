@extends('layouts.app')


@section('content')

<div class="bg_black25 registration-fields">
    <div class="container-fluid login-container">
        <div class="row">
        @include('components.half_pane_works')
            <div class="col-xs-12 col-lg-6">
                <section>
                        <!-- <div class="row mb-30">
                            <h3>
                                Do you want to have a directory page on the site to showcase your creative works?
                            </h3>
                        </div> -->
                    
                        @if(config('app.physical_evt_reg_status') == 1)
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="{{ route('user.register.step-two', ['type' => 'exhibitor']) }}" class="btn btn-secondary btn-lg w-100 p-3 hover-highlight">Apply as an Exhibitor in <strong>CREATEPhilippines 2024: Manila International Performing Arts Market</strong>  with a Physical Booth.<br><br><small>(Php 4,000.00 participation fee)</small></a>
                            </div>
                            <div class="col-12">
                            </div>
                        </div>
                        @endif
                        
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="{{ route('user.register.step-two', ['type' => 'creative']) }}" class="btn btn-secondary btn-lg w-100 p-3 hover-highlight">I want to apply solely as a Creative and display my works in the CREATEPhilippines Directory.</a>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-12">
                                <a href="{{ route('user.register.step-two', ['type' => 'member']) }}" class="btn btn-secondary w-100 p-3 btn-lg hover-highlight">I just want to explore the site as a CREATEPhilippines Member.</a>
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