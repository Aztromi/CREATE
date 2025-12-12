@extends('layouts.app')


@section('content')

<div class="bg_black25 registration-fields">
    <div class="container-fluid login-container">
        <div class="row">
            @include('components.half_pane_works')
            <div class="col-xs-12 col-lg-6">
                <section>

                        <form id="frm-uploadLink" method="POST" action="{{ route('user.register.upload-link-process') }}">
                        @csrf
                            <div class="row mb-30">
                                <h3>
                                    Share a Drive Link
                                </h3>
                            </div>
                            <div class="row mb-30">
                                <div class="col">
                                    
                                </div>
                            </div>

                            <div class="row mb-30">
                                <div class="col">
                                    <label class="form-label" for="drive-link">Drive Link: </label>
                                    <input class="form-control" type="url" placeholder="Drive Link" id="drive-link" name="drive-link" required>
                                </div>
                            </div>
                            <div class="row mb-30">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-lg hover-highlight">Submit</button>
                                    <a href="{{ route('user.register.upload-type') }}" class="btn btn-secondary btn-lg hover-highlight">Back</a>
                                </div>
                            </div>

                        </form>


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