<!-- <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.key') }}"></script>

<script>
         grecaptcha.ready(function() {
             grecaptcha.execute('{{ config('services.recaptcha.key') }}', {action: '{{ $action }}'}).then(function(token) {
                if (token) {
                  document.getElementById('recaptcha').value = token;
                }
             });
         });
</script> -->