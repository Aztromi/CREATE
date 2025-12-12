let dTable = $('#exhibitor-list');



$(document).ready(function(){

    $("#loadingModal").modal({ 
        backdrop: "static", 
        keyboard: false, 
    });
    
    $('#loadingModal').modal('show');

    // $(function () {
    //     $('#exhibitor-list').DataTable({
    //         "paging": true,
    //         "lengthChange": false,
    //         "searching": true,
    //         "ordering": true,
    //         "info": true,
    //         "autoWidth": true,
    //         "responsive": true,
    //         // "buttons": [{ extend: "excel", text: 'Export as Excel File', title: 'Booth Assignment Export' }]
    //     });
    //     // .buttons().container().appendTo('#exhibitor-list_wrapper .col-md-6:eq(0)');
    // });

    dTable = $('#exhibitor-list').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        // "buttons": [{ extend: "excel", text: 'Export as Excel File', title: 'Booth Assignment Export' }]
    });

    presets();

    // MODAL HIDE Transfered in getData()
    
});

function getData($url)
{
    $.ajax({
        url: $url,
        type: 'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        // data: { 
        //     _token: $('meta[name="csrf-token"]').attr('content') 
        // },
        success: function(response) {
            if(response.validated && response.profile)
            {
                setDTable(response);
                

            }
            
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        },
        complete: function(){
            $('#loadingModal').modal('hide');
        }
    });
}

function setDTable(response) 
{
                
    dTable.clear().draw();

    // console.log(response.profile);

    $.each(response.profile, function(index, profile) {

        switch(profile.attendance_latest.status)
        {
            case 0:
                $status = "Incomplete";
            break;

            case 1:
                $status = "Approved";
            break;

            case 2:
                $status = "Pending";
            break;

            case 5:
                $status = "Denied";
            break;

            default:
                $status = "Unknown";
            break;
        }

        $formattedDate = new Intl.DateTimeFormat('en-US', { 
            month: 'long', 
            day: 'numeric', 
            year: 'numeric',
            hour: 'numeric',
            minute: 'numeric'
        }).format(new Date(profile.attendance_latest.updated_at));
        
        $row = [
            profile.disp_name,
            $status,
            $formattedDate,
            setActions(profile.user.id)//profile.id, profile.attendance_latest.status)
        ];

        dTable.row.add($row).draw(false);
    });
}

function updateExhibitorStatus()
{

}


function setActions($id)//$profileID, $status)
{
    

    $content = '<a id="view-{{ $user->id }}" href="/admin/exhibitor/details/' + $id + '" title="View details"><i class="fa fa-file"></i>&ensp;View</a>';

    return $content;
}