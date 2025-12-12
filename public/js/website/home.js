$(document).ready(function(){
    // $('#navSearchForm').on('submit', function(e){
    //     processSearch();
    // });

    $('#navSearchForm #search').keypress(function(e){
        if(e.keyCode === 13)
        {
            $('#navSearchForm').submit();
            // processSearch();
        }
    });

});


// function processSearch()
// {
//     $form = $('#navSearchForm');
//     $searchValue = $('#navSearchVal').val().trim();

//     var button = $('#navSearchBtn');
//     var sUrl = $form.attr('action');

//     $.ajax({
//         url: sUrl,
//         type: 'GET',
//         data: { "value": $searchValue },
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         beforeSend: function() {
//           button.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
//           button.prop('disabled', true);
//         },
//         success: function(response) {
//         },
//         error: function(xhr, status, error) {
//         },
//         complete: function() {
//           button.prop('disabled', false);
//           button.html('<i class="fa-solid fa-magnifying-glass"></i>');
//         }
//     });


// }