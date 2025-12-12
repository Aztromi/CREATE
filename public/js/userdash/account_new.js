







$(document).ready(function(){

    


    $("#loadingModal").modal({ 
        backdrop: "static", 
        keyboard: false, 
    }); 

    $('#loadingModal').modal('show');

    $('.select2').select2();

    prepForm();

    $('#main-content').show();







    $('#loadingModal').modal('hide');
});

$(window).on('load', function() {

    // Jobs
        // if ($('#jobsList tbody tr').length > 0)
        // {
        //     $('#jobsList').on('click', '.removeX', function(){
        //         $(this).closest("tr").remove();
        //         if($('#jobsList tr').length == 1)
        //         {
        //             $('#jobsList').hide();
        //         }
        //     });
        // }
    // END Jobs

    // // CLIENTS Additional Event assignment on complete load
    //     var ulHasLi = $('#clientList').children('li').length > 0;

    //     if (ulHasLi)
    //     {
    //         $('#clientList').on('click', '.clientX', function(){
    //             clients = removeFromArray(clients, $(this).closest("li").text());
    //             $(this).closest("li").remove();
    //         });
    //     }
    // // END CLIENT

    // // AWARDS
    //     if ($('#awardsList tbody tr').length > 1)
    //     {
    //         $('#awardsList').on('click', '.awardX', function(){
    //             $(this).closest("tr").remove();
    //         });
    //     }
    // // END AWARDS

});


