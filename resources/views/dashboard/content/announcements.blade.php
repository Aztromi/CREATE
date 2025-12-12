@extends('dashboard.index')

@section('userDashboard')
 
<section>
    <h1>CITEM Announcements</h1>
    <hr>
    <div class="mt-60 mb-60">
        <div class="container newsfeed-content-holder">
            <div class="row">
                <div class="col-xs-12 mt-60 mb-60">
                    <div class="announcement-item">
                        <div class="status unread row">
                            <div class="col-xs-12 col-sm-10 header">
                                <p>MONTH XX, XXXX</p>
                                <h2>Announcement title</h2>
                            </div>
                            <div class="col-xs-12 col-sm-2">
                                <i class="fas fa-envelope"></i>
                                {{-- <i class="fas fa-envelope-open"></i> --}}
                            </div>
                        </div>
                        <div class="col-xs-12 content">
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste deserunt sed fugiat in error praesentium obcaecati reprehenderit omnis consequuntur iure. Obcaecati ut, natus quisquam fugit accusamus a mollitia iure neque.
                            </p>
                        </div>
                    </div>
                    <div class="announcement-item">
                        <div class="status read row">
                            <div class="col-xs-12 col-sm-10 header">
                                <p>MONTH XX, XXXX</p>
                                <h2>Announcement title</h2>
                            </div>
                            <div class="col-xs-12 col-sm-2">
                                {{-- <i class="fas fa-envelope"></i> --}}
                                <i class="fas fa-envelope-open"></i>
                            </div>
                        </div>
                        <div class="col-xs-12 content">
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste deserunt sed fugiat in error praesentium obcaecati reprehenderit omnis consequuntur iure. Obcaecati ut, natus quisquam fugit accusamus a mollitia iure neque.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection