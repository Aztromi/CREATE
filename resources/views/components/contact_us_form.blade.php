<!--Section: Contact v.2-->
@section('user-message-scripts')
<script src="{{ asset('js/website/userMessage.js?ver='.time()) }}"></script>
@endsection

<section class="contactPartner">

    <div class="container">

        <div class="col-xs-12 col-sm-11 center-block">
            <div class="row">
                <div class="col-xs-12 col-sm-7">
                    <h2>
                        Interested in joining CREATEPhilippines?
                    </h2>
                    <p>
                        Feel free to contact us directly if you have any questions. Our team will get back to you within hours to provide assistance.
                    </p>
                    <hr>
                    <ul class="horizontal-list">
                        <li>
                            <i class="fa fa-map-marker-alt"></i> Pasay City
                        </li>
                        <li>
                            <i class="fa fa-phone"></i> +63 02 8831 2201
                        </li>
                        <li>
                            <i class="fa fa-at"></i> <a href="mailto:createph@citem.com.ph">createph@citem.com.ph</a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <form id="frm-msg" method="POST" action="{{ route('send-message') }}">
                        <div class="row mb-30">
                            <div class="col">
                                <input type="text" class="form-control" id="fname" name="fname" placeholder="First name">
                                <p class="error-message bg-transparent"></p>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name">
                                <p class="error-message bg-transparent"></p>
                            </div>
                        </div>
                        <div class="row mb-30">
                            <div class="col">
                                <input type="email" class="form-control" id="em" name="em" placeholder="Email address">
                                <p class="error-message bg-transparent"></p>
                            </div>
                        </div>
                        <div class="row mb-30">
                            <div class="col">
                                <textarea class="form-control exclude-tinymce" name="tMessage" id="tMessage" rows="3" placeholder="Message..."></textarea>
                                <p class="error-message bg-transparent"></p>
                            </div>
                        </div>
                        <div class="row mb-30">
                            <div class="col">
                                <button class="btn btn-primary" type="submit">SEND</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</section>
<!--Section: Contact v.2-->

<div class="modal fade" id="modal-mail-sent">
    <div class="modal-dialog">
        <div class="modal-content bg-info text-white" style="margin-top: 10px;">
        <div class="modal-header">
            <h4 class="modal-title">Contact Us</h4>
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
            <!-- <span aria-hidden="true">&times;</span> -->
            </button>
        </div>
        <div class="modal-body">
            <p>Message successfully sent.</p>
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
<!--Section: Contact v.2-->