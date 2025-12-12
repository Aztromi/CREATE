@section('styles')
    <link rel="stylesheet" href="{{ asset('css/shared/loadingModal-custom.css?ver='.time()) }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

    <style>

        .select2 {
            /* width: 'resolve'; */
            width: 100% !important;
        }

        /* .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            background-color: #3E3E3E;
            border: 0;
            border-radius: 8px;

        } */

        .select2-container .select2-selection--single {
            height: 40px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow,
        .select2-container--default .select2-selection--multiple .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 11px;
            right: 1px;
            width: 30px;
        }

        /* X Button in selected */
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #7aabff;
            padding-right: 2px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #d12f2f;
        }
        /* END X Button in selected */

        .select2-results__group {
            background-color: #a7c7ff;
        }

        
        .select2-container--default .select2-search--inline .select2-search__field {
            color: #000000;
        }

        /* .select2-container--default .select2-selection--single .select2-selection__rendered,
        .select2-container--default .select2-selection--multiple .select2-selection__rendered {

            background-color: #3E3E3E;
            color: #FFFFFF;
            padding: 10px 10px;
            border: 0;
            border-radius: 8px;
            font-size: 1.2em;
            font-weight: 400;
        } */
        
        .select2-selection__choice{ 
            background-color: blue;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #FFFFFF;
        }

        .card {
            overflow-x: auto;
        }

        .card .card-body {
            min-width: 1000px;
        }

        .guest-info .col, .addtnl-details .col {
            margin-top: 20px;
        }

        .request_label {
            display: block;
            width: 100%;
            font-size: 14px;
            font-weight: 400;
            color: #545454ff;
            line-height: 1.2;
            margin-bottom: 3px;
        }

        .request_detail {
            display: block;
            width: 100%;
            font-size: 18px;
            line-height: 1.3;
            font-weight: 400;
            color: #1385baff;
        }

        .requester_type {
            padding: 5px 8px;
            border-radius: 15px;

            font-size: 12px;
            font-weight: bold;
            color: #FFF;
        }

        .requester_type.Admin {
            background-color: #d26512ff;
        }

        .requester_type.Creative {
            background-color: #14bf8eff;
        }

        .requester_type.Member {
            background-color: #1385baff;
        }

        .requester_type.Guest {
            background-color: #8c8c8cff;
        }

        .request_multiple {
            display: inline-block;
            background-color: #31A2F0;
            padding: 5px 10px;
            border-radius: 20px;
            margin-bottom: 6px;

            font-size: 14px;
            font-weight: bold;
            line-height: 1.2;
            text-align: center;
            color: #FFF;

            letter-spacing: 1.5;

        }


        .btn-secondary {
            background-color: transparent !important;
            border: 1px solid transparent !important;
            color: #000000 !important;
        }

        .btn-secondary:hover {
            border: 1px solid #000000 !important;
        }

        .creative-view {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .profile-viewer {
            margin-top: 10px;
            /* border: 1px solid #B5B5B5; */
            padding: 10px;
            border-radius: 20px;
            width: 100%;
            flex-grow: 1;
            overflow-y: auto;

            box-shadow: inset 0 4px 8px rgba(0, 0, 0, 0.1),
              inset 0 -4px 8px rgba(0, 0, 0, 0.05);
        }

        .bg-gray {
            background-color: #B5B5B5 !important;
        }

        .recommended-creatives-container .request_multiple {
            display: inline-flex;       /* shrink-wrap pill */
            align-items: center;        /* vertical align center */
            margin-left: 3px;
            margin-right: 3px;
            max-width: 100%;            /* let it wrap if too long */
            word-break: break-word;     /* wrap text properly */

        }

        .recommended-creatives-container .recommended-creatives {
            margin: 0 auto;
            padding: 10px;
            width: 95%;
            min-height: 50px;
            border-radius: 20px;

            box-shadow: inset 0 4px 8px rgba(0, 0, 0, 0.1),
              inset 0 -4px 8px rgba(0, 0, 0, 0.05);
        }

        .request_multiple > span:first-child {
            white-space: normal;
            overflow-wrap: anywhere;
        }

        .recommended-creatives-container .recommended-creatives .rc_x{
            padding-left: 8px;
            font-size: 18px;
            color: #1173c8ff;

            flex-shrink: 0; 
        }

        .recommended-creatives-container .recommended-creatives .rc_x:hover {
            cursor: pointer;
            color: #0e5088ff;
        }




    </style>
@endsection

@section('scripts-bottom')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/shared/tags.js?ver='.time()) }}"></script>
    <script>

        const request_id = {{ $details->id }};

        $(document).ready(function(){
            $("#loadingModal").modal({ 
                backdrop: "static", 
                keyboard: false, 
            });

            // $('#professional_types').select2({
            //     placeholder: "Select professional types",
            //     allowClear: true
            // });

            // $('#project_goals').select2({
            //     placeholder: "Select professional types",
            //     allowClear: true
            // });

            $("#cField").select2({
                placeholder: 'Select an option'
            });

            $("#creatives").select2({
                placeholder: 'Select an option'
            });
            
            initializeAll();

        });
        
        function setInitial() {
            

            return new Promise((resolve) => {

                $('#loadingModal').modal('show');
                $('#main-content').hide();

                $('.btn-add').hide();

                $('.btn-filter').on('click', function(e){
                    e.preventDefault();

                    $('#loadingModal').modal('show');

                    getCreatives()
                        .then(function(creatives){
                            populateCreatives(creatives);
                        })
                        .catch(function(error){
                            alert(error);
                        })
                        .finally(function(){
                            $('#loadingModal').modal('hide');
                        });

                });

                $('#creatives').on('change', function() {
                    if($(this).val() != "") {
                        updateProfileViewer($('#creatives option:selected').data('id'));

                        $('.btn-add').show();
                    } else {
                        $('.btn-add').hide();
                        $('.profile-viewer').html(`<center>Profile Viewer</center>`);
                    }
                });

                $('.btn-add').on('click', function() {
                    let selectedCreative = $('#creatives option:selected');

                    const id = selectedCreative.data('id');
                    const name = selectedCreative.data('name');

                    $('.recommended-creatives').append('<span class="request_multiple" data-id="' + id + '"><span>' + name + '</span><span class="rc_x">×</span></span>');

                    selectedCreative.remove();
                    $(this).hide();
                });

                $('.recommended-creatives').on('click', '.rc_x', function() {
                    $(this).closest('.request_multiple').remove();
                });

                $('.btn-submit').on('click', function(e) {
                    e.preventDefault();
                    
                    if(getSelectedCreatives().length === 0) {
                        $preSendText = "You are about to send a response without any recommendations. Do you want to continue?";
                        
                    } else {
                        $preSendText = "You are about to send a response with recommendations. Do you want to continue?";
                    }

                    if(confirm($preSendText)) {
                        validateAndSave();
                    }
                });
                
                $('.btn-cancel').on('click', function(){
                    window.location.href = "{{ $details->cancel_link }}";
                });
                
                resolve(true);

            });
        }

        function initializeAll(){
            
            setInitial()
                .then(function(){
                    return setTagsWithSelection($("#cField"), 'connect_creative', '');
                })
                .then(function(){
                    return getCreatives();
                })
                .then(function(creatives){
                    populateCreatives(creatives);
                })
                // .then(function(){
                //     return getData();
                // })
                // .then(function(response){
                //     if (response !== null) {
                //         setData(response);
                //     }
                //     // else {
                //     //     console.log('No data to set.');
                //     // }
                // })
                .catch(function(error){
                    console.log('Error: ' + error);
                })
                .finally(function(){
                    $('#main-content').show();
                    $('#loadingModal').modal('hide');
                });


        }

        function validateAndSave() {
            
            $('#loadingModal').modal('show');
            
            let formData = new FormData();
            formData.append('id', request_id);
            let selected = getSelectedCreatives();
            
            if (selected) {
                selected.forEach(select => formData.append('selects[]', select));
            }

            $.ajax({
                {{-- url: "{{  route('admin.connect-creative.saveRecommendation') }}", --}}
                url: "/admin/connect-with-creatives/response/save-recommendation",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                },
                success: function(response) {
                    
                    if(response.validated) {
                        alert('Response sent.');
                        window.location.href = response.urlRedirect;
                    } else {
                        alert('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.');
                        // console.log(response);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.');
                    // console.log(response);
                },
                complete: function() {
                    $('#loadingModal').modal('hide');
                }
            });
        }

        function getCreatives() {
            return new Promise((resolve, reject) => {
                
                let formData = new FormData();
                let cats = $('#cField').val();
                let selected = getSelectedCreatives();

                if (cats) {
                    cats.forEach(cat => formData.append('cats[]', cat));
                }

                if (selected) {
                    selected.forEach(select => formData.append('selects[]', select));
                }

                $.ajax({
                    {{-- url: "{{  route('admin.connect-creative.getCreatives') }}", --}}
                    url: "/admin/connect-with-creatives/response/get-creatives",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                    },
                    success: function(response) {
                        
                        if(response.validated) {
                            // console.log(response.creatives);
                            resolve(response.creatives);
                        } else {
                            // alert('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.');
                            // console.log(response);
                            reject(new Error('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.'));
                        }
                    },
                    error: function(xhr, status, error) {
                        // alert('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.');
                        // console.log(response);
                        reject(new Error('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.'));
                    },
                    complete: function() {
                        $('#loadingModal').modal('hide');
                    }
                });
            });
        }

        function getSelectedCreatives() {
            const ids = $('.recommended-creatives .request_multiple')
                .map(function() { return $(this).data('id'); })
                .get();

            return ids;
        }

        function populateCreatives(creatives) {
            let $select = $('#creatives');
            $select.empty();
            
            $select.append('<option value="">-</option>');
            $.each(creatives, function(index, creative) {
                let text = creative.name;
                
                $select.append(
                    $('<option>', {
                        value: creative.c_id,
                        text: text
                    })
                    .attr('data-name', creative.name)
                    .attr('data-id', creative.c_id)
                    .attr('data-verified', creative.verified)
                );
            });

            $select.select2({
                width: '100%',
                templateResult: function(data) {
                    if (!data.id) return data.text; // placeholder

                    let verified = $(data.element).data('verified');
                    let colorClass = '';

                    if (verified === 'Verified') colorClass = 'bg-success text-white fw-semibold px-2 py-1 rounded';
                    if (verified === 'Unverified') colorClass = 'bg-gray text-white fw-semibold px-2 py-1 rounded';

                    return $(
                        '<span>' + 
                            data.text + 
                            (verified ? ' <span class="creative_type ' + colorClass + '">' + verified + '</span>' : '') +
                        '</span>'
                    );
                },
                templateSelection: function(data) {
                    return data.text; // only show plain name in the selection
                }
            });


        }

        function updateProfileViewer(id) {

            $('.profile-viewer').html(`<center><i class="fas fa-spinner fa-spin fa-1x text-dark"></i></center>`);

            getCreativeProfile(id)
                .then(function(profile){
                    setProfileViewer(profile);
                })
                .catch(function(error){
                    alert(error);
                })
                .finally(function(){
                    $('#loadingModal').modal('hide');
                });
        }

        function getCreativeProfile(id) {
            return new Promise((resolve, reject) => {
                
                let formData = new FormData();
                formData.append('id', id);
                
                $.ajax({
                    {{-- url: "{{  route('admin.connect-creative.getProfile') }}", --}}
                    url: "/admin/connect-with-creatives/response/get-profile",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                    },
                    success: function(response) {
                        
                        if(response.validated) {
                            // console.log(response.creatives);
                            resolve(response.profile);
                        } else {
                            // alert('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.');
                            // console.log(response);
                            reject(new Error('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.'));
                        }
                    },
                    error: function(xhr, status, error) {
                        // alert('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.');
                        // console.log(response);
                        reject(new Error('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.'));
                    },
                    complete: function() {
                    }
                });
            });
        }

        function setProfileViewer(profile) {
            // console.log(profile);

            $viewer = $('.profile-viewer');
            // $viewer.html(profile.disp_name);
            $viewer.html(`
                <div class="container-fluid">
                    <div class="row mt-3">
                        <div class="col-6"><h4>` + profile.disp_name + `</h4></div>
                        <div class="col-6 text-end"><a href="/profile/` + profile.latest_slug.value + `" class="btn btn-primary" target="_blank" rel="noopener noreferrer">Profile link</a></div>
                        
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <span class="request_label">Last Updated</span>
                            <span class="request_detail">
                                ${
                                    profile?.updated_at
                                        ? new Date(profile.updated_at).toLocaleDateString('en-US', {
                                            year: 'numeric',
                                            month: 'short',
                                            day: 'numeric'
                                        })
                                        : '-'
                                }
                            </span>
                        </div>
                        <div class="col-12 mt-3">
                            <span class="request_label">Contact Person</span>
                            <span class="request_detail">` + profile.first_name + ` ` + profile.last_name + `</span>
                        </div>
                        <div class="col-12 mt-3">
                            <span class="request_label">Designation</span>
                            <span class="request_detail">` + (profile.job_title_latest?.value ?? `-`) + `</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <span class="request_label">Email/s</span>
                            <span class="request_detail">
                                ${
                                    profile.emails?.length
                                        ? profile.emails.map(e => e.value).join(', ')
                                        : '-'
                                }
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <span class="request_label">Category</span>
                            <span class="request_detail">` + (profile.uindie.expertise ?? '-') + `</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <span class="request_label">Expertise and Services</span>
                            <span class="request_detail">
                                ${
                                    profile?.uindie?.expertises?.length
                                        ? profile.uindie.expertises.map(e => e.value).join(', ')
                                        : '-'
                                }
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <span class="request_label">Sectors of Interest</span>
                            <span class="request_detail">
                                ${
                                    profile?.sector
                                        ?.map(s => s.value?.trim())
                                        .filter(v => v)
                                        .join(', ') || '-'
                                }
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <span class="request_label">About</span>
                            <span class="request_detail">` + profile.about ?? '-' + `</span>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 mt-3">
                            <span class="request_label">Socials</span>
                            <span class="request_detail">
                                ${
                                    profile.socials?.length
                                        ? profile.socials.map(social => {
                                            const value = social.value?.trim() || '';
                                            const startsWithHttp = value.startsWith('http') || value.startsWith('www');
                                            const url = startsWithHttp
                                            ? value
                                            : (() => {
                                                switch (social.type) {
                                                    case 'Facebook': return `https://www.facebook.com/${value}`;
                                                    case 'Instagram': return `https://www.instagram.com/${value}`;
                                                    case 'Twitter': return `https://www.twitter.com/${value}`;
                                                    case 'Youtube': return `https://www.youtube.com/${value}`;
                                                    case 'Tiktok': return `https://www.tiktok.com/${value}`;
                                                    case 'Behance': return `https://www.behance.net/${value}`;
                                                    default: return value || '#';
                                                }
                                                })();

                                            const iconMap = {
                                            Facebook: 'fa-facebook',
                                            Instagram: 'fa-instagram',
                                            Twitter: 'fa-twitter',
                                            Youtube: 'fa-youtube',
                                            Tiktok: 'fa-tiktok',
                                            Behance: 'fa-behance'
                                            };
                                            const iconClass = iconMap[social.type] || 'fa-globe';

                                            return `<a href="${url}" target="_blank" rel="noopener noreferrer" style="margin-right:6px;">
                                                    <i class="fa-brands ${iconClass}"></i>
                                                    </a>`;
                                        }).join(' ')
                                        : '-'
                                }
                            </span>
                        </div>
                    </div>
                    

                </div>

            `);
        }
    </script>


        


@endsection


