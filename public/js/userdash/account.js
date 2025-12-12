
$(document).ready(function(){


    initializeAll();

    $('#masthead').dropify({
        messages: {
            'default': 'Drag and drop your masthead image here, or click to select',
            // 'replace': 'Drag and drop or click to replace',
            // 'remove':  'Remove',
            'error':   '!'
    
        }
    });
    $('#profile-photo').dropify({
        messages: {
            'default': 'Drag and drop your profile photo here, or click to select',
            // 'replace': 'Drag and drop or click to replace',
            // 'remove':  'Remove',
            'error':   '!'
    
        }
    });

    $('#masthead').on('change', function(){
        $('#masthead-change').val(1);
    });

    $('#profile-photo').on('change', function(){
        $('#profile-photo-change').val(1);
    });
    
});


