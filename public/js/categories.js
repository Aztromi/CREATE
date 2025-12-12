function setCategories($container, $selection)
{
    // $selection = single or multiple

    $.ajax({
        url: '/get-categories',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
        },
        success: function(response) {
            
            if(response.validated)
            {
                $container.empty();

                if($selection == 'single')
                {
                    var newOption = $('<option>', {
                        value: '',
                        text: 'Select Category'
                    });
                    $container.append(newOption);
                }

                if($container.is($('#othMainCat')))
                {
                    $.each(response.categoriesList, function(category) {

                        var $newOption = $('<option>').val(category).text(category);

                        $container.append($newOption);
                    });
                }
                else
                {
                    $.each(response.categoriesList, function(category, values) {
                        var optgroup = $('<optgroup>', { 
                            label: category.toUpperCase()
                        });

                        $.each(values, function(index, value) {
                            optgroup.append($('<option>', { 
                                value: 'default|745|' + value.category + '|745|' + value.value 
                            }).text(value.value));
                        });
            
                        $container.append(optgroup);
                    });

                    if($container.is($('#interests')) || $container.is($('#expertises')) || $container.is($('#main-expertise')))
                    {
                        var optgroup = $('<optgroup>', {
                            label: 'Others'
                        });
                        
                        if(response.others)
                        {
                            $.each(response.others, function(index, other) {
                                optgroup.append($('<option>', { 
                                    value: 'other|745|' + other.category + '|745|' + other.value 
                                }).text(other.value));
                            });
                               
                        }

                        $container.append(optgroup);
                    }
                    



                    

                }

                

                if($selection == 'single')
                {
                    if($container.is($('#othMainCat')))
                    {
                        
                        $('#otherCategoryModal .select2').select2({
                            placeholder: 'Select Category',
                            dropdownParent: $('#otherCategoryModal')
                        });    
                    }
                    else
                    {
                        $($container).select2({
                            placeholder: 'Select Category'
                        });
                    }
                }
                else if($selection == 'multiple')
                {
                    $($container).select2({
                        placeholder: 'Select one or many Categories'
                    });    
                }
                
                
            }
            else
            {
                alert('Error: Please contact System Administrator.');
                // console.log(response);
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