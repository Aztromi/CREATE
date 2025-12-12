
function setCountries($addrSet)
{
    if($addrSet == 'main')
    {
        $container = $('#country');
    }
    else if($addrSet == 'company')
    {
        $container = $('#co_country');
    }

    $.ajax({
        url: '/shd/svc/get-countries',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        xhrFields: {
            withCredentials: true
        },
        beforeSend: function() {
        },
        success: function(response) {
            
            if(response.validated)
            {
                $container.prop('disabled', false);
                $container.empty();

                var newOption = $('<option>', {
                    value: '',
                    text: 'Select Country'
                });
                $container.append(newOption);
                
                
                $.each(response.countriesList, function(index, option) {
                    // check = false;
                    // if(option == $checkedVal)
                    // {
                    //     check = true
                    // }
                    var newOption = $('<option>', {
                        value: option,
                        text: option
                        // selected: check
                    });
                    $container.append(newOption);
                });

                $container.select2();
                
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

            return;

            
        },
        complete: function() {
        }
    });


}


// START AddressLogic

function addressReset($addrSet, $country, $regionContainer)
{
    // $addrSet: main=User_Address, company=Representaion_Address
    if($addrSet == 'main')
    {
        $addrLocal = '#addrLocal';
        $addrIntl = '#addrIntl';

        $addr1 = '#addr1';
        $zip = '#zip';
        
    }
    else if($addrSet == 'company')
    {
        $addrLocal = '#co_addrLocal';
        $addrIntl = '#co_addrIntl';

        $addr1 = '#co_addr1';
        $zip = '#co_zip';
    }

    

    if($country == 'Philippines')
    {
        $($addrLocal + ' select').prop('disabled', true);
        $($addrLocal + ' select').prop('required', true);
        $($addrLocal + ' select').each(function() {
            $(this).html('<option value="">-</option>');
            // $(this).empty();
        });
        $($addrLocal + ' .error-message').text('');

        $($addrIntl + ' input').prop('disabled', true);
        $($addrIntl + ' input').prop('required', false);
        $($addrIntl + ' input').val('');
        $($addrIntl + ' .error-message').text('');

        $($addrLocal).show();
        $($addrIntl).hide();

        setLocalAddressDetails($addrSet, 'region', $country, $regionContainer);
    }
    else
    {
        $($addrLocal + ' select').prop('disabled', true);
        $($addrLocal + ' select').prop('required', false);
        $($addrLocal + ' select').each(function() {
            $(this).html('<option value="">-</option>');
            // $(this).empty();
        });
        $($addrLocal + ' .error-message').text('');

        $($addrIntl + ' input').prop('disabled', false);
        $($addrIntl + ' input').prop('required', true);
        $($addrIntl + ' input').val('');
        $($addrIntl + ' .error-message').text('');

        $($addrLocal).hide();
        $($addrIntl).show();
    }

    $($addr1).val('');
    $($zip).val('');
}

function setLocalAddressDetails($addrSet, $type, $searchVal, $container)
{
    if(!$searchVal)
    {
        return;   
    }

    $.ajax({
        url: '/shd/svc/get-address-detail',
        type: 'POST',
        data: {
            type: $type,
            value: $searchVal
        },
        xhrFields: {
            withCredentials: true
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
        },
        success: function(response) {
            
            if(response.validated)
            {
                $container.prop('disabled', false);
                $container.empty();

                var newOption = $('<option>', {
                    value: '',
                    text: 'Select One'
                });
                $container.append(newOption);
                
                
                $.each(response.addrList, function(index, option) {
                    check = false;
                    if(option == $searchVal)
                    {
                        check = true
                    }
                    var newOption = $('<option>', {
                        value: option,
                        text: option,
                        selected: check
                    });
                    $container.append(newOption);
                });

                $container.select2();
                
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

            return;

            
        },
        complete: function() {

        }
    });

    if($addrSet == 'main')
    {
        $region = '#regionM';
        $province = '#provinceM';
        $city = '#cityM';
        $addr1 = '#addr1';
        zip = '#zip';
    }
    else if($addrSet == 'company')
    {
        $region = '#co_regionM';
        $province = '#co_provinceM';
        $city = '#co_cityM';
        $addr1 = '#co_addr1';
        zip = '#co_zip';
    }



    switch($type)
    {
        case 'region':
            $($province).prop('disabled', true);
            $($city).prop('disabled', true);

            $($province).empty();
            $($province).html('<option value="">-</option>');
            $($city).empty();
            $($city).html('<option value="">-</option>');

            $($province).select2();
            $($city).select2();
        break;
        case 'province':
            $($city).prop('disabled', true);
            $($city).empty();
            $($city).html('<option value="">-</option>');

            $($city).select2();
        break;
    }

    $($addr1).val('');
    $($zip).val('');

}



// function setSavedAddress($addrSet, $regionVal, $provinceVal, $cityVal)
// {
//     if($addrSet == 'main')
//     {
//         $cRegion = $('#regionM');
//         $cProvince = $('#provinceM');
//         $cCity = $('#cityM');
//     }
//     else if($addrSet == 'company')
//     {
//         $cRegion = $('#co_regionM');
//         $cProvince = $('#co_provinceM');
//         $cCity = $('#co_cityM');
//     }
//     setLocalAddressDetails($addrSet, $type, $searchVal, $container)
// }



// END AddressLogic




function setCountries2($addrSet, $loading)
{
    if($loading){
        $('#loadingModal').modal('show');
    }

    return new Promise((resolve, reject) => {

        if($addrSet == 'main')
        {
            $container = $('#country');
        }
        else if($addrSet == 'company')
        {
            $container = $('#co_country');
        }

        $.ajax({
            url: '/shd/svc/get-countries',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            xhrFields: {
                withCredentials: true
            },
            beforeSend: function() {
            },
            success: function(response) {
                
                if(response.validated)
                {
                    $container.prop('disabled', false);
                    $container.empty();

                    var newOption = $('<option>', {
                        value: '',
                        text: 'Select Country'
                    });
                    $container.append(newOption);
                    
                    
                    $.each(response.countriesList, function(index, option) {
                        // check = false;
                        // if(option == $checkedVal)
                        // {
                        //     check = true
                        // }
                        var newOption = $('<option>', {
                            value: option,
                            text: option
                            // selected: check
                        });
                        $container.append(newOption);
                    });

                    $container.select2();
                    resolve();
                }
                else
                {
                    alert('Error: Please contact System Administrator.');
                    // console.log(response);
                    reject(new Error(response));
                }
            },
            error: function(xhr, status, error) {

                alert('Error: Please contact System Administrator.');
                // console.log(xhr.responseText);
                reject(new Error(xhr.responseText));
            },
            complete: function() {
                if($loading){
                    $('#loadingModal').modal('hide');
                }
            }
        });
    });

}


// START AddressLogic

async function addressReset2($addrSet, $country, $regionContainer, $loading)
{
    if($loading){
        $('#loadingModal').modal('show');
    }

    // $addrSet: main=User_Address, company=Representaion_Address
    if($addrSet == 'main')
    {
        $addrLocal = '#addrLocal';
        $addrIntl = '#addrIntl';

        $addr1 = '#addr1';
        $zip = '#zip';
        
    }
    else if($addrSet == 'company')
    {
        $addrLocal = '#co_addrLocal';
        $addrIntl = '#co_addrIntl';

        $addr1 = '#co_addr1';
        $zip = '#co_zip';
    }

    

    if($country == 'Philippines')
    {
        $($addrLocal + ' select').prop('disabled', true);
        $($addrLocal + ' select').prop('required', true);
        $($addrLocal + ' select').each(function() {
            $(this).html('<option value="">-</option>');
            // $(this).empty();
        });
        $($addrLocal + ' .error-message').text('');

        $($addrIntl + ' input').prop('disabled', true);
        $($addrIntl + ' input').prop('required', false);
        $($addrIntl + ' input').val('');
        $($addrIntl + ' .error-message').text('');

        $($addrLocal).show();
        $($addrIntl).hide();

        try {
            await setLocalAddressDetails2($addrSet, 'region', $country, $regionContainer, false);
        } catch (error) {
            if($loading){
                $('#loadingModal').modal('hide');
            }
        }
        
    }
    else
    {
        $($addrLocal + ' select').prop('disabled', true);
        $($addrLocal + ' select').prop('required', false);
        $($addrLocal + ' select').each(function() {
            $(this).html('<option value="">-</option>');
            // $(this).empty();
        });
        $($addrLocal + ' .error-message').text('');

        $($addrIntl + ' input').prop('disabled', false);
        $($addrIntl + ' input').prop('required', true);
        $($addrIntl + ' input').val('');
        $($addrIntl + ' .error-message').text('');

        $($addrLocal).hide();
        $($addrIntl).show();
    }

    $($addr1).val('');
    $($zip).val('');

    if($loading){
        $('#loadingModal').modal('hide');
    }

}

function setLocalAddressDetails2($addrSet, $type, $searchVal, $container, $loading)
{
    if($loading){
        $('#loadingModal').modal('show');
    }

    return new Promise((resolve, reject) => {
        if(!$searchVal)
        {
            resolve();
            return;   
        }
    
        
        $.ajax({
            url: '/shd/svc/get-address-detail',
            type: 'POST',
            data: {
                type: $type,
                value: $searchVal
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            xhrFields: {
                withCredentials: true
            },
            beforeSend: function() {
            },
            success: function(response) {
                
                if(response.validated)
                {
                    $container.prop('disabled', false);
                    $container.empty();
    
                    var newOption = $('<option>', {
                        value: '',
                        text: 'Select One'
                    });
                    $container.append(newOption);
                    
                    
                    $.each(response.addrList, function(index, option) {
                        check = false;
                        if(option == $searchVal)
                        {
                            check = true
                        }
                        var newOption = $('<option>', {
                            value: option,
                            text: option,
                            selected: check
                        });
                        $container.append(newOption);
                    });
                    $container.select2();
                    resolve();
                }
                else
                {
                    alert('Error: Please contact System Administrator.');
                    // console.log(response);
                    reject(new Error(response));
                }
            },
            error: function(xhr, status, error) {
                alert('Error: Please contact System Administrator.');
                // console.log(xhr.responseText);
                reject(new Error(xhr.responseText));
            },
            complete: function() {
    
            }
        });

    }).then(() => {
        let $region, $province, $city, $addr1, $zip;
        if($addrSet == 'main')
        {
            $region = '#regionM';
            $province = '#provinceM';
            $city = '#cityM';
            $addr1 = '#addr1';
            zip = '#zip';
        }
        else if($addrSet == 'company')
        {
            $region = '#co_regionM';
            $province = '#co_provinceM';
            $city = '#co_cityM';
            $addr1 = '#co_addr1';
            zip = '#co_zip';
        }
        
        switch($type)
        {
            case 'region':
                $($province).prop('disabled', true);
                $($city).prop('disabled', true);
    
                $($province).empty();
                $($province).html('<option value="">-</option>');
                $($city).empty();
                $($city).html('<option value="">-</option>');
    
                $($province).select2();
                $($city).select2();
            break;
            case 'province':
                $($city).prop('disabled', true);
                $($city).empty();
                $($city).html('<option value="">-</option>');
    
                $($city).select2();
            break;
        }
    
        $($addr1).val('');
        $($zip).val('');

        if($loading){
            
            $('#loadingModal').modal('hide');
        }
    });
}