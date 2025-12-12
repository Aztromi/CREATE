
  $('#frm-msg').on('submit', function(e){
        e.preventDefault();

        

        var form = $('#frm-msg');
        var fname = form.find('input[name="fname"]');
        var lname = form.find('input[name="lname"]');
        var email = form.find('input[name="em"]');
        var message  = form.find('textarea[name="tMessage"]');

        var check = 0;

        check += inputCheckAndRespond(fname);
        check += inputCheckAndRespond(lname);
        check += inputCheckAndRespond(email);
        check += inputCheckAndRespond(message);

        if(check == 0)
        {
            validateAndSave(form);
        }
    });

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
                    clearForm();
                    // console.log('Message Successfully sent.')
                    $('#modal-mail-sent').modal('show');
                }
                else
                {
                    // console.log(response);
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
                        // Access individual error message and handle it
                        clearErrors(form);

                        // console.log('Error:' + field + message);

                        forceShowError($('#'+field), message);
                        
                    });
                });
                }
                else
                {
                //Possible No DB Connection

                // console.log('Error: ' + xhr.responseText);
                }
            },
            complete: function() {
                button.prop('disabled', false);
                button.html('SEND');
            }
        });
    }
    
    function clearForm()
    {
        var form = $('#frm-msg');
        form.find('input[name="fname"]').val('');
        form.find('input[name="lname"]').val('');
        form.find('input[name="em"]').val('');
        form.find('textarea[name="tMessage"]').val('');

        clearErrors(form);
    }

    function clearErrors(form)
    {
        form.find('input[name="fname"]').siblings('.error-message').text('');
        form.find('input[name="lname"]').siblings('.error-message').text('');
        form.find('input[name="em"]').siblings('.error-message').text('');
        form.find('textarea[name="tMessage"]').siblings('.error-message').text('');
    }

    function forceShowError(cont, message)
    {
        cont.siblings('.error-message').text(message);
    }

    function inputCheckAndRespond(cont)
    {
        if(cont.val().trim().length === 0)
        {
            cont.siblings('.error-message').text('Required Field');

            return 1;
        }
        else
        {
            cont.siblings('.error-message').text('');

            return 0;
        }
    }
