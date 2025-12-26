<style>
    .blur-div {
        min-height: 600px;
        display: flex;
        align-items: center;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transition: background 0.3s ease-in-out;
    }

    .blur-div::before {
        content: "";
        position: absolute;
        inset: 0;
        animation: pulse 2s infinite;
    }

    .blur-div.blur-div.loaded::before {
        content: none;
    }

    @keyframes pulse {
        0% {
            background-color: rgb(255, 255, 255, 0);
        }

        50% {
            background-color: rgb(255, 255, 255, 0.1);
        }

        100% {
            background-color: rgb(255, 255, 255, 0);
        }
    }

    .blur-div.loaded>img {
        opacity: 1;
    }

    .blur-div>img {
        opacity: 0;
        transition: opacity 200ms ease-in-out;
    }

    .animahenasyon {
        background-image: url('/img/carousel/thumbnails/animahenasyon_banner_carousel.png');
    }

    .create-lab {
        background-image: url('/img/carousel/thumbnails/carousel_createLabxFAME.png');
    }

    .creative-directory {
        background-image: url('/img/carousel/thumbnails/carousel_creativeDirectory.png');
    }

    .creative-connect {
        background-image: url('/img/carousel/thumbnails/carousel_creativeConnect.png');
    }

    .creative-events {
        background-image: url('/img/carousel/thumbnails/carousel_creativeEvents.png');
    }

    @media (max-width: 991.98px) {
        .blur-div {
            min-height: 520px;
            /* taller for portrait images */
        }

        .create-lab {
            background-image: url('/img/carousel/thumbnails/carousel_createLabxFAME_portrait.png');
        }

        .creative-directory {
            background-image: url('/img/carousel/thumbnails/carousel_creativeDirectory_portrait.png');
        }

        .creative-connect {
            background-image: url('/img/carousel/thumbnails/carousel_creativeConnect_portrait.png');
        }

        .creative-events {
            background-image: url('/img/carousel/thumbnails/carousel_creativeEvents_portrait.png');
        }
    }

    .create-lab {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 450px;
    }
</style>
<section class="container-fluid bg_black p-0">
    <div id="carouselHome" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#carouselHome" data-bs-slide-to="4" aria-label="Slide 5"></button>
        </div>
        <div class="carousel-inner">

            <div class="carousel-item active">
                <a href="/events/create-lab" target="_blank">
                    <div class="blur-div animahenasyon">
                        <img src="/img/carousel/animahenasyon_banner_carousel.png" class="w-100 d-block" alt="" loading="lazy">
                    </div>
                </a>
            </div>

            <div class="carousel-item">
                <a href="/events/create-lab" target="_blank">
                    <div class="blur-div create-lab">
                        <picture class="d-block w-100">
                            <source
                                srcset="/img/carousel/carousel_createLabxFAME.jpg"
                                media="(min-width: 992px)">

                            <img
                                src="/img/carousel/carousel_createLabxFAME_portrait.png"
                                class="d-block w-100 object-fit-cover"
                                alt=""
                                loading="lazy">
                        </picture>
                    </div>
                </a>
            </div>

            <div class="carousel-item">
                <a href="/directory" target="_blank">
                    <div class="blur-div creative-directory">
                        <picture class="d-block w-100">
                            <source
                                srcset="/img/carousel/carousel_creativeDirectory.jpg"
                                media="(min-width: 992px)">

                            <img
                                src="/img/carousel/carousel_creativeDirectory_portrait.jpg"
                                class="d-block w-100 object-fit-cover"
                                alt=""
                                loading="lazy">
                        </picture>
                    </div>
                </a>
            </div>

            <div class="carousel-item">
                <a href="/connect-with-creatives" target="_blank">
                    <div class="blur-div creative-connect">
                        <picture class="d-block w-100">
                            <source
                                srcset="/img/carousel/carousel_creativeConnect.jpg"
                                media="(min-width: 992px)">

                            <img
                                src="/img/carousel/carousel_creativeConnect_portrait.jpg"
                                class="d-block w-100 object-fit-cover"
                                alt=""
                                loading="lazy">
                        </picture>
                    </div>
                </a>
            </div>
            <div class="carousel-item">
                <a href="/events/creative-events" target="_blank">
                    <div class="blur-div creative-events">
                        <picture class="d-block w-100">
                            <source
                                srcset="/img/carousel/carousel_creativeEvents.jpg"
                                media="(min-width: 992px)">

                            <img
                                src="/img/carousel/carousel_creativeEvents_portrait.jpg"
                                class="d-block w-100 object-fit-cover"
                                alt=""
                                loading="lazy">
                        </picture>
                    </div>
                </a>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselHome" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselHome" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>
<script>
    // const carousel = document.querySelector('#carouselHome');
    // carousel.addEventListener('slid.bs.carousel', () => {
    //     const activeSlide = carousel.querySelector('carousel-item.active');
    //     const blurDivs = activeSlide.querySelectorAll('.blur-div');
    //     const img = blurDivs.querySelector("img");
    //     blurDivs.classList.add('loaded');
    //     carousel.querySelectorAll('.carousel-item').forEach(item => {
    //         if (img.complete) {
    //             img.parentElement.classList.add('loaded');
    //         } else {
    //             img.addEventListener('load', () => img.parentElement.classList.add('loaded'));
    //         }
    //     })
    // });
const carousel = document.querySelector('#carouselHome');
    // carousel.addEventListener('slid.bs.carousel', () => {
    const blurDivs = carousel.querySelectorAll('.blur-div');
    blurDivs.forEach(div => {
        const img = div.querySelector("img");

        function loaded() {
            div.classList.add("loaded");
        }
        if (img.complete) {
            loaded();
        } else {
            img.addEventListener("load", loaded);
        }
    })
</script>