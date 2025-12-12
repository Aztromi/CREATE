$(document).ready(function() {

    

    // $('#requests-data-table').DataTable({
    //     ordering: false
    //     // searching: false,
    //     // lengthChange: false
    //     // columnDefs: [
    //     //     { 
    //     //       targets: [1], // Index of the column you want to exclude (zero-based index)
    //     //       searchable: false
    //     //     }
    //     //   ]
        
    // });

    $(function () {
        $('#requests-data-table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        });
    });

    


    function formatRowStatus(status, approval)
    {
        newContent = '';

        switch(status)
        {
            case -1:
                newContent = '<div class=" status_member ">Member</div>';
                break;
            case 0:
                newContent = '<div class=" status_unverified ">Unverified</div>';
                break;
            case 1:
                newContent = '<p hidden>0F5J3F7R</p><div class=" status_verified ">Verified</div>';
                break;
            default:
                return "false";
                break;

        }

        switch(approval)
        {
            case 0:
                newContent = newContent + '<div class="text-center font-weight-light">Disapproved</div>';
                break;
            case 1:
                newContent = newContent + '<div class="text-center font-weight-light">Approved</div>';
                break;
            default:
                return "false";
                break;
        }
            
        return newContent;
    }

    function formatRowActions(id, status, approval, viewLink)
    {
        // newContent='<a id="view-' + id + '" href="' + viewLink + '" title="View details"><i class="fa fa-file"></i>&ensp;View</a><br>';

        newContent='<a id="edit-' + id + '" href="' + viewLink + '" title="Edit details"><i class="fa fa-edit"></i>&ensp;Edit</a><br>';
        
        

        switch(approval)
        {
            case 0:
                newContent = newContent + '<a class="act-approval" title="Approve" data-action-id="' + id + '" data-action-val=1><i class="fa fa-circle-check"></i>&ensp;Approve</a><br>';
                break;
            case 1:
                newContent = newContent + '<a class="act-approval" title="Disapprove" data-action-id="' + id + '" data-action-val=0><i class="fa fa-circle-xmark"></i>&ensp;Disapprove</a><br>';
                break;
            default:
                return "false";
                break;
        }

        switch(status)
        {
            case -1:
                newContent = newContent + '<a class="act-status" title="elevate to Unverified" data-action-id="' + id + '" data-action-val=0><i class="fa fa-check"></i>&ensp;Unverified</a><br>';
                break;
            case 0:
                newContent = newContent + '<a class="act-status" title="elevate to Verified" data-action-id="' + id + '" data-action-val=1><i class="fa fa-check-double"></i>&ensp;Verified</a><br>';
                break;
            case 1:
                break;
            default:
                return "false";
                break;
        }

        return newContent;
    }

    

    $('#status-filter').on('change', function() {
        var selectedValue = $(this).val();
        var table = $('#requests-data-table').DataTable();

        //Display all. No search for column 1
        table.column(1).search('').draw();
        // table.search('').draw();

        
        if (selectedValue === 'pending')
        {
            table.column(1).search('Pending', true).draw();
        }
        else if (selectedValue === 'member')
        {
            table.column(1).search('Member', true).draw();
        }
        else if (selectedValue === 'unverified')
        {
            // table.column(1).search("^" + " Unverified " + "$", true, false, true).draw();
            table.column(1).search('Un').draw();
        }
        else if (selectedValue === 'verified')
        {
            // table.column(1).search("^" + $.fn.dataTable.util.escapeRegex(" Verified ") + "$", true, false, true).draw();
            // table.column(1).search('Verified', true).draw();
            table.column(1).search('0F5J3F7R', true).draw();
        }
        else if (selectedValue === 'denied')
        {
            table.column(1).search('Denied', true).draw();
        }

    });

    function processApproval(uID, newApproval, rowStatusID, rowActionsID, currentStatus, viewLink)
    {
        $.ajax({
            url: '/admin/application-requests/approval',
            method: 'POST',
            data: { 
                uID: uID,
                newApproval: newApproval
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Handle the response from the controller
                console.log('Approval Change Successful');

                var newStatusElement = formatRowStatus(currentStatus, newApproval);
                $(rowStatusID).html(newStatusElement);

                var newActionsElement = formatRowActions(uID, currentStatus, newApproval, viewLink);
                $(rowActionsID).html(newActionsElement);

                // APPROVAL ON CLICK
                // $('.act-approval').click(function() {
                    $('.act-approval').on('click', function() {
                        $('#loadingModal').show();
                        var uID = $(this).data('action-id');
                        var newApproval = $(this).data('action-val');
                        var rowStatusID = '#status-'+uID;
                        var rowActionsID = '#actions-'+uID;
                        var currentStatus = $(rowStatusID).data('v');
                
                        var viewLink = $('#edit-'+uID).attr('href');
                        // var editLink = $('#edit-'+uID).attr('href');
                
                        // Save reference to the current scope
                        // var $this = $(this);
                        
                        $(rowStatusID).data('a', newApproval);
                        processApproval(uID, newApproval, rowStatusID, rowActionsID, currentStatus, viewLink);

                        $('#loadingModal').hide();
                    });
                
                    // STATUS ON CLICK
                    $('.act-status').click(function() {
                        $('#loadingModal').show();
                        var uID = $(this).data('action-id');
                        var newStatus = $(this).data('action-val');
                        var rowStatusID = '#status-'+uID;
                        var rowActionsID = '#actions-'+uID;
                        var currentApproval = $(rowStatusID).data('a');
                
                        var viewLink = $('#edit-'+uID).attr('href');
                        // var editLink = $('#edit-'+uID).attr('href');
                
                        // Save reference to the current scope
                        // var $this = $(this);
                        
                        $(rowStatusID).data('v', newStatus);
                        processStatus(uID, newStatus, rowStatusID, rowActionsID, currentApproval, viewLink);

                        $('#loadingModal').hide();
                    });

            },
            error: function(xhr, status, error) {
                // console.log("D Error: " + error + "||" + xhr.responseText);
            }
        });
    }

    function processStatus(uID, newStatus, rowStatusID, rowActionsID, currentApproval, viewLink)
    {
        $.ajax({
            url: '/admin/application-requests/status',
            method: 'POST',
            data: { 
                uID: uID,
                newStatus: newStatus
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Handle the response from the controller
                console.log('Status Change Succesful');

                var newStatusElement = formatRowStatus(newStatus, currentApproval);
                $(rowStatusID).html(newStatusElement);

                var newActionsElement = formatRowActions(uID, newStatus, currentApproval, viewLink);
                $(rowActionsID).html(newActionsElement);

                // APPROVAL ON CLICK
                // $('.act-approval').click(function() {
                    $('.act-approval').on('click', function() {
                        $('#loadingModal').show();
                        var uID = $(this).data('action-id');
                        var newApproval = $(this).data('action-val');
                        var rowStatusID = '#status-'+uID;
                        var rowActionsID = '#actions-'+uID;
                        var currentStatus = $(rowStatusID).data('v');
                
                        var viewLink = $('#edit-'+uID).attr('href');
                        // var editLink = $('#edit-'+uID).attr('href');
                
                        // Save reference to the current scope
                        // var $this = $(this);
                        $(rowStatusID).data('a', newApproval);
                        processApproval(uID, newApproval, rowStatusID, rowActionsID, currentStatus, viewLink);
                
                        $('#loadingModal').hide();
                    });
                
                    // STATUS ON CLICK
                    $('.act-status').click(function() {
                        $('#loadingModal').show();
                        var uID = $(this).data('action-id');
                        var newStatus = $(this).data('action-val');
                        var rowStatusID = '#status-'+uID;
                        var rowActionsID = '#actions-'+uID;
                        var currentApproval = $(rowStatusID).data('a');
                
                        var viewLink = $('#edit-'+uID).attr('href');
                        // var editLink = $('#edit-'+uID).attr('href');
                
                        // Save reference to the current scope
                        // var $this = $(this);
                        
                        $(rowStatusID).data('v', newStatus);
                        processStatus(uID, newStatus, rowStatusID, rowActionsID, currentApproval, viewLink);

                        $('#loadingModal').hide();
                    });

            },
            error: function(xhr, status, error) {
                // console.log(error);
            }
        });
    }

    // APPROVAL ON CLICK
    // $('.act-approval').click(function() {
    $('.act-approval').on('click', function() {
        $('#loadingModal').show();
        var uID = $(this).data('action-id');
        var newApproval = $(this).data('action-val');
        var rowStatusID = '#status-'+uID;
        var rowActionsID = '#actions-'+uID;
        var currentStatus = $(rowStatusID).data('v');

        var viewLink = $('#edit-'+uID).attr('href');
        // var editLink = $('#edit-'+uID).attr('href');

        // Save reference to the current scope
        // var $this = $(this);

        $(rowStatusID).data('a', newApproval);
        processApproval(uID, newApproval, rowStatusID, rowActionsID, currentStatus, viewLink);

        $('#loadingModal').hide();
    });

    // STATUS ON CLICK
    $('.act-status').click(function() {
        $('#loadingModal').show();
        var uID = $(this).data('action-id');
        var newStatus = $(this).data('action-val');
        var rowStatusID = '#status-'+uID;
        var rowActionsID = '#actions-'+uID;
        var currentApproval = $(rowStatusID).data('a');

        var viewLink = $('#edit-'+uID).attr('href');
        // var editLink = $('#edit-'+uID).attr('href');

        // Save reference to the current scope
        // var $this = $(this);

        $(rowStatusID).data('v', newStatus);
        processStatus(uID, newStatus, rowStatusID, rowActionsID, currentApproval, viewLink);

        $('#loadingModal').hide();
    });

    
    
});