function setTagsWithSelection($container, $type, $eID)
{
    return new Promise((resolve) => {
        $.ajax({
            url: '/shd/svc/get-tags-selection',
            type: 'POST',
            data: {
                type: $type,
                eID: $eID
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
                    const selectedTags = response.tags;
                    // console.log(response.tags);

                    $.each(response.cats, function(category, items) {
                        const optgroup = $('<optgroup>', {
                            label: category.toUpperCase()
                        });

                        $.each(items, function(index, item) {
                            const optionValue = category + "||" + item.name;
                            
                            const isSelected = selectedTags.includes(item.name);

                            optgroup.append(
                                $('<option>', {
                                    value: optionValue,
                                    selected: isSelected
                                }).text(item.name)
                            );
                        });

                        $container.append(optgroup);
                    });
                    
                    $container.trigger('change');
                }
                else
                {
                    alert('Error: Please contact System Administrator.');
                    // console.log(response);
                }

                resolve();
            },
            error: function(xhr, status, error) {

                alert('Error: Please contact System Administrator.');
                // console.log(xhr.responseText);
                reject(new Error(xhr.responseText));
            },
            complete: function() {
            }
        });

    });
    


}
