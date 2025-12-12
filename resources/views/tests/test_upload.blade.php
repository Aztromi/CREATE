@extends('tests.layout')

@section('styles')
<style>
    img{
        max-width: 400px;
    }
    table{
        max-width: 1000px;
    }
</style>
@endsection

@section('scripts-bottom')
<script>

    $('#frm-file').on('submit', function(e){
        e.preventDefault();


        save($(this), new FormData(this));
    });

    function save(form, formData)
    {
        button = form.find('button[type="submit"]');
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            // data: form.serialize(),
            data: formData,  
            processData: false,
            contentType: false,
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
                    $('#message').html('Validated');
                }
                else
                {
                    $('#message').html('NOT Validated');
                }
            },
            error: function(xhr, status, error) {

                $('#message').html('');

                if (xhr.status === 422)
                {
                    // $('#message').append("Expected Error: " + xhr.responseJSON.errors);

                    var errors = xhr.responseJSON.errors;
                    console.log(errors);
                    // Process the errors array
                    $.each(errors, function(field, messages) {
                        // Iterate through the error messages for each field
                        $.each(messages, function(index, message) {
                            // Access individual error message and handle it
                            $('#message').append('Error(' + field + '): ' + message);
                        });
                    });
                }
                else
                {
                
                    // $('#message').html('Unknown Error');
                    // console.log(xhr.responseJSON.errors);
                    $('#message').append("Unknown Error: " + xhr.responseText);
                }


                // if (xhr.status === 422)
                // {
                // var errors = xhr.responseJSON.errors;

                // // Process the errors array
                // $.each(errors, function(field, messages) {
                //     // Iterate through the error messages for each field
                //     $.each(messages, function(index, message) {
                //         // Access individual error message and handle it
                //         // console.log('Error:' + field + message);
                //         toastr.error('Error(' + field + '): ' + message);
                //     });
                // });
                // }
                // else
                // {
                // toastr.error('Error 109:  Please contact System Administrator.');
                // //Possible No DB Connection

                // console.log('Error: ' + xhr.responseText);
                // }
            },
            complete: function() {
                button.prop('disabled', false);
                button.html('Save');
            }
        });
    }
</script>
@endsection

@section('content')
<div>
    
    <!-- <center><h1>Create Philippines</h1></center> -->
    <h2 style="padding-top: 50px;">TEST: UPD</h2>

    <form id="frm-file" method="POST" class="form-control" action="{{ route('admin.test.upd.vld') }}">
        <label for="file_upload">Upload File:</label>
        <input class="form-control" type="file" name="file_upload" id="file_upload">
        <!-- <input class="form-control" type="file" name="file_upload" id="file_upload" multiple> -->
        <div id="message"></div>
        <button type="submit" class="form-control btn btn-primary">Submit</button>
        <button class="btn btn-secondary">Clear</button>
    </form>
</div>
@endsection

@section('scripts-bottom')
<script>
    $(document).ready(function(){
        $('#btnArticles').removeClass('btn-primary');
        $('#btnArticles').addClass('btn-secondary');

        // $('#btnArticles').on('click', function(e){
        //     e.preventDefault();
        // });
    });
    
</script>
@endsection