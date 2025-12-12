$(document).ready(function() {
    
    var inputFields = $('#registration-form-01').find('input:not([name="re_password"], [name="termsCheck"])');
    var errorMessages = $('.error-message');

    inputFields.on('blur', function() {
        validateField($(this));
    });

    $('#password').on('input', function () {
        var password = $(this).val();

        // Show/hide password conditions based on whether the input has a value
        $('#passwordConditions').toggle(!!password);

        // Define the regular expressions for the password conditions
        var lengthRegex = /.{8,}/;
        var uppercaseRegex = /[A-Z]/;
        var lowercaseRegex = /[a-z]/;
        var numberRegex = /\d/;
        var specialCharRegex = /[@$!%*?&]/;

        var isLengthValid = lengthRegex.test(password);
        var isUppercaseValid = uppercaseRegex.test(password);
        var isLowercaseValid = lowercaseRegex.test(password);
        var isNumberValid = numberRegex.test(password);
        var isSpecialCharValid = specialCharRegex.test(password);

        $('#lengthIcon').toggleClass('fa-check', isLengthValid).toggleClass('fa-times', !lengthRegex.test(password));
        $('#uppercaseIcon').toggleClass('fa-check', isUppercaseValid).toggleClass('fa-times', !uppercaseRegex.test(password));
        $('#lowercaseIcon').toggleClass('fa-check', isLowercaseValid).toggleClass('fa-times', !lowercaseRegex.test(password));
        $('#numberIcon').toggleClass('fa-check', isNumberValid).toggleClass('fa-times', !numberRegex.test(password));
        $('#specialCharIcon').toggleClass('fa-check', isSpecialCharValid).toggleClass('fa-times', !specialCharRegex.test(password));

        // Check and display icons based on password conditions
        // $('#lengthIcon').toggleClass('fa-check', lengthRegex.test(password)).toggleClass('fa-times', !lengthRegex.test(password));
        // $('#uppercaseIcon').toggleClass('fa-check', uppercaseRegex.test(password)).toggleClass('fa-times', !uppercaseRegex.test(password));
        // $('#lowercaseIcon').toggleClass('fa-check', lowercaseRegex.test(password)).toggleClass('fa-times', !lowercaseRegex.test(password));
        // $('#numberIcon').toggleClass('fa-check', numberRegex.test(password)).toggleClass('fa-times', !numberRegex.test(password));
        // $('#specialCharIcon').toggleClass('fa-check', specialCharRegex.test(password)).toggleClass('fa-times', !specialCharRegex.test(password));

        if($('#password').siblings('.error-message').text('').length > 0)
        {
            // if (isLengthValid && isUppercaseValid && isLowercaseValid && isNumberValid && isSpecialCharValid) {
                // Clear the .error div
                // $(this).find('input[name="password"]').siblings('.error-message').text('The firstname field is required.');
                $('#password').siblings('.error-message').text('');

            // }
        }
    });

    

    

    $('#registration-form-01').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var passwordField = form.find('input[name="password"]');
        var rePasswordField = form.find('input[name="re_password"]');
        var passwordValue = passwordField.val();
        var rePasswordValue = rePasswordField.val();


        var checkField = form.find('input[name="firstname"]');
        var checkValue = checkField.val();
        if (checkValue === '') {
            checkField.addClass('is-invalid');
            checkField.siblings('.error-message').text('The firstname field is required.');
            return;
        }
        else
        {
            checkField.removeClass('is-invalid');
            checkField.siblings('.error-message').text('');
        }

        checkField = form.find('input[name="lastname"]');
        checkValue = checkField.val();
        if (checkValue === '') {
            checkField.addClass('is-invalid');
            checkField.siblings('.error-message').text('The lastname field is required.');
            return;
        }
        else
        {
            checkField.removeClass('is-invalid');
            checkField.siblings('.error-message').text('');
        }

        checkField = form.find('input[name="email"]');
        checkValue = checkField.val();
        if (checkValue === '') {
            checkField.addClass('is-invalid');
            checkField.siblings('.error-message').text('The email field is required.');
            return;
        }
        else
        {
            checkField.removeClass('is-invalid');
            checkField.siblings('.error-message').text('');
        }

        // Check if password and retype password fields have values and match
        if (passwordValue === '' || rePasswordValue === '') {
            passwordField.addClass('is-invalid');
            passwordField.siblings('.error-message').text('Both password fields are required.');
            rePasswordField.addClass('is-invalid');
            rePasswordField.siblings('.error-message').text('Both password fields are required.');
            return;
        }
        // else if(!(password.length >= 8 && /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/.test($('#password').val())))
        else if(password.length < 8 || $('#passwordConditions i').hasClass('fa-times'))
        {
            passwordField.addClass('is-invalid');
            passwordField.siblings('.error-message').text('Password does not meet the requirements. Please check and try again.');
        }
        else if (passwordValue !== rePasswordValue) {
            passwordField.addClass('is-invalid');
            passwordField.siblings('.error-message').text('Passwords do not match.');
            rePasswordField.addClass('is-invalid');
            rePasswordField.siblings('.error-message').text('Passwords do not match.');
            return;
        }
        else
        {
            passwordField.removeClass('is-invalid');
            passwordField.siblings('.error-message').text('');
            rePasswordField.removeClass('is-invalid');
            rePasswordField.siblings('.error-message').text('');
        }

        checkField = form.find('input[name="termsCheck"]');
        checkValue = checkField.is(':checked');
        if (!checkValue) {
            checkField.addClass('is-invalid');
            checkField.siblings('.error-message').text('Agree to the terms and conditions to continue.');
            return; 
        }
        else
        {
            checkField.removeClass('is-invalid');
            checkField.siblings('.error-message').text('');
        }

        var formData = form.serialize();
        var button = form.find('button[type="submit"]');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
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
                    // FOR EACH inputs to reset
                    $('#registration-form-01').find('input:not([name="termsCheck"])').each(function(){
                        if($(this).hasClass('is-invalid'))
                        {
                            $(this).removeClass('is-invalid');
                        }
                        $(this).siblings('.error-message').text('');
                        $(this).val('');
                    });

                    checkFieldTerms = $('#registration-form-01').find('input[name="termsCheck"]');
                    if (checkFieldTerms.length)
                    {
                        if(checkFieldTerms.hasClass('is-invalid'))
                        {
                            checkFieldTerms.removeClass('is-invalid');
                        }
                        checkFieldTerms.siblings('.error-message').text('');
                        checkFieldTerms.prop('checked', false);
                    }


                    $('#modalRegistration').modal('show');
                    // console.log('Successfully Saved');
                }
                else
                {
                    // if (response.errors && response.errors[fieldName]) {
                    //     field.addClass('is-invalid');
                    //     field.siblings('.error-message').text(response.errors[fieldName][0]);
                    // }
                    console.log(ersponse.errors);
                }
            },
            error: function(xhr, status, error) {

                console.log(xhr.responseText);

            },
            complete: function() {
                button.prop('disabled', false);
                button.html('SUBMIT');
            }
        });
    });

    function validateField(field) {
        
        var fieldName = field.attr('name');
        var fieldValue = field.val();
        var data ={};
        data[fieldName] = fieldValue;

        $.ajax({
            url: '/register/01/validate',
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                
                // var response = JSON.parse(xhr.responseText);
                if(response.validated)
                {
                    field.removeClass('is-invalid');
                    field.siblings('.error-message').text('');
                }
                else{
                    if (response.errors && response.errors[fieldName]) {
                        field.addClass('is-invalid');
                        field.siblings('.error-message').text(response.errors[fieldName][0]);
                    }
                }
            },
            error: function(xhr, status, error) {
                // console.log(xhr.responseText);
            }
        });
    }
});