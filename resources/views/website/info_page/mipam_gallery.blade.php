@extends('layouts.app')

{{-- PAGE STYLEd --}}
@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<style>
    body, html { 
        background-color: #130F23!important;
        color: #ffffff!important;
        overflow-x:hidden!important;
        position: relative
    }
    section { padding: 60px 0!important }
    .text-color-white { color:#ffffff!important }
    .text-color-red { color:#D92757!important }
    .text-color-yellow { color:#F9C52E!important }
    .text-color-orange { color:#F37158!important }
    .text-color-green { color:#3CBB8D!important }
    .text-color-purple { color:#C44F9E!important }
    .text-color-blue { color:#4084C5!important }
    .text-color-grey { color:#a3a3a3!important }

    .ff-raleway-header {
        font-family: "Raleway", sans-serif;
        font-optical-sizing: auto;
        font-weight: 500; 
        font-size: 70px;
        font-style: normal;
        position: relative;
        z-index: 1; 
    }
    .ff-raleway-body {
        font-family: "Raleway", sans-serif;
        font-optical-sizing: auto; 
        font-weight: 300; 
        font-style: normal;
        z-index: 1; 
    }

    .cxm-bannerlogo { height: 250px }
    .event-year {
        text-align: center;
        font-weight: 700; 
        font-size: 100px;
        line-height: 100px;
        letter-spacing: 70px;
        text-indent: 70px;
        color: #F9C52E;
        margin-bottom: 50px
    }
    .subheader {
        font-size: 30px;
        font-weight: 400;
        margin-bottom: 50px;
        position: relative;
        z-index: 1;
        line-height: 35px;
    }
    .cta-register, .cta-register-2, .cta-view, .cta-view-2  { text-decoration: none; z-index: 1; position: relative }
    .cta-register > div, .cta-view > div {
        margin: 0 20px;
        border-radius: 30px;
        font-size: 20px;
        padding: 15px 30px;
        font-weight: 500;
        min-width: 350px;
        display: inline-block
    }
    .cta-register-2 > div, .cta-view-2 > div {
        border-radius: 30px;
        font-size: 20px;
        padding: 10px 25px; 
        font-weight: 500;
        display: inline-block;
        margin: 0 20px;
        min-width: 255px;
        text-align: center;
    }
    .cta-register > div, .cta-register-2 > div {
        background-color: #ffffff!important;
        color: #000000!important;
    }
    .cta-view > div {
        background-color: #C44F9E!important;
        color: #ffffff!important;
    }
    .cta-view-2 > div {
        background-color: #4084C5!important;
        color: #ffffff!important;
    }
    .rs-container {
        margin: 0 auto;
        width: 25vw;
        text-align: center;
    }
    @media only screen and (max-width: 576px) {
        .cxm-bannerlogo { width: 80%; height: auto; }
        .event-year {
            font-size: 80px;
            letter-spacing: 30px;
            text-indent: 30px;
            margin-bottom: 40px;
        }
        .rs-container { margin: 0 auto; width: 90vw; }
        .ff-raleway-header { font-size: 40px; margin-bottom: 20px!important }
        .cta-register > div, .cta-register-2  > div, .cta-view  > div, .cta-view-2  > div {
            display: block;
            width: 100%;
            margin: 0 0 20px;
        }
    }
    @media only screen and (min-width: 769px) and (max-width: 991px) {
        .cxm-bannerlogo { 
            width: 40%; 
            height: auto; 
            margin-top: 40px
        }
        .event-year {
            font-size: 80px;
            letter-spacing: 30px;
            text-indent: 30px;
            margin-bottom: 40px;
        }
        .rs-container { width: 70vw }
        .ff-raleway-header { font-size: 40px; margin-bottom: 20px!important }
        .cta-register > div, .cta-register-2  > div, .cta-view  > div, .cta-view-2  > div { width: 40%; margin: 0 20px 20px; }
    }
    @media only screen and (min-width: 992px) and (max-width: 1199px) {
        .cxm-bannerlogo { 
            width: 40%; 
            height: auto; 
            margin-top: 40px
        }
        .event-year {
            font-size: 80px;
            letter-spacing: 30px;
            text-indent: 30px;
            margin-bottom: 40px;
        }
        .rs-container { width: 70vw }
        .ff-raleway-header { font-size: 40px; margin-bottom: 20px!important }
        .cta-register > div, .cta-register-2  > div, .cta-view  > div, .cta-view-2  > div { width: 40%; margin: 0 20px 20px; }
    }
</style>
@endsection

{{-- PAGE SCRIPT --}} 
@section('scripts-bottom')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // JSON data included directly in the script section
        const photos1 = @json($photos);
        const photos2 = @json($photos2);
        let photos = photos1;
        let currentIndex = 0;
        let photoGroup = 0;

        const modalImage = document.getElementById('modalImage');
        const downloadButton = document.getElementById('downloadButton');
        const photoModal = new bootstrap.Modal(document.getElementById('photoModal'));

        document.querySelectorAll('.thumbnail').forEach(thumbnail => {
            thumbnail.addEventListener('click', function () {
                currentIndex = parseInt(this.getAttribute('data-index'));
                photoGroup = parseInt(this.getAttribute('data-group'));

                console.log(photoGroup);

                if(photoGroup == 1) {
                    photos = photos1;
                }
                else if(photoGroup == 2) {
                    photos = photos2;
                }

                updateModalImage();
            });
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowLeft') {
                currentIndex = (currentIndex > 0) ? currentIndex - 1 : photos.length - 1;
                updateModalImage();
            } else if (e.key === 'ArrowRight') {
                currentIndex = (currentIndex < photos.length - 1) ? currentIndex + 1 : 0;
                updateModalImage();
            }
        });

        downloadButton.addEventListener('click', function (e) {
            e.preventDefault();
            const link = document.createElement('a');
            link.href = downloadButton.href;
            link.download = downloadButton.download;
            link.target = '_blank';  // Open in a new tab
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        function updateModalImage() {
            
            const currentPhoto = photos[currentIndex];

            if(photoGroup == 1) {
                photoUrl = `{{ asset('img/static/x_mipam/photowall/') }}/${currentPhoto}`;
            }
            else if(photoGroup == 2) {
                photoUrl = `{{ asset('img/static/x_mipam2025/carousel_img/') }}/${currentPhoto}`;
            }
            
            modalImage.src = photoUrl;
            downloadButton.href = photoUrl;
            downloadButton.download = currentPhoto;
            photoModal.show();
        }

        // Event listener to ensure modal overlay is removed
        document.getElementById('photoModal').addEventListener('hidden.bs.modal', function () {
            const modalBackdrop = document.querySelector('.modal-backdrop');
            if (modalBackdrop) {
                modalBackdrop.remove();
            }
        });

        // Swipe detection
        document.getElementById('photoModal').addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].screenX;
        });

        document.getElementById('photoModal').addEventListener('touchend', function (e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipeGesture();
        });

        function handleSwipeGesture() {
            if (touchEndX < touchStartX) {
                currentIndex = (currentIndex < photos.length - 1) ? currentIndex + 1 : 0;
                updateModalImage();
            }
            if (touchEndX > touchStartX) {
                currentIndex = (currentIndex > 0) ? currentIndex - 1 : photos.length - 1;
                updateModalImage();
            }
        }
    });
</script>
@endsection


{{-- PAGE CONTENT --}}
@section('content') 
    
<section>
    <div class="container-fluid">
        <!-- <img src="{{ asset('img/static/x_mipam/cphxmipam_.webp') }}" alt="CREATEPhilippines x MIPAM logo" class="mx-auto cxm-bannerlogo"> -->
        <div class="row">
            <div class="col-12">
                <img class="w-100" src="{{ asset('img/static/2025_mipamxsonic/banner.png') }}" alt="CREATEPhilippines x Sonik Banner">
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row text-center mb-5">
            <h2 class="text-color-yellow">PHASE II Leg 1 2025</h2>
            <p>January 30-31, 2025 | PASAY: Intensive Learning Session</p>
        </div>
        <div class="row text-center">
            @foreach ($photos2 as $index => $photo)
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <img src="{{ asset('img/static/x_mipam2025/carousel_img/' . $photo) }}" class="img-thumbnail thumbnail" data-index="{{ $index }}" data-group=2 data-bs-toggle="modal" data-bs-target="#photoModal">
            </div>
            @endforeach
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row text-center mb-5">
            <h2 class="text-color-yellow">KICKOFF Ceremony</h2>
            <p>July 11, 2024 | The Little Theater - UP Manila</p>
        </div>
        <div class="row text-center">
            @foreach ($photos as $index => $photo)
            <div class="col-sm-6 col-md-4 col-xl-3 mb-4">
                <img src="{{ asset('img/static/x_mipam/photowall/' . $photo) }}" class="img-thumbnail thumbnail" data-index="{{ $index }}" data-group=1 data-bs-toggle="modal" data-bs-target="#photoModal">
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <span class="text-color-grey">
                    <em>Swipe left and right or use arrow keys to navigate through the images.</em>
                </span>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a id="downloadButton" href="#" download class="btn btn-primary" target="_blank">Download</a>
            </div>
        </div>
    </div>
</div>

@endsection