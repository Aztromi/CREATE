

function validateAndSave(form)
{
    $('#loadingModal').show();

    if ($('#jobsList tbody tr').length > 0)
    {
        var dataRows = [];
        $('#jobsList tbody tr').each(function() {
            var job = $(this).find('td:eq(1)').text();
            dataRows.push(job);
        });
        
        var jsonData = JSON.stringify(dataRows);
        
        $('#jobsArr').val(jsonData);
    }
    else
    {
        $('#jobsArr').val('');
    }

    var button = form.find('button[type="submit"]');

    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        xhrFields: {
            withCredentials: true
        },
        beforeSend: function() {
            button.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            button.prop('disabled', true);
        },
        success: function(response) {
            if(response.validated)
            {
                
                // console.log('Successful.');
                window.location.replace(response.URLRedirect);
                
            }
            else
            {
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
            else
            {
            //Possible No DB Connection

            console.log('Error: ' + xhr.responseText);
            alert('Error: Please contact System Administrator .');
            }
        },
        complete: function() {
            button.prop('disabled', false);
            button.html('NEXT');

            $('#loadingModal').hide();
        }
    });
}


function clearErrors(){
    $('.error-message').text('');
}

function setRep($state, $repLabel)
{
    // Call after pre-load

    $mainContainer = '#optCompany';

    $('input[name="dispName"]').prop('checked', false).trigger('change');

    switch($state)
    {
        case 'individual':
            $($mainContainer + ' select').prop('required', false);
            $($mainContainer + ' select').prop('disabled', true);

            $($mainContainer + ' input').prop('required', false);
            $($mainContainer + ' input').prop('disabled', true);

            
            $('#nameRadioCompany').prop('disabled', true);
            $('#dispNameCompany').hide();

            $($mainContainer).hide();
        break;

        case 'represented':
            $($mainContainer + ' select').prop('required', true);
            $($mainContainer + ' select').prop('disabled', false);

            $($mainContainer + ' input').not('#co_addr1', '#co_zip').prop('required', true);
            $('#same_rep_owner').prop('required', false);
            $('#job').prop('required', false);
            $($mainContainer + ' input').prop('disabled', false);

            $($mainContainer + ' select').val('').trigger('change.select2');
            $($mainContainer + ' input').val('');

            $('#org').siblings('label[for="org"]').text($repLabel + ' Name').append(' <span style="color: red;">*</span>');
            $('#head_rep_address').text($repLabel + ' Address');
            $('#head_rep_details').text($repLabel + ' Details');

            
            $('#nameRadioCompany').prop('disabled', false);
            $('#dispNameCompany').show();
            $('#nameRadioCompany').closest('.row').find('label[for="nameRadioCompany"]').text('Name of ' + $repLabel);

            $('#co_country').val('').trigger('change');

            

            $($mainContainer).show();
        break;
    }

    $('#same_rep_owner').prop('checked', false).trigger('change');

    $('#jobsList tbody').empty();
    $('#jobsList').hide();
}

function ownerEditable($editable)
{
    if($editable == true){
        $('#owner_fname').prop('disabled', false);
        $('#owner_lname').prop('disabled', false);
        $('#owner_gender').prop('disabled', false);
        $('#owner_email').prop('disabled', false);
    }
    else{
        $('#owner_fname').prop('disabled', true);
        $('#owner_lname').prop('disabled', true);
        $('#owner_gender').prop('disabled', true);
        $('#owner_email').prop('disabled', true);
    }
}

function copyRepToOwner()
{
    $('#owner_fname').val($('#rep_fname').val());
    $('#owner_lname').val($('#rep_lname').val());
    $('#owner_gender').val($('#rep_gender').val()).trigger('change.select2');
    $('#owner_email').val($('#rep_email').val());
}


$(document).ready(async function() {
    $("#loadingModal").modal({ 
        backdrop: "static", 
        keyboard: false, 
    });
    
    // In case. Modal Background Transparent 
    $('.modal').css('--bs-modal-bg', 'transparent');

    $('#loadingModal').modal('show');

    $('.select2').select2();
    
    // Representation Initial
        $('#rep').on('change', function(){
            $('#loadingModal').modal('show');

            if($(this).val() == '' || $(this).val() == 'Individual / Independent / Freelance / Student')
            {
                setRep('individual', '');
            }
            else
            {
                setRep('represented', $(this).val());
            }
            

            $('#loadingModal').modal('hide');
        });
    // END Representation Initial


    // Display Name Other Initial
        $('input[name="dispName"]').change(function(){
            if($('input[name="dispName"]:checked').val() == 'other_name')
            {
                $('#name-other').prop('hidden', false);
                $('#name-other').prop('disabled', false);
                $('#name-other').prop('required', true);
                $('#name-other').val('');
            }
            else
            {
                $('#name-other').prop('hidden', true);
                $('#name-other').prop('disabled', true);
                $('#name-other').prop('required', false);

            }
        });
    // END Display Name Other Initial

    // Jobs Add Initial
        $('#jobsAdd').on('click', function(e){
            
            
            var job = $('#job').val().trim();

            if(job != "")
            {
                if(job.length >150)
                {
                    $('#jobsArr-error').html('Exceeded allowed number of characters. Try again.');
                }
                else
                {
                    if($('#jobsList').is(':hidden'))
                    {
                        $('#jobsList').show();
                    }

                    $('#jobsArr-error').html('');
                    $('#jobsList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td>' + job + '</td></tr>');
                    $('#job').val('');

                    $('#jobsList').on('click', '.removeX', function(){
                        $(this).closest("tr").remove();
                        if($('#jobsList tr').length == 1)
                        {
                            $('#jobsList').hide();
                        }
                    });
                }
                

                $('#job').focus();
            }
        });
    // END Jobs Add Initial


    // CheckBox Owner same Rep
        $('#same_rep_owner').change(function(){
            if($(this).is(':checked')) {
                ownerEditable(false);
                copyRepToOwner();
            } else {
                ownerEditable(true);
                $('#owner_fname').val('');
                $('#owner_lname').val('');
                $('#owner_gender').val('').trigger('change');
                $('#owner_email').val('');
            }
        });
    // END CheckBox Owner same Rep

    //Trigger Owner same as Rep
        $('#repPersonGroup input, #repPersonGroup select').on('input change', function(){
            if($('#same_rep_owner').is(':checked'))
            {
                copyRepToOwner();
            }
        });
    // END Trigger Owner same as Rep

    await setCountries2('company', false);
    
    await presets();

    // CO ADDRESS LISTENERS
        $('#co_country').on('change', async function(){
            await addressReset2('company', $(this).val(), $('#co_regionM'), true);
        });

        $('#co_regionM').on('change', async function(){
            await setLocalAddressDetails2('company', 'province', $(this).val(), $('#co_provinceM'), true);
        });

        $('#co_provinceM').on('change', async function(){
            await setLocalAddressDetails2('company', 'city_town', $(this).val(), $('#co_cityM'), true);
        });
    // END CO ADDRESS LISTENERS

    // Address Initial
        // $('#co_country').on('change', function(){
        //     $('#loadingModal').modal('show');
        //     addressReset('company', $(this).val(), $('#co_regionM'));
        //     $('#loadingModal').modal('hide');
        // });

        // $('#co_regionM').on('change', function(){
        //     $('#loadingModal').modal('show');
        //     setLocalAddressDetails('company', 'province', $(this).val(), $('#co_provinceM'));
        //     $('#loadingModal').modal('hide');
        // });

        // $('#co_provinceM').on('change', function(){
        //     $('#loadingModal').modal('show');
        //     setLocalAddressDetails('company', 'city_town', $(this).val(), $('#co_cityM'));
        //     $('#loadingModal').modal('hide');
        // });
    // END Address Initial

    

    $('#step3-frm').on('submit', function(e){
        e.preventDefault();

        clearErrors();
        validateAndSave($(this));
    });

    $('#main-content').show();

    $('#loadingModal').modal('hide');



});