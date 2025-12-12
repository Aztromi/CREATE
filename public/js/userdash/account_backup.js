


function removeFromArray(array, valueToRemove) {
    return $.grep(array, function(value) {
        return value !== valueToRemove;
    });
}

function validateAndSave(form)
{

    $('#loadingModal').modal('show');


    // Jobs
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
    // END Jobs

    // Web
        if ($('#webList tbody tr').length > 0)
        {
            var dataRows = [];
            $('#webList tbody tr').each(function() {
                var web = $(this).find('td:eq(1)').text();
                dataRows.push(web);
            });
            
            var jsonData = JSON.stringify(dataRows);
            
            $('#webArr').val(jsonData);
        }
        else
        {
            $('#webArr').val('');
        }
    // END Web
    

    // Clients
        if ($('#clientsList tbody tr').length > 0)
        {
            var dataRows = [];
            $('#clientsList tbody tr').each(function() {
                var job = $(this).find('td:eq(1)').text();
                dataRows.push(job);
            });
            
            var jsonData = JSON.stringify(dataRows);
            
            $('#clientsArr').val(jsonData);
        }
        else
        {
            $('#clientsArr').val('');
        }
    // END Clients

    // Display Name / Company Check
        if($("input[name='dispName']:checked").val() == 'company_name' && $.trim($('#org').val()) == '')
        {
            $('#dispName-error').text('Please enter your current Company / Academe / Association / Group / Agency on the provided field above.');
        }
    // END Display Name / Company Check

    // AWARDS
    if ($('#awardsList tbody tr').length > 0)
    {
        var dataRows = [];
        $('#awardsList tbody tr').each(function() {
            var award = $(this).find('td:eq(1)').text();
            var presenter = $(this).find('td:eq(2)').text();
            var year = $(this).find('td:eq(3)').text();
            
            
            dataRows.push({ award: award, presenter: presenter, year: year });
        });
        
        var jsonData = JSON.stringify(dataRows);
        
        $('#awardsArr').val(jsonData);
        
    }
    else
    {
        $('#awardsArr').val('');
    }
    // END AWARDS
    

    // // CLIENTS
    // if (clients.length > 0)
    // {
    //     $('#clientsArr').val(JSON.stringify(clients));
    // }
    // else
    // {
    //     $('#clientsArr').val('');
    // }
    // // END CLIENTS


    


    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
        },
        success: function(response) {
            
            if(response.validated)
            {
                // window.location.href = response.URLRedirect;
                alert('Successfully saved.')
            }
            else
            {
                alert('Error: Please contact System Administrator.');
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
            else if (xhr.status === 401)
            {
                if(xhr.responseJSON.error == 'Unauthenticated')
                {
                    window.location.href = xhr.responseJSON.urlRedirect;
                }
            }
            else
            {
            //Possible No DB Connection

            console.log('Error: ' + xhr.responseText);
            alert('Error: Please contact System Administrator.');
            }

            
        },
        complete: function() {
            $('#loadingModal').modal('hide');
        }
    });
}

function getAddressDetail(container, typeValue, dataValue, selectVal, group)
{

    switch(group)
    {
        case 'individual':
            regionM = '#regionM';
            provinceM = '#provinceM';
            cityM = '#cityM';
        break;
        case 'company':
            regionM = '#co_regionM';
            provinceM = '#co_provinceM';
            cityM = '#co_cityM';
        
        break;
    }

    switch(typeValue)
    {
        case 'region':
            $(regionM).prop('disabled', false);
            $(regionM).empty();
            $(provinceM).prop('disabled', true);
            $(provinceM).empty();
            $(cityM).prop('disabled', true);
            $(cityM).empty();
            // $(brgyM).prop('disabled', true);
            // $(brgyM).empty();
        break;
        case 'province':
            $(provinceM).prop('disabled', false);
            $(provinceM).empty();
            $(cityM).prop('disabled', true);
            $(cityM).empty();
            // $(brgyM).prop('disabled', true);
            // $(brgyM).empty();
        break;
        case 'city_town':
            $(cityM).prop('disabled', false);
            $(cityM).empty();
            // $(brgyM).prop('disabled', true);
            // $(brgyM).empty();
        break;
        // case 'area':
        //     $(brgyM).prop('disabled', false);
        //     $(brgyM).empty();
        // break;
        case 'none':
            $(regionM).prop('disabled', true);
            $(regionM).empty();
            $(provinceM).prop('disabled', true);
            $(provinceM).empty();
            $(cityM).prop('disabled', true);
            $(cityM).empty();
            // $(brgyM).prop('disabled', true);
            // $(brgyM).empty();
        break;
    }
    if(typeValue != 'none')
    {
        $.ajax({
            url: '/get-address-detail',
            type: 'POST',
            data: {
                type: typeValue,
                value: dataValue
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
            },
            success: function(response) {
                
                if(response.validated)
                {
                    
    
                    var newOption = $('<option>', {
                        value: '',
                        text: 'Select One'
                    });
                    container.append(newOption);
                    
                    
                    $.each(response.addrList, function(index, option) {
                        check = false;
                        if(option == selectVal)
                        {
                            check = true
                        }
                        var newOption = $('<option>', {
                            value: option,
                            text: option,
                            selected: check
                        });
                        container.append(newOption);
                    });
                    
                }
                else
                {
                    alert('Error: Please contact System Administrator.');
                    console.log(response);
                }
            },
            error: function(xhr, status, error) {
    
                alert('Error: Please contact System Administrator.');
                console.log(xhr.responseText);
    
                
            },
            complete: function() {
            }
        });
    }
}

function resetAddress(addr, clearLocal, group)
{
    switch(group)
    {
        case 'individual':
            addrLocal = '#addrLocal';
            addrIntl = '#addrIntl';
            regionI = '#regionI';
            cityI= '#cityI';

            regionM = '#regionM';
            provinceM = '#provinceM';
            cityM= '#cityM';

        break;
        case 'company':
            addrLocal = '#co_addrLocal';
            addrIntl = '#co_addrIntl';
            regionI = '#co_regionI';
            cityI= '#co_cityI';

            regionM = '#co_regionM';
            provinceM = '#co_provinceM';
            cityM= '#co_cityM';
        break;
    }


    switch(addr)
    {
        case 'local':
            $(addrLocal).show();
            $(addrIntl).hide();

            $(regionI).prop('disabled', true);
            $(cityI).prop('disabled', true);

            $(regionM).prop('disabled', false);
            $(provinceM).prop('disabled', false);
            $(cityM).prop('disabled', false);

            $(regionM).prop('required', true);
            $(provinceM).prop('required', true);
            $(cityM).prop('required', true);

            
        break;

        case 'intl':
            $(addrLocal).hide();
            $(addrIntl).show();

            $(regionI).prop('disabled', false);
            $(cityI).prop('disabled', false);

            $(regionM).prop('disabled', true);
            $(provinceM).prop('disabled', true);
            $(cityM).prop('disabled', true);

            $(regionI).prop('required', true);
            $(cityI).prop('required', true);
        break;

        case 'clr':
            $(addrLocal).hide();
            $(addrIntl).hide();

            $(regionI).prop('disabled', true);
            $(cityI).prop('disabled', true);
            $(regionM).prop('disabled', true);
            $(provinceM).prop('disabled', true);
            $(cityM).prop('disabled', true);
        break;
    }

    $(regionI).val('');
    $(cityI).val('');

    if(group == 'individual')
    {
        $('#addr1').val('');
        $('#addr2').val('');
        $('#zip').val('');
    }

    if(clearLocal)
    {
        getAddressDetail('', 'none', '', '', group);
    }
}



function uploadAndLoadImage(file, errorField, type)
{
    $url = 'upload/photo-process';

    $form = $("<form>").attr("id", "frm-user-account-upload");
    $form.append(file);
    // $form.append($("<input>").attr("type", "text").attr("name", "type").val(type));
    



    var formData = new FormData($form[0]);


    $.ajax({
        url: $url,
        type: 'POST',
        // data: $form.serialize(),
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
        },
        success: function(response) {
            
            if(response.validated)
            {
                // $('#profile-image').attr('src', response.image_path);

                alert('Image successfully saved.');
                
            }
            else
            {
                alert('Error: Please contact System Administrator.');
                console.log(response);
            }
        },
        error: function(xhr, status, error) {

            if (xhr.status === 422)
            {
                var errors = xhr.responseJSON.errors;

                $.each(errors, function(field, messages) {
                    $.each(messages, function(index, message) {
                        errorField.text(message);
                    });
                });
                alert('Please review your entries before submitting the form. Ensure all required fields are filled.');
            }
            else if (xhr.status === 423)
            {
                console.log("Error: " + xhr.responseJSON.error);
            }
            
        },
        complete: function() {
            $('#loadingModal').modal('hide');
        }
    });




    

}

function processImage(element, type)
{
    $('#loadingModal').modal('show');

    $('#photoUpload-error').text('');

    switch(type)
    {
        case 'profile':

        

        const fileInput = element.prop('files')[0];
        const errorMessage = $('#photoUpload-error');
        // const file = fileInput.files[0];
        const file = fileInput;

        if (file) {
            // Validate file type (assuming only images are allowed)
            if (!file.type.startsWith('image/')) {
            errorMessage.text('Please select a valid image file.');
            fileInput.value = ''; // Clear the input to prevent submission
            $('#loadingModal').modal('hide');
            return;
            }

            // Create an image element to check dimensions
            const img = new Image();
            img.src = URL.createObjectURL(file);

            img.onload = function() {
            // Validate image dimensions
            const maxWidth = 1000;
            const maxHeight = 1000;

            if (img.width !== img.height || img.width > maxWidth || img.height > maxHeight) {
                errorMessage.text('Image must be a square and have dimensions below 1000px.');
                fileInput.value = ''; // Clear the input to prevent submission
                $('#loadingModal').modal('hide');
            } else {
                // errorMessage.html(''); // Clear any previous error message
                uploadAndLoadImage(element, errorMessage, type);
            }
            };
        }   

        break;
        case 'banner':

        break;
    }
}


function clearErrors(){
    $('.error-message').text('');
}

// NEWADDS

function processRepresentation()
{
    
    var selectedRep = $('#rep').val();



    if(selectedRep == "" || selectedRep == "Individual / Independent / Freelance / Student")
    {
        $('#optCompany').hide();
        $('#org').prop('required', false);

        $('#co_country').prop('required', false);

        resetAddress('clr', false, 'company');

        $('#co_size').prop('required', false);
        $('#co_direct').prop('required', false);
        $('#co_indirect').prop('required', false);

        $('#same_rep_owner').prop('checked', false).trigger('change');

        $('#rep_fname').prop('required', false);
        $('#rep_lname').prop('required', false);
        $('#rep_gender').prop('required', false);
        $('#rep_email').prop('required', false);
        $('#rep_mobile').prop('required', false);

        $('#owner_fname').prop('required', false);
        $('#owner_lname').prop('required', false);
        $('#owner_gender').prop('required', false);
        $('#owner_email').prop('required', false);
        // $('#owner_mobile').prop('required', false);


        $('#org').prop('disabled', true);

        $('#co_country').prop('disabled', true);

        $('#co_size').prop('disabled', true);
        $('#co_direct').prop('disabled', true);
        $('#co_indirect').prop('disabled', true);

        $('#rep_fname').prop('disabled', true);
        $('#rep_lname').prop('disabled', true);
        $('#rep_gender').prop('disabled', true);
        $('#rep_email').prop('disabled', true);
        $('#rep_mobile').prop('disabled', true);

        $('#owner_fname').prop('disabled', true);
        $('#owner_lname').prop('disabled', true);
        $('#owner_gender').prop('disabled', true);
        $('#owner_email').prop('disabled', true);
        // $('#owner_mobile').prop('disabled', true);




        $('#dispNameCompany').hide();
        $('#nameRadioCompany').prop('disabled', true);
    }
    else
    {
        $('#optCompany').show();

        resetAddress('intl', false, 'company');

        if(selectedRep == "Others")
        {
            $('label[for="org"]').html("Name (Others) <span style='color: red;'>*</span>");
            $('#org').attr('placeholder', "Name (Others)");

            $('#head_rep_address').text("Address (Others)");
            $('#head_rep_details').text("Details (Others)");
        }
        else
        {
            $('label[for="org"]').html("Name of " + selectedRep + " <span style='color: red;'>*</span>");
            $('#org').attr('placeholder', "Name of " + selectedRep);

            $('#head_rep_address').text(selectedRep + " Address");
            $('#head_rep_details').text(selectedRep + " Details");
        }


        
        $('#org').prop('required', true);
        $('#co_country').prop('required', true);

        $('#co_size').prop('required', true);
        $('#co_direct').prop('required', true);
        $('#co_indirect').prop('required', true);

        $('#same_rep_owner').prop('checked', false).trigger('change');

        $('#rep_fname').prop('required', true);
        $('#rep_lname').prop('required', true);
        $('#rep_gender').prop('required', true);
        $('#rep_email').prop('required', true);
        $('#rep_mobile').prop('required', true);

        $('#owner_fname').prop('required', true);
        $('#owner_lname').prop('required', true);
        $('#owner_gender').prop('required', true);
        $('#owner_email').prop('required', true);
        // $('#owner_mobile').prop('required', true);

        $('#org').prop('disabled', false);
        $('#co_country').prop('disabled', false);

        $('#co_size').prop('disabled', false);
        $('#co_direct').prop('disabled', false);
        $('#co_indirect').prop('disabled', false);

        $('#rep_fname').prop('disabled', false);
        $('#rep_lname').prop('disabled', false);
        $('#rep_gender').prop('disabled', false);
        $('#rep_email').prop('disabled', false);
        $('#rep_mobile').prop('disabled', false);

        $('#owner_fname').prop('disabled', false);
        $('#owner_lname').prop('disabled', false);
        $('#owner_gender').prop('disabled', false);
        $('#owner_email').prop('disabled', false);
        // $('#owner_mobile').prop('disabled', false);
        

        $('#dispNameCompany').show();
        $('#nameRadioCompany').prop('disabled', false);
        $('label[for="nameRadioCompany"]').text("Name of Representation");


        $('#org').val('');
        $('#org-error').html('');

        $('#co_size').val('');
        $('#co_direct').val('');
        $('#co_indirect').val('');

        $('#rep_fname').val('');
        $('#rep_lname').val('');
        $('#rep_gender').val('');
        $('#rep_email').val('');
        $('#rep_mobile').val('');

        $('#owner_fname').val('');
        $('#owner_lname').val('');
        $('#owner_gender').val('');
        $('#owner_email').val('');
        // $('#owner_mobile').val('');

        $('#co_size-error').html('');;
        $('#co_direct-error').html('');;
        $('#co_indirect-error').html('');;

        $('#rep_fname-error').html('');;
        $('#rep_lname-error').html('');;
        $('#rep_gender-error').html('');;
        $('#rep_email-error').html('');;
        $('#rep_mobile-error').html('');;

        $('#owner_fname-error').html('');;
        $('#owner_lname-error').html('');;
        $('#owner_gender-error').html('');;
        $('#owner_email-error').html('');;
        // $('#owner_mobile-error').html('');;

        $('#co_country').val('');
        $('#co_country').trigger('change');
        $('#co_country-error').html('');

        $('#job').val('');
        $('#jobsList tbody').empty();
        $('#jobsList').hide();
        $('#jobsArr-error').html('');

    }
}

// END NEWADDS


$(document).ready(function(){

    


    $("#loadingModal").modal({ 
        backdrop: "static", 
        keyboard: false, 
    }); 

    $('#loadingModal').modal('show');

    $('#main-content').show();

    // $('.select2').select2();
    // $('[data-mask]').inputmask();

    // NEWADD

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
        $('#owner_gender').val($('#rep_gender').val());
        $('#owner_email').val($('#rep_email').val());
    }

    $('#same_rep_owner').change(function(){
        if($(this).is(':checked')) {
            ownerEditable(false);
            copyRepToOwner();
        } else {
            ownerEditable(true);
            $('#owner_fname').val('');
            $('#owner_lname').val('');
            $('#owner_gender').val('');
            $('#owner_email').val('');
        }
    });
    // END NEWADD

    presets();

    $('input[name="dispName"]').change(function () {
        var $nameOtherInput = $('input[name="name-other"]');
        if ($('#nameRadioOther').is(':checked')) {
            $nameOtherInput.val('').prop({
                'disabled': false,
                'hidden': false
            });
        } else {
            $nameOtherInput.val('').prop({
                'disabled': true,
                'hidden': true
            });
        }
    });

    
    presets2();

    
    // NEWADDS
    
    

    $('#rep').change(function(){
        processRepresentation();
    });

    

    $('#co_country').on('change', function() {

        $('#loadingModal').modal('show');

        var selectedValue = $(this).val();

        if (selectedValue == 'Philippines')
        {
            resetAddress('local', false, 'company');
            
            getAddressDetail($('#co_regionM'), 'region', selectedValue, '', 'company');
        }
        else
        {
            resetAddress('intl', true, 'company');
        }

        $('#loadingModal').modal('hide');
    });

    $('#co_regionM').on('change', function() {

        $('#loadingModal').modal('show');

        container = $('#co_provinceM');

        var selectedValue = $(this).val();

        if (selectedValue != '') {
            getAddressDetail(container, 'province', selectedValue, '', 'company');
        } 

        $('#loadingModal').modal('hide');
    });

    $('#co_provinceM').on('change', function() {

        $('#loadingModal').modal('show');

        container = $('#co_cityM');

        var selectedValue = $(this).val();

        if (selectedValue != '') {
            getAddressDetail(container, 'city_town', selectedValue, '', 'company');
        } 

        $('#loadingModal').modal('hide');
    });

    // END NEWADDS
    

    $('#country').on('change', function() {

        $('#loadingModal').modal('show');

        var selectedValue = $(this).val();

        if (selectedValue == 'Philippines')
        {
            resetAddress('local', false, 'individual');
            
            getAddressDetail($('#regionM'), 'region', selectedValue, '', 'individual');
        }
        else
        {
            resetAddress('intl', true, 'individual');
        }

        $('#loadingModal').modal('hide');
    });

    $('#regionM').on('change', function() {

        $('#loadingModal').modal('show');

        container = $('#provinceM');

        var selectedValue = $(this).val();

        if (selectedValue != '') {
            getAddressDetail(container, 'province', selectedValue, '', 'individual');
        } 

        $('#loadingModal').modal('hide');
    });

    $('#provinceM').on('change', function() {

        $('#loadingModal').modal('show');

        container = $('#cityM');

        var selectedValue = $(this).val();

        if (selectedValue != '') {
            getAddressDetail(container, 'city_town', selectedValue, '', 'individual');
        } 

        $('#loadingModal').modal('hide');
    });

    // $('#cityM').on('change', function() {

    //     $('#loadingModal').modal('show');

    //     container = $('#brgyM');

    //     var selectedValue = $(this).val();

    //     if (selectedValue != '') {
    //         getAddressDetail(container, 'area', selectedValue, '', 'individual');
    //     } 

    //     $('#loadingModal').modal('hide');
    // });


    // Image Handling
    $('.btn-upd').on('click', function(){
        switch(this.id)
        {
            case 'profilePhoto_btn':
                $('#profilePhoto').trigger('click');
            break;
            case 'banner_btn':
                $('#bannerUpd').trigger('click');
            break;
        }
    });

    $('#profilePhoto').on('change', function() {
        // var selectedFile = $(this).prop('files')[0];
        var selectedFile = $(this);

        if (selectedFile) {
            processImage(selectedFile, 'profile');
        }
      });

      $('#bannerUpd').on('change', function() {
        // var selectedFile = $(this).prop('files')[0];
        var selectedFile = $(this);

        if (selectedFile) {
            processImage($('#bannerUpd'), 'banner');
        }
      });
    //   END Image Handling


    $('#frm-user-account').on('submit', function(e){
        e.preventDefault();

        clearErrors();
        validateAndSave($(this));
    });

    $('input').prop('disabled', true);
    $('select').prop('disabled', true);
    $('form button').prop('disabled', true);
    $('form button').hide();
    $('.removeX').hide();
    $('#web').hide();
    $('#clientName').hide();
    $('#award').closest('.row').hide();
    $('*').off('click');


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


