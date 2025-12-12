@section('styles')
    <link rel="stylesheet" href="{{ asset('css/shared/loadingModal-custom.css?ver='.time()) }}">
    <style>
        #frm-change-password .row {
            margin-bottom: 15px;
        }

        .password-container {
            display: flex;
            flex-direction: column; /* Stack all elements vertically */
        }

        .password-container label {
            margin-bottom: 3px; /* Space between the label and the input */
        }

        .password-container .input-group {
            display: flex; /* Align input and icon on the same line */
            align-items: center;
        }

        .password-container .input-group input {
            flex: 1;
            margin-right: 8px; /* Space between the input and the icon */
        }

        .password-container .fa-eye, .password-container .fa-eye-slash  {
            cursor: pointer;
            font-size: 20px;
            padding-left: 5px;
        }

        .password-container .error-message {
            margin-top: 2px; /* Space between the input group and the error message */
            margin-left: 5px;
        }

        #passwordConditions .fa-check {
            color: green;
        }

        #passwordConditions .fa-xmark {
            color: red;
        }
    </style>
@endsection

@section('scripts-bottom')
    <script> 
        $(document).ready(function(){
            $("#loadingModal").modal({ 
                backdrop: "static", 
                keyboard: false, 
            });

            //No ASYNC to PRELOAD
            $('#loadingModal').modal('show');
            $('#main-content').hide();



            $('#main-content').show();
            $('#loadingModal').modal('hide');
        });

        $(document).on('click', '.fa-eye, .fa-eye-slash', function(){
            if($(this).hasClass('fa-eye')) {
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                $(this).siblings('input').attr('type', 'text');
            }
            else {
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                $(this).siblings('input').attr('type', 'password');
            }
        });

        $(document).on('input', '.password-container #password_new, .password-container #password_retype', function(){
            checkPasswordInput($(this), true);
        });

        function checkPasswordInput($field, $alert) {
            var password = $field.val();

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

            var isPasswordsMatch = false;
            if($('#password_new').val() === $('#password_retype').val())  {
                isPasswordsMatch = true;
            }

            if($alert) {
                $('#lengthIcon').toggleClass('fa-check', isLengthValid).toggleClass('fa-xmark', !lengthRegex.test(password));
                $('#uppercaseIcon').toggleClass('fa-check', isUppercaseValid).toggleClass('fa-xmark', !uppercaseRegex.test(password));
                $('#lowercaseIcon').toggleClass('fa-check', isLowercaseValid).toggleClass('fa-xmark', !lowercaseRegex.test(password));
                $('#numberIcon').toggleClass('fa-check', isNumberValid).toggleClass('fa-xmark', !numberRegex.test(password));
                $('#specialCharIcon').toggleClass('fa-check', isSpecialCharValid).toggleClass('fa-xmark', !specialCharRegex.test(password));
                $('#passwordMatchIcon').toggleClass('fa-check', isPasswordsMatch).toggleClass('fa-xmark', !isPasswordsMatch);


                if($field.closest('.password-container').find('.error-message').text('').length > 0)
                {
                        $field.closest('.password-container').find('.error-message').text('');
                }
            }

            $check = false;
            if(isLengthValid && isUppercaseValid && isLowercaseValid && isNumberValid && isSpecialCharValid && isPasswordsMatch) {
                $check = true;
            }

            return $check;
        }

        $('#frm-change-password').on('submit', function(e){
            e.preventDefault();

            $('.error-message').text('');

            if(checkPasswordInput($('#password_new'), true) && $('#password_current').val().length > 0) {
                
                $('#loadingModal').modal('show');

                let formData = new FormData();
                formData.append('p_current', $('#password_current').val());
                formData.append('p_new', $('#password_new').val());

                $.ajax({
                    url: "{{ route('user.passwordvalidateAndSave') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting the content type
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    success: async function(response) {
                        if(response.check == false) {
                            $('#password_current').closest('.password-container').find('.error-message').text('The current password provided is incorrect');
                        }
                        else {
                            alert('password successfully updated.');
                            logout();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.');
                    },
                    complete: function(xhr, status) {
                        $('#loadingModal').modal('hide');
                    }
                });


            }
            else {
                alert('Please ensure that all fields are filled, and the password requirements are met.')
            }
        });

        function logout() {
            window.location.href = '/dashboard';
            {{-- REMOVED. Logout executed in Controller
            $.post({
                url: '/logout',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function() {
                    window.location.href = '/dashboard'; // Redirect after logout
                },
                error: function(xhr, status, error) {
                    // console.log(xhr.responseText);
                    // alert('An error occurred while logging out. Please try again.');
                    window.location.href = '/dashboard';

                }
            });
            --}}
        }


    </script>

@endsection