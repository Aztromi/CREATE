$(document).ready(function() {
    // $('#').change(function() {
    //     if ($('#nameRadioOther').is(':checked')) 
    //     {
    //         $('input[name="name-other"]').val('').prop('disabled', false).prop('hidden', false);
    //     }
    //     else 
    //     {
    //         $('input[name="name-other"]').val('').prop('disabled', true).prop('hidden', true);
    //     }
    // });
});




$('#frm-interests').on('submit', function(e){
    e.preventDefault();

    var form = $(this);

    var interests = $("input[name='interest[]']:checked");
    if(interests.length > 0)
    {
        $('.error-interests').html('');
        check = 0;
    }
    else
    {
        $('.error-interests').html('Please select at least 1 Sector of Interest.');
        check = 1;
    }
    window.scrollTo(0, 0);

 

    if(check === 0)
    {
        validateAndSave(form);
    }
    

    // recaptchaCheck(form);

});

function validateAndSave(form)
{
    var button = form.find('button[type="submit"]');

    console.log('Submitted');

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

            // if (xhr.status === 422)
            // {
            // var errors = xhr.responseJSON.errors;
            // // Process the errors array
            // $.each(errors, function(field, messages) {
            //     // Iterate through the error messages for each field
                
            //     $.each(messages, function(index, message) {
            //         // Access individual error message and handle it
            //         clearErrors(form);

            //         console.log('Error:' + field + message);

            //         forceShowError($('#'+field), message);
                    
            //     });
            // });
            // }
            // else
            // {
            // //Possible No DB Connection

            // console.log('Error: ' + xhr.responseText);
            // }
            console.log("Error: " + xhr.responseText);
        },
        complete: function() {
            button.prop('disabled', false);
            button.html('SAVE & CONTINUE');
        }
    });




}