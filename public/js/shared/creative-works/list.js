let dTable = $('#works-list');

function initializeAll(){
    dTable = $('#works-list').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
        "order": []
        // "buttons": [{ extend: "excel", text: 'Export as Excel File', title: 'Booth Assignment Export' }]
    });

    getData()
        .then(function(response){
            setData(response);
        })
        .catch(function(error){
            console.log('Error: ' + error);
        })
        .finally(function(){
            //
        });


}

function getData()
{
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/shd/creative-works/get-works',
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // data: { 
            //     _token: $('meta[name="csrf-token"]').attr('content') 
            // },
            success: function(response) {
                if(response){
                    resolve(response);
                }
                else{
                    reject(new Error(response));
                }
                
            },
            error: function(xhr, status, error) {
                // console.error(xhr.responseText);
                reject(new Error(xhr.responseText));
            },
            complete: function(){
                // $('#loadingModal').modal('hide');
            }
        });
    });
}

function setData(response){
    console.log(response);

    dTable.clear().draw();

    $.each(response.stories, function(index, story) {

        switch(story.published_status){
            case 0:
                $status = "Draft";
                break;
            case 1:
                $status = "Published";
                break;
            default:
                $status = "-";
                break;
        }
        
        if(story.user){

            $approved = story.user.approved == 1 ? 'Approved' : 'Not Approved';
            switch(story.user.verified){
                case -1:
                    $verified = 'Member';
                    break;
                case 0:
                    $verified = 'Unverified';
                    break;
                case 1:
                    $verified = 'Verified';
                    break;
                default:
                    $verified = '-';
                    break;
            }

            $creative = '<span>' + ($.trim(story.user.profile.disp_name) ? $.trim(story.user.profile.disp_name) : story.user.name) + '</span><br><div id="approved-container" class="status-label"><span>' + $approved + '</span></div><div id="verified-container" class="status-label"><span>' + $verified + '</span></div>';
            $row = [
                '<b>' + story.title + '</b>',
                $creative,
                $status,
                story.published_at ? '<div hidden>' + story.published_at + '/</div>' + formatDate(story.published_at) : '-',
                story.updated_at ? '<div hidden>' + story.updated_at + '/</div>' + formatDate(story.updated_at) : '-',
                '<a href="' + response.editLink + '/' + story.latest_slug.value + '" title="Edit details" target=”_blank”><i class="fa fa-edit"></i></a>&emsp;<a href="/creative-work/' + story.latest_slug.value + '" title="View details" target=”_blank”><i class="fa fa-external-link"></i></a>'
            ];
        }
        else{
            $row = [
                '<b>' + story.title + '</b>',
                $status || '',
                story.published_at ? '<div hidden>' + story.published_at + '/<div>' + formatDate(story.published_at) : '-',
                story.updated_at ? '<div hidden>' + story.updated_at + '/<div>' + formatDate(story.updated_at) : '-',
                '<a href="' + response.editLink + '/' + story.latest_slug.value + '" title="Edit details" target=”_blank”><i class="fa fa-edit"></i></a>&emsp;<a href="/creative-work/' + story.latest_slug.value + '" title="View details" target=”_blank”><i class="fa fa-external-link"></i></a>'
            ];

        }

        dTable.row.add($row).draw(false);
    });

}

function formatDate(date){
    return new Intl.DateTimeFormat('en-US', { 
        month: 'long', 
        day: 'numeric', 
        year: 'numeric',
        hour: 'numeric',
        minute: 'numeric'
    }).format(new Date(date));
}