    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{ asset('fontawesome/js/all.min.js') }}"></script>
    <script src="{{ asset('js/slick.js') }}"></script>

    <script type="text/javascript">
        // Run specific scripts per page
        current = window.location.pathname;

        if (current == '/') {
            // Subscribe modal
            @if(Session::has('homeSubsribe'))
                @if(Session::get('homeSubsribe') === 'visible')
                    $(window).on('load', function() {
                        $('#subscribe-modal').modal('show');
                    });
                @endif
            @endif
        }
        else if (current == '/business-solutions-services/about') {
            console.log('BSS Featured Partner Carousel Script');
            // Instantiate the Bootstrap carousel
            $('.multi-item-carousel').carousel({
                interval: false
            });

            // for every slide in carousel, copy the next slide's item in the slide.
            // Do the same for the next, next item.
            $('.multi-item-carousel .item').each(function(){
                var next = $(this).next();
                if (!next.length) {
                    next = $(this).siblings(':first');
                }
                next.children(':first-child').clone().appendTo($(this));
                
                if (next.next().length>0) {
                    next.next().children(':first-child').clone().appendTo($(this));
                } else {
                    $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
                }
            });
        }
        else {
            console.log('Nothing to put here yet...')
        }

        // Multi-item Carousel
        let items = document.querySelectorAll('.multi-item.carousel .carousel-item')
        items.forEach((el) => {
            const minPerSlide = 4
            let next = el.nextElementSibling
            for (var i=1; i<minPerSlide; i++) {
                if (!next) {
                    // wrap carousel by using first child
                    next = items[0]
                }
                let cloneChild = next.cloneNode(true)
                el.appendChild(cloneChild.children[0])
                next = next.nextElementSibling
            }
        })

        // DIRECTORY set active to first item
        $(document).ready(function() {
            $('.directoryCreativePortfolio > .carousel-inner > .carousel-item:first-child').addClass('active');
            // $('#recipeCarousel > .carousel-inner > .carousel-item:first-child').addClass('active');
        });

        // SHOW initially hidden input fields
        $('#email-toggle-btn').click(function(){
            $('.alt-email').toggle();
            $('#email-toggle-btn > svg').toggleClass('fa-square-minus');
            $('#email-toggle-btn > svg').toggleClass('fa-square-plus');
        });
        $('#mobile-toggle-btn').click(function(){
            $('.alt-mobile').toggle();
            $('#mobile-toggle-btn > svg').toggleClass('fa-square-minus');
            $('#mobile-toggle-btn > svg').toggleClass('fa-square-plus');
        });
        $('#addWork2').click(function(){
            $('.work-2').toggle();
            $('.work-3').hide();
            $('#addWork2 > svg').toggleClass('fa-minus');
            $('#addWork2 > svg').toggleClass('fa-plus');
        });
        $('#addWork3').click(function(){
            $('.work-3').toggle();
            $('#addWork3 > svg').toggleClass('fa-minus');
            $('#addWork3 > svg').toggleClass('fa-plus');
        });
        $('#addWorkV2').click(function(){
          $('.vWork-2').toggle();
          $('.vWork-3').hide();
          $('#addWorkV2 > svg').toggleClass('fa-minus');
          $('#addWorkV2 > svg').toggleClass('fa-plus');
      });
      $('#addWorkV3').click(function(){
          $('.vWork-3').toggle();
          $('#addWorkV3 > svg').toggleClass('fa-minus');
          $('#addWorkV3 > svg').toggleClass('fa-plus');
      });

        // SHOW Modal - Setup account or for later
        // $(window).on('load', function() {
        //     $('#modalRegistration').modal('show');
        // });

        // Last registration page - countdown then redirect to home page
        $(function () {  
            $("#btnRedirect").click(function () {  
                var seconds = 5;  
                $("#dvCountDown").show();  
                $("#lblCount").html(seconds);  
                setInterval(function () {  
                    seconds--;  
                    $("#lblCount").html(seconds);  
                    if (seconds == 0) {  
                        $("#dvCountDown").hide();  
                        window.location = "{{ url('') }}";  
                    }  
                }, 1000);  
            });  
        }); 

        //Address: automate dropdowns and zipcode if country = Philippines
        $("#region").hide();
        $("#province").hide();
        $("#city_town").hide();
        $("#area").hide();
        $("#zipcode").hide();

        country = $( "#country option:selected" ).text()
        region = $( "#region option:selected" ).text()
        province = $( "#province option:selected" ).text()
        city_town = $( "#city_town option:selected" ).text()
        area = $( "#area option:selected" ).text()
        zipcode = $( "#zipcode option:selected" ).text()

        $("#country").change(function () {
            if ($(this).val() == "Philippines") {
                $('#region').show()
            } 
        })
        $("#region").change(function () {
            if ($(this).val() == "NCR") {
                $('#province').show()
            } 
        })
        $("#province").change(function () {
            if ($(this).val() == "Metro Manila") {
                $('#city_town').show()
            } 
        })
        $("#city_town").change(function () {
            if ($(this).val() == "Pasay City") {
                $('#area').show()
            } 
        })
        $("#area").change(function () {
            if ($(this).val() == "Mall of Asia Complex (MOA)") {
                $('#zipcode').show().value('1300')
            } 
        })
    </script>

    @yield('reg_step01')