@extends('dashboard.index')

@section('userDashboard')

<section>
    <h1>
        Message Thread
    </h1>
    <hr>
    {{-- LATEST first --}}
    <div class="mt-60 mb-60 message-holder">
        <div class="user-reply">
            <div class="row">
                <div class="col">
                    Reply to: <b>SUBJECT LINE</b>
                    <br>
                    From: <b>User Name</b>
                </div>
                <div class="col text-right">
                    {{-- time and date received --}}
                    hh:mm:ss | Month XX, XXXXX
                </div>
            </div>
            <div class="row">
                <b>MESSAGE</b>
                <div class="col">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora at vero perspiciatis nesciunt assumenda quasi consequatur nisi animi, amet consequuntur porro iste architecto quibusdam distinctio. Similique delectus est non praesentium? 
                </div>
            </div>
        </div>
        <div class="sender-message">
            <div class="row">
                <div class="col">
                    <b>
                        SUBJECT LINE
                    </b>
                    <br>
                    From: Sender Name
                </div>
                <div class="col text-right">
                    {{-- time and date received --}}
                    hh:mm:ss | Month XX, XXXXX
                    <br>
                    <div class="message-actions">
                        <a data-toggle="modal" data-target="#replyToMessage" title="Reply">
                            <i class="fa fa-reply"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <b>MESSAGE</b>
                <div class="col">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora at vero perspiciatis nesciunt assumenda quasi consequatur nisi animi, amet consequuntur porro iste architecto quibusdam distinctio. Similique delectus est non praesentium?
                </div>
            </div>
        </div>
    </div>
</section>


  
@include('dashboard.components.replyTo')


@endsection