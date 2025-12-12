

function validateAndSave(form)
{
    // var button = form.find('button[type="submit"]');

    $('#loadingModal').modal('show');

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
        },
        success: function(response) {
            
            if(response.validated)
            {
                window.location.href = response.URLRedirect;
                // alert('Successfully saved.')
            }
            else
            {
                alert('Error: Please contact System Administrator.');
                console.log(response);
            }
        },
        error: function(xhr, status, error) {

            if (xhr.status === 422)
            {
            var errors = xhr.responseJSON.errors;

            // Process the errors array
            $.each(errors, function(field, messages) {
                // Iterate through the error messages for each field
                $.each(messages, function(index, message) {
                    $('#' + field + '-error').text(message);
                    // Access individual error message and handle it
                    // console.log('Error:' + field + message);
                });
            });

            alert('Please review your entries before submitting the form. Ensure all required fields are filled.');
            }
            else
            {
            //Possible No DB Connection

            console.log('Error: ' + xhr.responseText);
            alert('Error: Please contact System Administrator .');
            }

            
        },
        complete: function() {
            $('#loadingModal').modal('hide');
        }
    });
}


function clearErrors(){
    $('.error-message').text('');
}


$(document).ready(async function(){
    
    $("#loadingModal").modal({ 
        backdrop: "static", 
        keyboard: false, 
    });
    
    // In case. Modal Background Transparent 
    $('.modal').css('--bs-modal-bg', 'transparent');

    $('#loadingModal').modal('show');

    await setCountries2('main', false);

    await presets();

    $('#country').on('change', async function(){
        await addressReset2('main', $(this).val(), $('#regionM'), true);
    });

    $('#regionM').on('change', async function(){
        await setLocalAddressDetails2('main', 'province', $(this).val(), $('#provinceM'), true);
    });

    $('#provinceM').on('change', async function(){
        await setLocalAddressDetails2('main', 'city_town', $(this).val(), $('#cityM'), true);
    });
    
    $('#step2-frm').on('submit', function(e){
        e.preventDefault();

        clearErrors();
        validateAndSave($(this));
    });
    
    $('#main-content').show();
    $('.select2').select2();
    $('#loadingModal').modal('hide');
});



/*



// function recaptchaCheck(form)
// {
//     $.ajax({
//         // url: form.attr('action'),
//         url: '{{ route('recaptcha') }}',
//         type: 'POST',
//         data: form.serialize(),
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         beforeSend: function() {
          
//         },
//         success: function(response) {
//             console.log('Success');
            
//         },
//         error: function(xhr, status, error) {
//             console.log(xhr.responseText);
          
//         },
//         complete: function() {
          
//         }
//     });
// }

*/