$(document).ready(function() {


});


// $('#frm-uploadBasic').on('submit', function(e){
//     e.preventDefault();
//     $('.error-message').html('');
//     var form = $(this);

//     validateAndSave(form);
// });

function validateAndSave(form)
{
    var button = form.find('button[type="submit"]');
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            button.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            button.prop('disabled', true);
        },
        success: function(response) {
            if(response.validated)
            {
                
                // console.log('Successful.');
                window.location.replace(response.URLRedirect);
                
            }
            else
            {
                console.log(response);
            }
        },
        error: function(xhr, status, error) {

            console.log("Error: " + xhr.responseText);
        },
        complete: function() {
            button.prop('disabled', false);
            button.html('SUBMIT');
        }
    });
}

