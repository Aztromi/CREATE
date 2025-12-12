@section('styles')
    <link rel="stylesheet" href="{{ asset('css/shared/loadingModal-custom.css?ver='.time()) }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

    <style>
        #main-content {
            max-width: 600px;
        }


        .select2 {
            /* width: 'resolve'; */
            width: 100% !important;
        }

        /* .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            background-color: #3E3E3E;
            border: 0;
            border-radius: 8px;

        } */

        .select2-container--default .select2-selection--single .select2-selection__arrow,
        .select2-container--default .select2-selection--multiple .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 11px;
            right: 1px;
            width: 30px;
        }

        /* X Button in selected */
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #7aabff;
            padding-right: 2px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #d12f2f;
        }
        /* END X Button in selected */

        .select2-results__group {
            background-color: #a7c7ff;
        }

        
        .select2-container--default .select2-search--inline .select2-search__field {
            color: #000000;
        }

        /* .select2-container--default .select2-selection--single .select2-selection__rendered,
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {

            background-color: #3E3E3E;
            color: #FFFFFF;
            padding: 10px 10px;
            border: 0;
            border-radius: 8px;
            font-size: 1.2em;
            font-weight: 400;
        } */
        
        .select2-selection__choice{ 
            background-color: blue;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #FFFFFF;
        }

        label {
            line-height: 1.4;
        }

        .sub-label-container {
            line-height: 1.2;
            margin-bottom: 5px;
        }

        .sub-label {
            width: 100%;
            font-size: 14px !important;
            color: #31A2F0;;
            font-style: italic;
        }

        .btn-secondary {
            background-color: transparent !important;
            border: 1px solid transparent !important;
            color: #000000 !important;
        }

        .btn-secondary:hover {
            border: 1px solid #000000 !important;
        }


    </style>
@endsection

@section('scripts-bottom')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $("#loadingModal").modal({ 
                backdrop: "static", 
                keyboard: false, 
            });

            $('#professional_types').select2({
                placeholder: "Select professional types",
                allowClear: true
            });

            $('#project_goals').select2({
                placeholder: "Select professional types",
                allowClear: true
            });

            $('#loadingModal').modal('show');
            $('#main-content').hide();




            $('#main-content').show();
            $('#loadingModal').modal('hide');

            $('#frm-connect-creative').on('submit', function(e){
                if (!this.checkValidity()) {
                    return;
                }
                e.preventDefault();

                validateAndSave(this);
            });

            $('.btn-cancel').on('click', function(){
                window.location.href = "{{ $options->cancel_link }}";
            });



        });

        function validateAndSave(form) {

            $('#loadingModal').modal('show');
            
            var formData = new FormData(form);

            $.ajax({
                url: form.action,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                },
                success: function(response) {
                    
                    if(response.validated) {
                        alert('Request submitted.');
                        window.location.href = response.urlRedirect;
                    } else {
                        alert('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.');
                        console.log(response);
                    }
                },
                error: function(xhr, status, error) {

                    if (xhr.status === 422) {

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
                    } else if(xhr.status === 401) {
                        window.location.href = '/login';
                    } else if(xhr.status === 404) {
                        window.location.href = xhr.responseJSON.urlRedirect;
                    } else {
                        //Possible No DB Connection

                        // console.log('Error: ' + xhr.responseText);
                        alert('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.');
                    }

                    
                },
                complete: function() {
                    $('#loadingModal').modal('hide');
                }
            });
        }


    </script>
@endsection