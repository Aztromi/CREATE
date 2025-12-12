@section('styles')
    <link rel="stylesheet" href="{{ asset('css/shared/loadingModal-custom.css?ver='.time()) }}">
    <style>
        #loadingModal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
        }

        #loadingModal .modal-content {
            background-color: transparent;
            box-shadow: none;
            border: none;
        }

        .card-main {
            /* height: 70vh; */
            align-items: center;
        }

        .card-main .card-body {
            max-width: 800px;
            width: 100%;
            height: 100%;
            /* min-width: 300px;
            min-height: 500px; */
        }

        .card-main .card-body #main-content {
            height: 100%;
        }

        .card-main .card-body #main-content .row {
            height: 80%;
        }

        .card-main .card-body .search-container {
            padding: 5px;
            margin-bottom: 20px;
            border-radius: 10px;
            height: 50px;

            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            background-color: #FBFBFB;
        }

        .card-main .card-body .search-container input {
            border: 0;
            background-color: transparent;
        }

        .card-main .card-body .search-container button {
            border: 0;
            background-color: transparent;
            color: #858585;
        }

        .card-main .message-container {
            /* border: 1px solid #000; */
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            background-color: #FBFBFB;
            border-radius: 20px;
            height: 40vh;
            min-height: 500px;
            
        }

        .card-main .message-container.list {
            padding: 10px;
            overflow-y: auto;
        }

        .card-main .message-container.details {
            padding: 10px;
            display: flex;
            flex-direction: column;
        }

        .card-main .message-container.list .entry {
            /* border: 1px solid #000; */
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
            background-color: #FFF;
            border-radius: 20px;
            padding: 10px 15px;
            margin-bottom: 7px;
            cursor: pointer;
        }

        .card-main .message-container.list .entry.active {
            background-color:rgb(84, 184, 255);
        }

        .card-main .message-container.list .entry:hover {
            background-color:rgb(140, 207, 255);
        }

        .card-main .message-container.list .entry .sender{
            font-weight: bold;
            font-size: 18px;
        }

        .card-main .message-container.list .entry .message{
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-main .message-container.list .entry .datetime{
            font-size: 12px;
            display: flex;
            justify-content: flex-end;
        }

        .card-main .message-container.details .head {
            flex: 0 0 auto;
            padding: 5px 10px 10px 0;
        }

        .card-main .message-container.details .head .back-to-list {
            color: #858585;
            padding: 7px;
            border-radius: 5px;
            font-weight: bold;
        }

        .card-main .message-container.details .head .back-to-list:hover {
            background-color: rgb(13, 154, 255);
            cursor: pointer;
            color: #FFF;
            
        }

        .card-main .message-container.details .head .participant-name-container {
            text-align: center;
        }

        .card-main .message-container.details .head .participant-name {
            color: rgb(13, 154, 255);
            padding: 7px;
            border-radius: 5px;
            font-size: 25px;
            font-weight: bold;
            text-align: center;
        }

        .card-main .message-container.details .body {
            flex: 1; /* Takes up all available space */
            overflow-y: auto; /* Makes content scrollable if needed */
            padding: 10px;
            border: 1px solid rgb(228, 228, 228);
            box-shadow: rgb(228, 228, 228) 3px 3px 6px 0px inset, rgba(228, 228, 228, 0.5) -3px -3px 6px 1px inset;
            border-radius: 20px;
            margin-bottom: 10px;
            background-color: #FBFBFB;
        }

        .card-main .message-container.details .body .message {
            border: 1px solid rgba(139, 139, 139, 0.24);
            box-shadow: rgba(139, 139, 139, 0.24) 3px 3px 3px;
            background-color: #FFF;
            margin: 15px 5px;
            border-radius: 20px;
            padding: 15px 20px;
            font-size: 16px;
            line-height: 18px;
        }

        .card-main .message-container.details .body .message.message-ext {
            margin-right: 60px;
        }

        .card-main .message-container.details .body .message.message-own {
            margin-left: 60px;
        }

        .card-main .message-container.details .body .message .sender {
            margin-bottom: 10px;
            font-weight: bold;
            color: rgb(13, 154, 255);
        }

        .card-main .message-container.details .body .message .datetime {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            font-size: 12px;
        }

        .card-main .message-container.details .footer {
            flex: 0 0 auto; /* Fixed height for footer */
            margin-bottom: 10px;
        }

        .card-main .message-container.details .footer textarea{
            width: 100%;
            height: 100px;
            resize: none;
            padding: 10px 15px 0 15px;
            border-radius: 20px;
            border: 1px solid #D5D5D5;
            font-size: 16px;
            line-height: 18px;
        }

        .card-main .message-container.details .footer textarea:focus-visible{
            outline: 0;
        }

        .card-main .message-container.details .footer .taCounter {
            font-size: 12px;
            line-height: 5px;
            padding-left: 25px;
        }

        .card-main .message-container.details .footer .btn-container {
            display: flex;
            justify-content: flex-end;
        }

        .card-main .message-container.details .footer .btn-container #btn-send {
            border: 1px solid rgb(13, 154, 255);
            border-radius: 10px;
            background-color: rgb(13, 154, 255);
            font-weight: bold;
            color: #FFFFFF;
            padding: 2px 10px;
        }

        .card-main .message-container.details .footer .btn-container #btn-send:hover {
            background-color: #FFF;
            color: rgb(13, 154, 255);
        }

        .card-main .message-container.details .footer .btn-container #btn-clear {
            border: 1px solid transparent;
            border-radius: 10px;
            background-color: transparent;
            font-weight: bold;
            color: rgb(170, 170, 170);
            padding: 2px 10px;
            margin-left: 5px;
        }

        .card-main .message-container.details .footer .btn-container #btn-clear:hover {
            border: 1px solid rgb(170, 170, 170);
            background-color: rgb(170, 170, 170);
            color: #FFFFFF;
        }

    </style>
@endsection

@section('scripts-bottom')
    <script>

        const currentUserId = {{ Auth::id() }}; 
        const taMaxLength = 200;
        let message_group_id = 0;

        //PUSHER v2
        let subscribedChannels = {};

        let loadingModal, mainContent, messageContainer_details, messageContainer_details_body, messageContainer_list, messageTextArea, topElements, participant_label, searchInput;
        
        $(document).ready(function(){

            loadingModal = $('#loadingModal');
            mainContent = $('#main-content');
            messageContainer_details = $('.message-container.details');
            messageContainer_details_body = $('.message-container.details .body');
            messageContainer_list = $('.message-container.list');
            messageTextArea = $('.message-container.details .footer textarea');
            topElements = $('.card-main .card-body .top-elements');
            participant_label = $('.card-main .message-container.details .head .participant-name');
            searchInput = $('#search');

            $("#loadingModal").modal({ 
                backdrop: "static", 
                keyboard: false, 
            });

            initLoad(1);

            @if($group_id)
            getMessageDetails({{ $group_id }}, 0);
            @endif

            let typingTimer;
            let typingDelay = 1000; // 1 second

            // ON Message Search
            $(document).on('input', '#search', function(){
                clearTimeout(typingTimer);
                let val = $.trim($(this).val());

                typingTimer = setTimeout(function () {
                    if (val.length > 0) {
                        startSearch(val);
                    } else {
                        initLoad(0);
                    }
                }, typingDelay);
            });

            // ON LIST ENTRY CLICK
            $(document).on('click', '.card-main .message-container.list .entry', function(){
                getMessageDetails($(this).data('group-id'), $(this).data('recipient-id'));
            });

            // ON BACK CLICK
            $('.back-to-list').on('click', function(){
                backToList();
            });

            // ON TEXTAREA INPUT
            messageTextArea.on('input', function(){
                setTACharacterCount();
            });

            // ON SEND CLICK
            $('.message-container.details .footer #btn-send').on('click', function(){
                if(messageTextArea.val().trim().length > 0){
                    sendMessage();
                }
            });

            // ON CLEAR CLICK
            $('.message-container.details .footer #btn-clear').on('click', function(){
                if(messageTextArea.val().trim().length > 0){
                    clearTextArea();
                }
            });
        });
        


        async function startSearch(value) {
            $('#search-button').html(`<i class="fas fa-spinner fa-spin"></i>`);

            try {
                setMessageList(0, '');
                const response = await getMessageList(value);
                setMessageList(1, response);
                
            } catch (error) {
                console.log(error);
                alert('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.');
                
            } finally {
                $('#search-button').html(`<i class="fas fa-search"></i>`);
            }
        }
        

        async function initLoad(init){

            setMessageList(0, '');

            if(init == 1) {
                loadingModal.modal('show');
                mainContent.hide();
            }

            try {
                const response = await getMessageList(null);
                setMessageList(1, response);

                //PUSHER v2
                if (init == 1 && response) {
                    subscribeToAllChannels(response);
                }

            } catch(error) {
                if (error.status === 404) {
                    setMessageList(0, '');
                } else {
                    console.log(error);
                    alert('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.');
                }
            } finally {
                if(init == 1) {
                    mainContent.show();
                    loadingModal.modal('hide');
                }
            }
        }

        function getMessageList(searchVal) {
            return new Promise((resolve, reject) => {
                let formData = new FormData();
                
                if(searchVal) {
                    formData.append('searchVal', searchVal);
                }
                
                $.ajax({
                    url: "{{ route('shd.messages.getMessageList') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data. For Files
                    contentType: false, // Prevent jQuery from setting the content type. For Files
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    // beforeSend: function() {
                    //     // $("#loadingModal").modal('show');
                    // },
                    success: function(response) {
                        // console.log(response);
                        resolve(response);
                    },
                    error: function(xhr, status, error) {

                        reject(xhr);
                        
                        // if (xhr.status === 404) {
                        //     reject({ status: 404, message: 'No messages found' });
                        // } else {
                        //     reject({ status: xhr.status, message: xhr.statusText });
                        // }
                        
                        // alert('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.');
                    }
                    // ,
                    // complete: function(xhr, status) {
                    //     $('#loadingModal').modal('hide');
                    // }
                });
            });
        }
        
        function setMessageList(state, response) {
            if(state == 0) {
                messageContainer_list.html('<center>No Messages/Contacts found</center>');
            }
            else {

                if (response && response.length > 0) {
                    messageContainer_list.html('');

                    // console.log(response)
                    
                    response.forEach(msg => {
                        const notify = msg.notify === 1 ? 'active' : '';
                        const datetime = formatDateTime(false, msg.datetime);

                        let base_val = ``;
                        if(msg.group_id == 0) {
                            base_val = `data-group-id=0 data-recipient-id="${msg.recipient_id}"`;
                        } else {
                            base_val = `data-group-id="${msg.group_id}" data-recipient-id=0`;
                        }

                        const html = `
                            <div class="entry ${notify}" ${base_val}>
                                <div class="row">
                                    <div class="col-12">
                                        <span class="sender">${msg.co_participant}</span>
                                    </div>
                                    <div class="col-12">
                                        <span class="message">
                                            ${msg.message}
                                        </span>
                                    </div>
                                    <div class="col-12">
                                        <span class="datetime">${datetime}</span>
                                    </div>
                                </div>
                            </div>
                        `;
                        messageContainer_list.append(html);
                    });
                    
                } else {
                    messageContainer_list.html('<center>No Messages/Contacts found</center>');
                }
                
            }
        }

        function backToList(){

            message_group_id = 0;

            initLoad(0);

            topElementsToggle('show');
            messageContainer_details.hide();    
            messageContainer_list.show();
        }

        function topElementsToggle(display) {
            switch (display) {
                case 'hide':
                    // topElements.addClass('d-none');
                    topElements.hide();
                    searchInput.val('');
                    break;
                case 'show':
                    // topElements.removeClass('d-none');
                    topElements.show();
                    break;
            }
        }


        async function getMessageDetails(group_id, recipient_id) {

            loadingModal.modal('show');
            setMessageDetails(0, '');

            try {
                const response = await queryMessageDetails(group_id, recipient_id);
                setMessageDetails(1, response);
            } catch(error) {
                if (error.status === 404) {
                    setMessageDetails(0, '');
                } else {
                    console.log(error);
                    alert('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.');
                }
            } finally {
                messageContainer_list.hide();
                messageContainer_details.show();
                loadingModal.modal('hide');
                messageTextArea.focus();
            }
        }

        function queryMessageDetails(group_id, recipient_id) {
            return new Promise((resolve, reject) => {
                let formData = new FormData();
                formData.append('group_id', group_id);
                formData.append('recipient_id', recipient_id);
                $.ajax({
                    url: "{{ route('shd.messages.getMessageEntries') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data. For Files
                    contentType: false, // Prevent jQuery from setting the content type. For Files
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    // beforeSend: function() {
                    //     // $("#loadingModal").modal('show');
                    // },
                    success: function(response) {
                        // console.log(response);
                        resolve(response);
                    },
                    error: function(xhr, status, error) {
                        // console.error(xhr.responseText);
                        
                        if (xhr.status === 404) {
                            reject({ status: 404, message: 'No messages found' });
                        } else {
                            reject({ status: xhr.status, message: xhr.statusText });
                        }
                    }
                    // ,
                    // complete: function(xhr, status) {
                    //     $('#loadingModal').modal('hide');
                    // }
                });
            });
        }
        
        function setMessageDetails(state, response) {

            participant_label.html(response.co_participants);
            let group_id = response.group_id;
            topElementsToggle('hide');

            if(state == 0) {
                messageContainer_details_body.html('<center>No Messages</center>');
            }
            else {
                
                if (response.messageDetails && response.messageDetails.length > 0) {

                    messageContainer_details_body.html('');
                
                    // console.log(response)

                    response.messageDetails.forEach(msg => {
                        const type = msg.sender_type === 'user' ? `message-own` : `message-ext`;
                        const sender = msg.sender_type === 'user' ? `` : `<div class="sender">${msg.sender_name}</div>`;
                        const datetime = formatDateTime(false, msg.datetime);
                        const html = `
                            <div class="message ${type}">
                                ${sender}
                                <div class="content">${msg.message}</div>
                                <div class="datetime">${datetime}</div>
                            </div>
                        `;
                        messageContainer_details_body.append(html);
                    });
                } else {
                    messageContainer_details_body.html('<center>No Messages</center>');
                }
                
                message_group_id = group_id;

                setTimeout(() => {
                    messageContainer_details_body.scrollTop(
                        messageContainer_details_body.prop("scrollHeight")
                    );
                }, 0);
            }
        }   

        function setTACharacterCount(){
            const charCount = messageTextArea.val().length;
            
            $('.footer .taCounter').text(charCount + '/' + taMaxLength);

        }

        async function sendMessage(){
            // loadingModal.modal('show');
            let message = messageTextArea.val().trim().replace(/\n/g, "<br>");

            if (message.length > taMaxLength) {
                message = message.substring(0, taMaxLength); // Truncate to maxLength
            }

            try {
                const response = await processSendMessage(message_group_id, message);
                clearTextArea();
                setMessage(message);
            } catch (error) {
                console.log(error.message);
                alert('Something went wrong. Please try again. If the issue persists, please email us at createph@citem.com.ph with details of the issue you encountered.');
            } finally {
                // loadingModal.modal('hide');
            }
        }

        function processSendMessage(group_id, message) {
            return new Promise((resolve, reject) => {
                let formData = new FormData();
                formData.append('group_id', group_id);
                formData.append('message', message);

                $.ajax({
                    url: "{{ route('shd.messages.sendMessage') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    processData: false, // Prevent jQuery from processing the data. For Files
                    contentType: false, // Prevent jQuery from setting the content type. For Files
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function(response) {
                        // console.log(response);
                        resolve(response);
                    },
                    error: function(xhr, status, error) {
                        // console.error(xhr.responseText);
                        reject({ status: xhr.status, message: xhr.statusText });
                    }
                });
            });
        }

        function setMessage($message){
            
            messageContainer_details_body.append(`
                <div class="message message-own">
                    <!-- <div class="sender"></div> -->
                    <div class="content">` + $message + `</div>
                    <div class="datetime">` + formatDateTime(true, '') + `</div>
                </div>
            `);
            messageContainer_details_body.scrollTop(messageContainer_details_body.prop("scrollHeight"))

            messageTextArea.focus();
        }

        function clearTextArea(){
            messageTextArea.val("");
            setTACharacterCount();
            messageTextArea.focus();
        }

        function formatDateTime(setNow, datetimeStr) {
            if (!setNow && !datetimeStr) {
                return '';
            }
            
            let date = new Date(datetimeStr);
            const now = new Date();

            date = setNow ? now : date;

            const isToday =
                date.getDate() === now.getDate() &&
                date.getMonth() === now.getMonth() &&
                date.getFullYear() === now.getFullYear();

            if (isToday) {
                // Only show time if it's today
                return new Intl.DateTimeFormat('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                }).format(date);
            }

            // Otherwise show full date + time
            return new Intl.DateTimeFormat('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            }).format(date).replace(',', '');
        }
        
        //PUSHER v2
        function subscribeToAllChannels(groups) {
            groups.forEach(group => {
                // Only subscribe if we haven't already
                if (!subscribedChannels[group.group_id]) {
                    window.Echo.private(`chat.${group.group_id}`)
                        .listen('NewMessageSent', (e) => {
                            // console.log('Broadcast received:', e);

                            // Case 1: The user is actively viewing the chat that received a message.
                            if (messageContainer_details.is(':visible') && e.group_id == message_group_id) {
                                appendMessageToDetailsView(e);
                            }
                            // Case 2: The user is on the list view (or viewing a different chat).
                            else {
                                updateMessageInListView(e);
                            }
                        });

                    // Mark as subscribed
                    subscribedChannels[group.group_id] = true;
                }
            });
        }

        //PUSHER v2
        function appendMessageToDetailsView(e) {
            const html = `
                <div class="message message-ext">
                    <div class="sender">${e.sender_name}</div>
                    <div class="content">${e.message}</div>
                    <div class="datetime">${formatDateTime(false, e.datetime)}</div>
                </div>
            `;
            messageContainer_details_body.append(html);
            messageContainer_details_body.scrollTop(messageContainer_details_body.prop("scrollHeight"));
        }

        //PUSHER v2
        function updateMessageInListView(e) {
            const listEntry = messageContainer_list.find(`.entry[data-group-id="${e.group_id}"]`);

            if (listEntry.length > 0) {
                // Update the preview text and time
                listEntry.find('.message').html(e.message);
                listEntry.find('.datetime').text(formatDateTime(false, e.datetime));

                // Add 'active' class for styling and move the conversation to the top of the list
                listEntry.addClass('active');
                messageContainer_list.prepend(listEntry);
            }
        }






    </script>

@endsection