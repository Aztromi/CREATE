$workID = '';
$(document).ready(function(){
    $("#loadingModal").modal({ 
        backdrop: "static", 
        keyboard: false, 
    }); 

    $('#loadingModal').modal('show');
    $('#main-content').hide();

    $("#cField").select2({
        placeholder: 'Select an option'
    });
    
    initializeAll();

    // $('#main-content').show();
    // $('#loadingModal').modal('hide');
});