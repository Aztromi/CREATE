<script>
    function generateID(gameType){
        return new Promise(function(resolve, reject) {
            var data ={};
            data['game'] = gameType;

            $.ajax({
                url: '/play/generate-id',
                type: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    resolve(response.play_id);
                },
                error: function(xhr, status, error) {
                    // console.log(xhr.responseText);
                    reject();
                }
            });
        });
    }

    function saveScore(gameType, play_id, score){
        return new Promise(function(resolve, reject) {
            if(score == 0) {
                resolve(false);
                return;
            }

            var data ={};
            data['game'] = gameType;
            data['play_id'] = play_id;
            data['score'] = score;

            $.ajax({
                url: '/play/save-score',
                type: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    resolve(response.status);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    reject();
                }
            });
        });
    }

    $('#modal-game-form #btn-submit').on('click', async function(e){
        e.preventDefault();

        const form = $('#modal-game-form form')[0];

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        $(this).prop('disabled', true);
        const result = await saveContact($('#modal-game-form form'));
        

        if(result) {
            window.location.href = '/play';
        }
        else {
            $(this).prop('disabled', false);
            alert('Submission failed. Please try again.');
            
        }
    });



    function saveContact(form){
        return new Promise(function(resolve, reject) {
            if(score == 0) {
                resolve(false);
                return;
            }

            $.ajax({
                url: '/play/save-contact',
                type: 'POST',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    resolve(response.status);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    reject();
                }
            });
        });
    }
    
</script>