$(document).ready(function(){
    $("#loadingModal").modal({ 
        backdrop: "static", 
        keyboard: false, 
    }); 

    $('#loadingModal').modal('show');
    $('#main-content').hide();
    
    initializeAll();

    $('#main-content').show();
    $('#loadingModal').modal('hide');
});