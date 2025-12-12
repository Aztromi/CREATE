@extends('layouts.app')

@section('content')

<section class="bg_black25">
    <div class="container">
        <div class="row text-center">
            <div class="col-xs-1 col-sm-8 center-block">
                <h1 class="text-center">Calendar of Events</h1>
                <p class="text-center">
                    Join us in these creative events celebrating art and culture where you can immerse yourself, amaze your senses, and take you on a journey of discovery.
                </p>
            </div>
        </div>
        <div class="row mt-60">
            <div class="col-xs-12 col-sm-4">
                <select name="" id="" class="custom-select">
                    <option value="">Filter by category</option>
                    <option value="">category 1</option>
                    <option value="">category 2</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4">
                <select name="" id="" class="custom-select">
                    <option value="">Filter by year</option>
                    <option value="">2023</option>
                    <option value="">2022</option>
                </select>
            </div>
            <div class="col-xs-12 col-sm-4">
                <select name="" id="" class="custom-select">
                    <option value="">Filter by month</option>
                    <option value="">january</option>
                    <option value="">february</option>
                </select>
            </div>
        </div>
        <div class="row mt-60">
            <div class="calendar-container">
                <div class="calendar-item">
                    <div class="icon_holder conference_icon">
                        <span></span>
                    </div>
                    <div>
                        <img src="https://pop.inquirer.net/files/2023/02/Graphika-1.jpg" class="img-fluid" alt="Event title">
                    </div>
                    <div>
                        <p>MONTH XX, XXXX</p>
                        <h2>Event title</h2>
                        <p>Location | <a href="">External Link <span class="fas fa-external-link-square-alt"></span></a></p>
                    </div>
                    <div>
                        <p>Check out this event celebrating creativity and the arts, where you can immerse yourself in a diverse range of festive and colorful celebrations that will inspire and delight.</p>
                        <a href="">Learn more <span class="fas fa-external-link-square-alt"></span></a>
                    </div>
                </div>
                <div class="calendar-item">
                    <div class="icon_holder game_icon">
                        <span></span>
                    </div>
                    <div>
                        <img src="https://classicgamefest.com/wp-content/uploads/2020/03/87473755_1510224229127396_8307146197110358016_o.jpg" class="img-fluid" alt="Event title">
                    </div>
                    <div>
                        <p>MONTH XX, XXXX</p>
                        <h2>Event title</h2>
                        <p>Location | <a href="">External Link <span class="fas fa-external-link-square-alt"></span></a></p>
                    </div>
                    <div>
                        <p>Check out this event celebrating creativity and the arts, where you can immerse yourself in a diverse range of festive and colorful celebrations that will inspire and delight.</p>
                        <a href="">Learn more <span class="fas fa-external-link-square-alt"></span></a>
                    </div>
                </div>
                <div class="calendar-item">
                    <div class="icon_holder headphones_icon">
                        <span></span>
                    </div>
                    <div>
                        <img src="https://thumbs.dreamstime.com/z/music-festival-poster-party-music-festival-poster-night-party-225948042.jpg" class="img-fluid" alt="Event title">
                    </div>
                    <div>
                        <p>MONTH XX, XXXX</p>
                        <h2>Event title</h2>
                        <p>Location | <a href="">External Link <span class="fas fa-external-link-square-alt"></span></a></p>
                    </div>
                    <div>
                        <p>Check out this event celebrating creativity and the arts, where you can immerse yourself in a diverse range of festive and colorful celebrations that will inspire and delight.</p>
                        <a href="">Learn more <span class="fas fa-external-link-square-alt"></span></a>
                    </div>
                </div>
                <div class="calendar-item">
                    <div class="icon_holder paintbrush_icon">
                        <span></span>
                    </div>
                    <div>
                        <img src="https://d1csarkz8obe9u.cloudfront.net/posterpreviews/art-festival-poster-vintage-design-1a564f69dc46c3e6f7943364a43637da_screen.jpg?ts=1636964423" class="img-fluid" alt="Event title">
                    </div>
                    <div>
                        <p>MONTH XX, XXXX</p>
                        <h2>Event title</h2>
                        <p>Location | <a href="">External Link <span class="fas fa-external-link-square-alt"></span></a></p>
                    </div>
                    <div>
                        <p>Check out this event celebrating creativity and the arts, where you can immerse yourself in a diverse range of festive and colorful celebrations that will inspire and delight.</p>
                        <a href="">Learn more <span class="fas fa-external-link-square-alt"></span></a>
                    </div>
                </div>
                <div class="calendar-item">
                    <div class="icon_holder camera_icon">
                        <span></span>
                    </div>
                    <div>
                        <img src="https://mir-s3-cdn-cf.behance.net/project_modules/max_1200/c20375112544201.6016c119a4f37.png" class="img-fluid" alt="Event title">
                    </div>
                    <div>
                        <p>MONTH XX, XXXX</p>
                        <h2>Event title</h2>
                        <p>Location | <a href="">External Link <span class="fas fa-external-link-square-alt"></span></a></p>
                    </div>
                    <div>
                        <p>Check out this event celebrating creativity and the arts, where you can immerse yourself in a diverse range of festive and colorful celebrations that will inspire and delight.</p>
                        <a href="">Learn more <span class="fas fa-external-link-square-alt"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection