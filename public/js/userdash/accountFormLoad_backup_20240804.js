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


// Other Category Modal
function prepOthModal($type, $modal)
{
    $('#otherCategoryModal .error-message').text('');
    if($type == 'int')
    {
        $('#otherCategoryModal').find('h3').html("Other Sectors of Interest");
        $('label[for="othMainCat"]').text("Interest Category");
        $('label[for="othNew"]').text("Interest");

    }
    else if($type == 'exp')
    {
        $('#otherCategoryModal').find('h3').html("Other Expertise");
        $('label[for="othMainCat"]').text("Expertise Category");
        $('label[for="othNew"]').text("Expertise");

    }
    else if($type == 'main')
    {
        $('#otherCategoryModal').find('h3').html("Other Creative Service Offered");
        $('label[for="othMainCat"]').text("Creative Service Category");
        $('label[for="othNew"]').text("Creative Service");
    }

    $('#oth').val($type);

    $('#othMainCat').val('').trigger('change');
    $('#othNew').val('');

    $($modal).show();
}


function prepForm()
{
    $('#m_text').hide();

    $('#m_others').change(function(){
        if($(this).is(':checked')) {
            $('#m_text').show();
            $('#m_text').prop('disabled', false);
            $('#m_text').prop('required', true);
        } else {
            $('#m_text').hide();
            $('#m_text').prop('disabled', true);
            $('#m_text').prop('required', false);
        }
        $('#m_text').val('');
    });

    

    // ADDRESS
        

        $('#country').on('change', function(){
            $('#loadingModal').modal('show');
            addressReset('main', $(this).val(), $('#regionM'));
            $('#loadingModal').modal('hide');
        });
    
        $('#regionM').on('change', function(){
            $('#loadingModal').modal('show');
            setLocalAddressDetails('main', 'province', $(this).val(), $('#provinceM'));
            $('#loadingModal').modal('hide');
        });
    
        $('#provinceM').on('change', function(){
            $('#loadingModal').modal('show');
            setLocalAddressDetails('main', 'city_town', $(this).val(), $('#cityM'));
            $('#loadingModal').modal('hide');
        });

        setTimeout(() => {
            setCountries('main');    
        }, 200);


        
        

        $('#co_country').on('change', function(){
            $('#loadingModal').modal('show');
            addressReset('company', $(this).val(), $('#co_regionM'));
            $('#loadingModal').modal('hide');
        });
    
        $('#co_regionM').on('change', function(){
            $('#loadingModal').modal('show');
            setLocalAddressDetails('company', 'province', $(this).val(), $('#co_provinceM'));
            $('#loadingModal').modal('hide');
        });
    
        $('#co_provinceM').on('change', function(){
            $('#loadingModal').modal('show');
            setLocalAddressDetails('company', 'city_town', $(this).val(), $('#co_cityM'));
            $('#loadingModal').modal('hide');
        });

        setTimeout(() => {
            setCountries('company');    
        }, 400);

        $('#country').val('').trigger('change');
        $('#co_country').val('').trigger('change');

    // END ADDRESS

    


    // REPRESENTATION

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

    // END REPRESENTATION


    // Websites
        $('#webAdd').on('click', function(e){
                        
                        
            var web = $('#web').val().trim();

            var urlRegex = /^(https?:\/\/)?([\w-]+\.+[\w-]+)+([\w.,@?^=%&:/~+#-]*[\w@?^=%&/~+#-])?$/;

            if(web != "")
            {
                if(web.length >150)
                {
                    $('#webArr-error').html('Exceeded allowed number of characters. Try again.');
                }
                else if(!(urlRegex.test(web) && (web.startsWith("http://") || web.startsWith("https://")))){
                    $('#webArr-error').html('Value must be a valid website (https://...). Try again.');
                }
                else
                {
                    if($('#webList').is(':hidden'))
                    {
                        $('#webList').show();
                    }

                    $('#webArr-error').html('');
                    $('#webList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td>' + web + '</td></tr>');
                    $('#web').val('');

                    $('#webList').on('click', '.removeX', function(){
                        $(this).closest("tr").remove();
                        if($('#webList tr').length == 1)
                        {
                            $('#webList').hide();
                        }
                    });
                }
                

                $('#web').focus();
            }
        });
    //END  Websites


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

    // Categories
        setCategories($('#interests'), 'multiple');
        setCategories($('#expertises'), 'multiple');
        setCategories($('#main-expertise'), 'single');
    // END Categories


    // Other Categories
        setCategories($('#othMainCat'), 'single');

        $('#btnOthInt').on('click', function(e){
            e.preventDefault();

            prepOthModal('int', '#otherCategoryModal');
        });
        $('#btnOthExp').on('click', function(e){
            e.preventDefault();

            prepOthModal('exp', '#otherCategoryModal');
        });

        $('#btnOthMainExp').on('click', function(e){
            e.preventDefault();

            prepOthModal('main', '#otherCategoryModal');
        });

        $('#btnOthCancel').on('click', function(e){
            e.preventDefault();

            $('#otherCategoryModal').hide();
        });

        $('#btnOthAdd').on('click', function(e){
            e.preventDefault();
    
            $check = true;
            $('#otherCategoryModal .error-message').text('');
    
            if($('#othMainCat').val().trim().length == 0)
            {
                $check = false;
                $('#othMainCat').siblings('.error-message').text('Required Field');
            }
    
            if($('#othNew').val().trim().length == 0)
            {
                $check = false;
                $('#othNew').siblings('.error-message').text('Required Field');
            }
    
            if(!$check)
            {return;}
    
            $newText = $('#othNew').val().trim().replace(/(?:^|\s)\w/g, function(match) {
                return match.toUpperCase();
            });
            $newVal = 'other|745|' + $('#othMainCat').val() + '|745|' + $newText;
            
            
            if($('#oth').val() == 'int')
            {   
                var $newOption = $('<option>').val($newVal).text($newText);
                // $('#expertises').find('#othGroup').append($newOption);
                $('#interests optgroup[label=Others]').append($newOption);
    
                $('#interests').val($newVal).trigger('change');
            }
            else if($('#oth').val() == 'exp')
            {   
                var $newOption = $('<option>').val($newVal).text($newText);
                // $('#expertises').find('#othGroup').append($newOption);
                $('#expertises optgroup[label=Others]').append($newOption);
    
                $('#expertises').val($newVal).trigger('change');
            }
            else if($('#oth').val() == 'main')
            {   
                var $newOption = $('<option>').val($newVal).text($newText);
                // $('#main-expertise').find('#othGroup').append($newOption);
                $('#main-expertise optgroup[label=Others]').append($newOption);
    
                $('#main-expertise').val($newVal).trigger('change');
            }
    
            $('#otherCategoryModal').hide();
        });


    // END Other Categories


    // Clients
        $('#clientAdd').on('click', function(e){
                        
                        
            var client = $('#clientName').val().trim();

            if(client != "")
            {
                if(client.length >150)
                {
                    $('#clientsArr-error').html('Exceeded allowed number of characters. Try again.');
                }
                else
                {
                    if($('#clientsList').is(':hidden'))
                    {
                        $('#clientsList').show();
                    }

                    $('#clientsArr-error').html('');
                    $('#clientsList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td>' + client + '</td></tr>');
                    $('#clientName').val('');

                    $('#clientsList').on('click', '.removeX', function(){
                        $(this).closest("tr").remove();
                        if($('#clientsList tr').length == 1)
                        {
                            $('#clientsList').hide();
                        }
                    });
                }
                

                $('#clientName').focus();
            }
        });
    // END Clients


    // Awards
        $('#awardAdd').on('click', function(e){

            $('#awardsArr-error').html('');
            
            var name = $('#award').val().trim();
            var source = $('#presenter').val().trim();
            var year = $('#presentYear').val().trim();

            
            if(name == "" || source == "" || year == "")
            {
                $('#awardsArr-error').html('Please fill all Awards/Recognition Fields');
            }
            else if(name.length > 150 || source.length > 150 || year.length > 150)
            {
                $('#awardsArr-error').html('Exceeded allowed number of characters. Try again.');
            }
            else if(!($.isNumeric(year) && year.length === 4))
            {
                $('#awardsArr-error').html('Year Given must be a valid Year value.');
            }
            else
            {
                if($('#awardsList').is(':hidden'))
                {
                    $('#awardsList').show();
                }

                $('#awardsArr-error').html('');
                $('#awardsList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td>' + name + '</td><td>' + source + '</td><td>' + year + '</td></tr>');
                $('#award').val('');
                $('#presenter').val('');
                $('#presentYear').val('');

                $('#awardsList').on('click', '.removeX', function(){
                    $(this).closest("tr").remove();
                    if($('#awardsList tr').length == 1)
                    {
                        $('#awardsList').hide();
                    }
                });

                $('#award').focus();
            }
            
        });
    // END Awards

    getData();
}

function getData()
{
    // $.ajax({
    //     url: "{{ route('user.register.step-three.data') }}",
    //     type: 'POST',
    //     dataType: 'json',
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     success: function(response) {


    //     },
    //     error: function(xhr, status, error) {
    //         console.error(xhr.responseText);
    //     }
    // });
    
}
function clearErrors(){
    $('.error-message').text('');
}



function initializeAll(){

}.then();