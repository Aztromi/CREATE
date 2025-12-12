

function statusButtonHandler(type, state)
{
    switch(type)
    {
        case 'approved':
            switch(state)
            {
                case -1:
                    $('#btn-approve').show();
                    $('#btn-disapprove').hide();

                    $('#lbl-approved').html('NO');
                break;
                case 0:
                    $('#btn-approve').show();
                    $('#btn-disapprove').hide();

                    $('#lbl-approved').html('NO');
                break;
                case 1:
                    $('#btn-approve').hide();
                    $('#btn-disapprove').show();

                    $('#lbl-approved').html('YES');
                break;
            }
        break;
        case 'verified':
            switch(state)
            {
                case -1:
                    $('#btn-unverified').show();
                    $('#btn-verified').show();
                break;
                case 0:
                    $('#btn-unverified').hide();
                    $('#btn-verified').show();

                    // $('#lbl-verified').html('Unverified');
                break;
                case 1:
                    $('#btn-unverified').hide();
                    $('#btn-verified').hide();

                    // $('#lbl-verified').html('Verified');
                break;
            }
        break;
        case 'deny':
            switch(state)
            {
                case 0:
                    $('#btn-deny').hide();
                break;
                case 1:
                    $('#btn-deny').show();
                break;
            }
        break;
    }
}

// Status Buttons
function statusChange(id, btn)
{
    $('#loadingModal').modal('show');

    if(btn == 'btn-unverified' || btn == 'btn-verified')
    {   
        var newV = -1;
        switch(btn)
        {
            case 'btn-unverified':
                newV = 0;
            break;
            case 'btn-verified':
                newV = 1;
            break;
        }
        updateVerified(id, newV);
    }
    else if(btn == 'btn-approve' || btn == 'btn-disapprove')
    {   
        var newV = -1;
        switch(btn)
        {
            case 'btn-approve':
                newV = 1;
            break;
            case 'btn-disapprove':
                newV = 0;
            break;
        }
        updateApproved(id, newV);
    }
    else if(btn == 'btn-deny')
    {   
        denyRequest(id);
    }

    $('#loadingModal').modal('hide');
}

function statusChangeExb($id, $btn)
{
    switch($btn)
    {
        case 'btn-exb-approve':
            $lbl = 'Approved';
            $newStatus = 1;
        break;
        case 'btn-exb-deny':
            $lbl = 'Denied';
            $newStatus = 5;
        break;
    }

    updateExhib($id, $lbl, $newStatus);
}

function updateExhib($id, $lbl, $newStatus)
{
    $.ajax({
        url: '/admin/exhibitor/update-exhibitor-status',
        method: 'POST',
        data: { 
            uID: $id,
            newStatus: $newStatus
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if(response.validated)
            {
                $('#btnGroupExb').html('');
                $('#lbl-exbStatus').text($lbl);
            }
            else
            {
                alert('Error: Please contact System Administrator.');
            }
        },
        error: function(xhr, status, error) {
            alert('Error: Please contact System Administrator.');
        }
    });
}

function updateVerified(id, newV)
{
    $.ajax({
        url: '/admin/application-requests/status',
        method: 'POST',
        data: { 
            uID: id,
            newStatus: newV
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            statusButtonHandler('verified', newV);
            
        },
        error: function(xhr, status, error) {
        }
    });
}

function updateApproved(id, newV)
{
    $.ajax({
        url: '/admin/application-requests/approval',
        method: 'POST',
        data: { 
            uID: id,
            newApproval: newV
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            
            statusButtonHandler('approved', newV);

        },
        error: function(xhr, status, error) {
        }
    });
}

function denyRequest(id)
{
    $.ajax({
        url: '/admin/application-requests/deny',
        method: 'POST',
        data: { 
            uID: id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            statusButtonHandler('deny', 0);
            
        },
        error: function(xhr, status, error) {
        }
    });
    
}

// END Status Buttons


$(document).ready(function(){
    
    initializeAll();
    
    setStates();

    $('.actBtn').on('click', function(){
        // alert(this.id);
        statusChange($('#uID').val(), this.id);
    });

    $('.actBtnExb').on('click', function(){
        // alert(this.id);
        statusChangeExb($('#uID').val(), this.id);
    });


    
});
