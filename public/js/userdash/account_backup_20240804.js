







$(document).ready(function(){


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

    $('.select2').select2();

    prepForm();

    $('#main-content').show();
    
    $('#loadingModal').modal('hide');
});



