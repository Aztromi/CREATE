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


    
    var formData = new FormData(form);

    $.ajax({
        // url: form.attr('action'),
        url: form.action,
        type: 'POST',
        // data: form.serialize(),
        data: formData,
        processData: false, // Don't process the files
        contentType: false, // Set the content type to false as jQuery will tell the server it's a query string request
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
        },
        success: function(response) {
            
            if(response.validated)
            {
                // window.location.href = response.URLRedirect;
                if ($('#profile-photo-change').length) {
                    $('#profile-photo-change').val('');
                }

                if ($('#masthead-change').length) {
                    $('#masthead-change').val('');
                }

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
            else if (xhr.status === 419)
            {
                    window.location.href = '/login';
            }
            else
            {
                //Possible No DB Connection

                // console.log('Error: ' + xhr.responseText);
                alert('Error: Please contact System Administrator.');
            }

            
        },
        complete: function() {
            $('#loadingModal').modal('hide');
        }
    });
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


async function prepForm()
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
        await setCountries2('main', false);
        await setCountries2('company', false);  
    // END ADDRESS



    // Brief Description
        $('.brief-desc textarea').on().on('input', function(){
            setTACharacterCount($(this), parseInt($(this).attr('maxlength'), 10));
        });
    // END Brief Description

    


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
                    $('#webList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td><a href="' + web + '" target="_blank" rel="noopener noreferrer">' + web + '</a></td></tr>');
                    
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
        await setCategories2($('#interests'), 'multiple');
        await setCategories2($('#expertises'), 'multiple');
        await setCategories2($('#main-expertise'), 'single');
    // END Categories


    // Other Categories
        await setCategories2($('#othMainCat'), 'single');

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

}

function setTACharacterCount(container, maxLength) {
    $charCount = container.val().length;
            
    $('.brief-desc .taCounter').text($charCount + '/' + maxLength);
}

function getData()
{
    var deferred = $.Deferred();

    $.ajax({
        url: "/shd/profile/get-account-data",
        type: 'POST',
        dataType: 'json',
        data: {
            'uID': $('#uID').val()
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            deferred.resolve(response);
        },
        error: function(xhr, status, error) {
            deferred.reject(xhr.responseText);
            // console.error(xhr.responseText);
        }
    });

    return deferred.promise();
    
}

function setEleVal(selector, value, type){
    switch(type){
        case 'val':
            $(selector).val( value || '');
        break;
        case 'text':
            $(selector).text( value || '');
        break;
        case 'html':
            $(selector).html( value || '');
        break;
    }
}

function dateFormatted($rawDate)
{
    var date = new Date($rawDate);
    
    var options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric', 
        hour: 'numeric', 
        minute: 'numeric', 
        hour12: true 
    };
    var formattedDateTime = date.toLocaleString('en-US', options);

    return formattedDateTime;
}

// function assignImage(fileURL, fileName, container) {
//     // Create a new DataTransfer object
//     var dataTransfer = new DataTransfer();
    
//     // Create a new file object
//     var file = new File([fileUrl], fileName, { type: 'image' });

//     // Add the file to DataTransfer
//     dataTransfer.items.add(file);

//     // Get the file input element
//     var input = document.getElementById(container);
    
//     // Set the file input's files property
//     input.files = dataTransfer.files;

//     // Reinitialize Dropify to reflect the new file
//     $('.dropify').dropify('destroy').dropify();
// }

async function setData(data){
    // console.log(data);
    
    $verified = '-';
    switch(data.user.verified){
        case -1:
            $verified = 'Member';
            break;
        case 0:
            $verified = 'Unverified';
            break;
        case 1:
            $verified = 'Verified';
            break;
    }

    $('#lbl-verified').text($verified);

    setEleVal('#fname', data.first_name || '', 'val');
    setEleVal('#lname', data.last_name || '', 'val');
    setEleVal('#gender', data.gender || '', 'val');
    setEleVal('#briefDesc', data.about || '', 'val');
    setEleVal('#email', data.user.email || '', 'val');

    if (Array.isArray(data.emails) && data.emails.length > 0) {
        $.each(data.emails, function(index, email) {
            if(email.value != data.user.email){
                setEleVal('#email-alternate', email.value, 'val');
                return;
            }
        });
    }

    if (Array.isArray(data.num_contact_types) && data.num_contact_types.length > 0) {
        $.each(data.num_contact_types, function(index, cTypes) {
            if(cTypes.type == 'primary'){
                switch(cTypes.value){
                    case 'Viber':
                        $('#m_viber').prop('checked', true);
                    break;
                    case 'Whatsapp':
                        $('#m_whatsapp').prop('checked', true);
                    break;
                }
            }
            else if(cTypes.type == 'other' && cTypes.value){
                $('#m_others').prop('checked', true);
                $('#m_text').show();
                setEleVal('#m_text', cTypes.value, 'val');
            }
        });
    }
    
    if (Array.isArray(data.num_contacts) && data.num_contacts.length > 0) {
        $.each(data.num_contacts, function(index, contacts) {
            switch(contacts.type){
                case 'primary':
                    setEleVal('#mobile', contacts.number, 'val');
                break;
                case 'alternate':
                    setEleVal('#mobile-alternate', contacts.number, 'val');
                break;
                case 'landline':
                    setEleVal('#telephone', contacts.number, 'val');
                break;
            }
        });
    }

    // ADDRESS
    if(data.address_latest){
        $tmpCountry = data.address_latest.country || '';
        if($tmpCountry == 'Philippines'){
            $('#country').val($tmpCountry).trigger('change.select2');
            await addressReset2('main', $tmpCountry, $('#regionM'), false);
            
            $('#regionM').val(data.address_latest.region).trigger('change.select2');
            await setLocalAddressDetails2('main', 'province', data.address_latest.region, $('#provinceM'), false);
            
            $('#provinceM').val(data.address_latest.province).trigger('change.select2');
            await setLocalAddressDetails2('main', 'city_town', data.address_latest.province, $('#cityM'), false);
            
            $('#cityM').val(data.address_latest.municipality).trigger('change.select2');
            setEleVal('#addr1', data.address_latest.block_lot, 'val');
            setEleVal('#zip', data.address_latest.postal_code, 'val');
        }
        else{
            $('#country').val($tmpCountry).trigger('change.select2');
            await addressReset2('main', $tmpCountry, $('#regionM'), false);

            setEleVal('#regionI', data.address_latest.region, 'val');
            setEleVal('#cityI', data.address_latest.municipality, 'val');
            setEleVal('#addr1', data.address_latest.block_lot, 'val');
            setEleVal('#zip', data.address_latest.postal_code, 'val');
        }
    }
    else{
        await addressReset2('main', '', $('#regionM'), false);
    }

    $('#country').on('change', async function(){
        await addressReset2('main', $(this).val(), $('#regionM'), true);
    });

    $('#regionM').on('change', async function(){
        await setLocalAddressDetails2('main', 'province', $(this).val(), $('#provinceM'), true);
    });

    $('#provinceM').on('change', async function(){
        await setLocalAddressDetails2('main', 'city_town', $(this).val(), $('#cityM'), true);
    });
    // END ADDRESS

    // REPRESENTATION
    if(data.uindie && data.uindie.expertise){
        $('#rep').val(data.uindie.expertise).trigger('change');
    }
    
    if(data.uindie && data.uindie.expertise && data.uindie.expertise !="Individual / Independent / Freelance / Student"){
        setEleVal('#org', data.company.company_name, 'val');

        // CO ADDRESS
        if(data.company && data.company.address_latest)
        {
            $tmpCoCountry = data.company.address_latest.country || '';
            if($tmpCoCountry == 'Philippines'){
                $('#co_country').val($tmpCoCountry).trigger('change.select2');
                await addressReset2('company', $tmpCoCountry, $('#co_regionM'), false);
                
                $('#co_regionM').val(data.company.address_latest.region).trigger('change.select2');
                await setLocalAddressDetails2('company', 'province', data.company.address_latest.region, $('#co_provinceM'), false);
                
                $('#co_provinceM').val(data.company.address_latest.province).trigger('change.select2');

                

                setTimeout(async function () {
                    await setLocalAddressDetails2('company', 'city_town', data.company.address_latest.province, $('#co_cityM'), false);
                    $('#co_cityM').val(data.company.address_latest.municipality).trigger('change.select2');
                    setEleVal('#co_addr1', data.company.address_latest.block_lot, 'val');
                    setEleVal('#co_zip', data.company.address_latest.postal_code, 'val');
                }, 1000);
                
                
                
            }
            else{
                $('#co_country').val($tmpCoCountry).trigger('change.select2');
                await addressReset2('company', $tmpCoCountry, $('#co_regionM'), false);
                
                setEleVal('#co_regionI', data.company.address_latest.region, 'val');
                setEleVal('#co_cityI', data.company.address_latest.municipality, 'val');
                setEleVal('#co_addr1', data.company.address_latest.block_lot, 'val');
                setEleVal('#co_zip', data.company.address_latest.postal_code, 'val');
            }
        }
        else{
            await addressReset2('company', '', $('#co_regionM'), false);
        }
        // END CO ADDRESS

        // COMPANY SIZE
            setEleVal('#co_size', data.company.company_size, 'val');
            setEleVal('#co_direct', data.company.company_direct_workers, 'val');
            setEleVal('#co_indirect', data.company.company_indirect_workers, 'val');
        // END COMPANY SIZE

        // REPRESENTATIVE
            setEleVal('#rep_fname', data.company.rep_fname, 'val');
            setEleVal('#rep_lname', data.company.rep_lname, 'val');
            setEleVal('#rep_gender', data.company.rep_gender, 'val');
            setEleVal('#rep_email', data.company.rep_email, 'val');
            setEleVal('#rep_mobile', data.company.rep_mobile, 'val');
        // END REPRESENTATIVE

        // JOBS
        if (Array.isArray(data.job_titles) && data.job_titles.length > 0) {
            if($('#jobsList').is(':hidden')){
                $('#jobsList').show();
            }

            $.each(data.job_titles, function(index, jobTitle) {
                // console.log("Job Title:", jobTitle.value);
                $('#jobsList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td>' + jobTitle.value + '</td></tr>');
            });
        }
        // END JOBS

        // OWNER
        if(data.company.same_rep_owner == 1){
            $('#same_rep_owner').prop('checked', true).trigger('change');
        }
        else{
            setEleVal('#owner_fname', data.company.owner_fname, 'val');
            setEleVal('#owner_lname', data.company.owner_lname, 'val');
            setEleVal('#owner_gender', data.company.owner_gender, 'val');
            setEleVal('#owner_email', data.company.owner_email, 'val');
        }
        // END OWNER
    }
    
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

    // END REPRESENTATION

    // PRIVACY
    if(data.hide_email){
        $('#hEmail').prop('checked', true);
    }
    if(data.hide_contact){
        $('#hContact').prop('checked', true);
    }
    if(data.hide_address){
        $('#hAddress').prop('checked', true);
    }
    // END PRIVACY

    // SOCIALS
    if (Array.isArray(data.socials) && data.socials.length > 0) {
        $.each(data.socials, function(index, social) {
            switch(social.type){
                case 'Facebook':
                    setEleVal('#facebook', social.value, 'val');
                break;
                case 'Instagram':
                    setEleVal('#instagram', social.value, 'val');
                break;
                case 'Twitter':
                    setEleVal('#twitter', social.value, 'val');
                break;
                case 'Youtube':
                    setEleVal('#youtube', social.value, 'val');
                break;
                case 'Tiktok':
                    setEleVal('#tiktok', social.value, 'val');
                break;
                case 'Behance':
                    setEleVal('#behance', social.value, 'val');
                break;
            }
        });
    }
    // END SOCIALS

    // WEBSITES
    $webAdd = false;
    
    if (Array.isArray(data.websites) && data.websites.length > 0) {
        $.each(data.websites, function(index, web) {
            $webAdd = true;
            if($('#webList').is(':hidden'))
            {
                $('#webList').show();
            }

            $('#webList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td><a href="' + web.value + '" target="_blank" rel="noopener noreferrer">' + web.value + '</a></td></tr>');
        });
    }

    if($webAdd){
        $('#webList').on('click', '.removeX', function(){
            $(this).closest("tr").remove();
            if($('#webList tr').length == 1)
            {
                $('#webList').hide();
            }
        });
    }
    // END WEBSITES

    // DISPLAY NAME
    if(data.display_name)
    {
        switch(data.display_name)
        {
            case 'company_name':
                $('input[name="dispName"]#nameRadioCompany').prop('checked', true);
            break;
            case 'fullname':
                $('input[name="dispName"]#nameRadioFull').prop('checked', true);
            break;
            case 'other_name':
                $('input[name="dispName"]#nameRadioOther').prop('checked', true);

                $('#name-other').prop('hidden', false);
                $('#name-other').prop('disabled', false);
                $('#name-other').prop('required', true);
                $('#name-other').val(data.other_name);
            break;
        }
    }
    // END DISPLAY NAME

    // INTERESTS / SECTORS
    if (Array.isArray(data.sectors) && data.sectors.length > 0) {
        $intList = [];

        $.each(data.sectors, function(index, interest) {
            $intList.push(interest.list_state + "|745|" + interest.category +"|745|"+ interest.value);
        });

        $('#interests').val($intList).trigger('change'); 
    }
    // END INTERESTS

    // EXPERTISE
    if (data.uindie && data.uindie.expertises && Array.isArray(data.uindie.expertises) && data.uindie.expertises.length > 0) {
        $expList = [];
        $main_exp = '';

        $.each(data.uindie.expertises, function(index, expertise) {
            if(expertise.type == 'expertise')
            {
                $expList.push(expertise.list_state + "|745|" + expertise.category +"|745|"+ expertise.value);
            }
            else if(expertise.type == 'main')
            {
                $main_exp = expertise.list_state + "|745|" + expertise.category + "|745|" + expertise.value;
            }
        });

        $('#expertises').val($expList).trigger('change'); 
        $('#main-expertise').val($main_exp).trigger('change');
    }
    // END EXPERTISE

    // CLIENTS
    $clientAdd = false;
    if (data.uindie && data.uindie.clients && Array.isArray(data.uindie.clients) && data.uindie.clients.length > 0) {
        $.each(data.uindie.clients, function(index, client) {
            $clientAdd = true;
            if($('#clientsList').is(':hidden'))
            {
                $('#clientsList').show();
            }
            
            $('#clientsList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td>' + client.name + '</td></tr>');
        });
    }

    if($clientAdd){
        $('#clientsList').on('click', '.removeX', function(){
            $(this).closest("tr").remove();
            if($('#clientsList tr').length == 1)
            {
                $('#clientsList').hide();
            }
        });
    }
    // END CLIENTS

    // AWARDS
    $awardAdd = false;
    if (Array.isArray(data.awards) && data.awards.length > 0) {
        $.each(data.awards, function(index, award) {
            if($('#awardsList').is(':hidden'))
            {
                $('#awardsList').show();
            }
            
            $('#awardsList').append('<tr><td><i class="fa fa-close removeX pr-1"></i></td><td>' + award.name + '</td><td>' + award.source + '</td><td>' + award.year + '</td></tr>');
        });
    }

    if($awardAdd){
        $('#awardsList').on('click', '.removeX', function(){
            $(this).closest("tr").remove();
            if($('#awardsList tr').length == 1)
            {
                $('#awardsList').hide();
            }
        });
    }
    // END AWARDS

    // DOC WORKS DRIVE
    if(data.upload_drive_link){
        setEleVal('#driveLink', '<a href="' + data.upload_drive_link + '" target="_blank" rel="noopener noreferrer">' + data.upload_drive_link + '</a><br><small>' + dateFormatted(data.upload_drive_date) + '</small>', 'html');

    }
    // END DOC WORKS DRIVE

    // UPLOADS
    if(data.user.uploaded_requirements){
        $.each(data.user.uploaded_requirements, function(index, upload) {
            switch(upload.type){
                case 'portfolio':
                    if($('#portfolioList').is(':hidden'))
                    {
                        $('#portfolioList').show();
                    }
                    
                    $('#portfolioList').append('<tr><td><a href="/folder_requirements/' + data.user.id + '/requirements/' + upload.file + '" target="_blank" rel="noopener noreferrer">' + upload.file + '</a></td><td>' + dateFormatted(upload.created_at) + '</td></tr>');
                break;
                case 'goverment-document':
                    if($('#govDocList').is(':hidden'))
                    {
                        $('#govDocList').show();
                    }
                    
                    $('#govDocList').append('<tr><td><a href="/folder_requirements/' + data.user.id + '/requirements/' + upload.file + '" target="_blank" rel="noopener noreferrer">' + upload.file + '</a></td><td>' + dateFormatted(upload.created_at) + '</td></tr>');
                break;
                case 'bir-document':
                    if($('#birList').is(':hidden'))
                    {
                        $('#birList').show();
                    }
                    
                    $('#birList').append('<tr><td><a href="/folder_requirements/' + data.user.id + '/requirements/' + upload.file + '" target="_blank" rel="noopener noreferrer">' + upload.file + '</a></td><td>' + dateFormatted(upload.created_at) + '</td></tr>');
                break;
            }

        });

    }
    // END UPLOADS
    

}

function clearErrors(){
    $('.error-message').text('');
}


function firstInit(){
    var deferred = $.Deferred();

    $("#loadingModal").modal({ 
        backdrop: "static", 
        keyboard: false, 
    }); 

    $("#otherCategoryModal").modal({ 
        backdrop: "static", 
        keyboard: false, 
    });

    // In case. Modal Background Transparent 
    $('.modal').css('--bs-modal-bg', 'transparent');

    $('#loadingModal').modal('show');

    $('.select2').select2();

    deferred.resolve();

    return deferred.promise();
}



function initializeAll(){
    $(document).on('keydown', function(event) {
        if ($(event.target).is('.brief-desc textarea')) {
            return;
        }
        if (event.key === 'Enter' || event.keyCode === 13) {
            event.preventDefault();
        }
    });

    $('#frm-user-account').on('submit', function(e){
        if (!this.checkValidity()) {
            return;
        }
        e.preventDefault();

        validateAndSave(this);
    });
    
    firstInit()
        .then(function(){
            return prepForm();
        })
        .then(function(){
            return getData();
        })
        .then(async function(data){
            await setData(data);
        })
        // .then(function(){
        //          TEST
        //     var deferred = $.Deferred();
        //     setTimeout(() => {
        //         deferred.resolve("Operation succeeded!");
        //     }, 20000);

        //     return deferred.promise();
        // })
        .catch(function(error){
            console.log('Error: ' + error);
        })
        .always(function(){
            $('#main-content').show();
            $('#loadingModal').modal('hide');
        });
}