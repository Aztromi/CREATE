
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="{{ URL::asset('fontawesome/js/all.min.js') }}"></script>
<script src="{{ URL::asset('js/adminlte.min.js') }}"></script>


<script>
  // SET SIDE Navigation Height
  $(document).ready(function() {
    var pageHeight = $(document).height();
    $("aside").height(pageHeight);
  });

  //SIDE NAVIGATION
  $(document).ready(function() {
    $(".aside-button").click(function() {
      $(".aside-button > svg").toggleClass('fa-bars fa-xmark');
      $("body:not(.layout-fixed) .main-sidebar").css('left', '250px');
    });
  });


  // ADD additional input for portfolio
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
</script>