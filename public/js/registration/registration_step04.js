
function validateAndSave(form)
{
    $('#loadingModal').show();



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
            button.prop('disabled', false);
            button.html('NEXT');

            $('#loadingModal').hide();
        }
    });
}


function clearErrors(){
    $('.error-message').text('');
}


function prepOthModal($type, $modal)
{
    $('#otherCategoryModal .error-message').text('');
    if($type == 'exp')
    {
        $('#otherCategoryModal').find('h3').html("Other Expertise");
        $('label[for="othMainCat"]').text("Expertise Category");
        $('label[for="othNew"]').text("Expertise");

    }
    else if($type == 'main')
    {
        $('#otherCategoryModal').find('h3').html("Other Creative Service Offered");
        $('label[for="othMainCat"]').text("Creative Service Category");
        $('label[for="othNew"]').text("Creative Service");
    }

    $('#oth').val($type);

    $('#othMainCat').val('').trigger('change');
    $('#othNew').val('');

    $($modal).show();
}




$(document).ready(async function() {
    $("#loadingModal").modal({ 
        backdrop: "static", 
        keyboard: false, 
    });

    $("#otherCategoryModal").modal({ 
        backdrop: "static", 
        keyboard: false, 
    });
    
    // In case. Modal Background Transparent 
    $('.modal').css('--bs-modal-bg', 'transparent');

    $('#loadingModal').modal('show');
    

    // $('.select2').select2();

    await setCategories2($('#expertises'), 'multiple');
    await setCategories2($('#main-expertise'), 'single');
    await setCategories2($('#othMainCat'), 'single');

    
    presets();

    $('#step4-frm').on('submit', function(e){
        e.preventDefault();

        clearErrors();
        validateAndSave($(this));
    });
    
    $('#btnOthExp').on('click', function(e){
        e.preventDefault();

        prepOthModal('exp', '#otherCategoryModal');
    });

    $('#btnOthMainExp').on('click', function(e){
        e.preventDefault();

        prepOthModal('main', '#otherCategoryModal');
    });

    $('#btnOthCancel').on('click', function(e){
        e.preventDefault();

        $('#otherCategoryModal').hide();
    });

    $('#btnOthAdd').on('click', function(e){
        e.preventDefault();

        $check = true;
        $('#otherCategoryModal .error-message').text('');

        if($('#othMainCat').val().trim().length == 0)
        {
            $check = false;
            $('#othMainCat').siblings('.error-message').text('Required Field');
        }

        if($('#othNew').val().trim().length == 0)
        {
            $check = false;
            $('#othNew').siblings('.error-message').text('Required Field');
        }

        if(!$check)
        {return;}

        $newText = $('#othNew').val().trim().replace(/(?:^|\s)\w/g, function(match) {
            return match.toUpperCase();
        });
        $newVal = 'other|745|' + $('#othMainCat').val() + '|745|' + $newText;
        
        
        
        if($('#oth').val() == 'exp')
        {   
            var $newOption = $('<option>').val($newVal).text($newText);
            // $('#expertises').find('#othGroup').append($newOption);
            $('#expertises optgroup[label=Others]').append($newOption);

            $('#expertises').val($newVal).trigger('change');
        }
        else if($('#oth').val() == 'main')
        {   
            var $newOption = $('<option>').val($newVal).text($newText);
            // $('#main-expertise').find('#othGroup').append($newOption);
            $('#main-expertise optgroup[label=Others]').append($newOption);

            $('#main-expertise').val($newVal).trigger('change');
        }

        $('#otherCategoryModal').hide();
    });
    
    $('#main-content').show();
    $('#loadingModal').modal('hide');
});