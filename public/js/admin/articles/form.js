


function initializeAll(){

    
    setInitial()
        .then(function(){
            return setTagsWithSelection($("#cField"), 'article', $articleID);
        })
        // .then(function(){
        //     return getData();
        // })
        // .then(function(response){
        //     if (response !== null) {
        //         setData(response);
        //     }
        //     // else {
        //     //     console.log('No data to set.');
        //     // }
        // })
        .catch(function(error){
            console.log('Error: ' + error);
        })
        .finally(function(){
            $('#main-content').show();
            $('#loadingModal').modal('hide');
        });


}

function setInitial(){
    return new Promise((resolve) => {
        $('#masthead').dropify({
            messages: {
                'default': 'Drag and drop your masthead image here, or click to select',
                // 'replace': 'Drag and drop or click to replace',
                // 'remove':  'Remove',
                'error':   '!'
        
            }
        });

        $('#frm-article').on('submit', function(e){
            tinymce.get('article-content').save();
            if (!this.checkValidity()) {
                return;
            }
            e.preventDefault();

            validateAndSave(this);
        });

        $('#masthead').on('change', function(){
            $('#masthead-change').val(1);
        });

        resolve();
    });
}



function validateAndSave(form)
{

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
            
            if(response.validated)
            {
                alert('Successfully saved.');
                window.location.href = response.urlRedirect;
            }
            else
            {
                alert('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.');
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
            else if(xhr.status === 401){
                window.location.href = '/login';
            }
            else if(xhr.status === 404){
                window.location.href = xhr.responseJSON.urlRedirect;
            }
            else
            {
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