<script src="{{ URL::asset('tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
      
      tinymce.init({

        selector: '#article-content',

            
        // plugins: 'lists advlist code link image',
        plugins: [
            "advlist autolink link image imagetools lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table directionality emoticons template paste"
        ],
        toolbar: 'undo redo | bold italic underline alignleft aligncenter alignright alignjustify bullist numlist | link image | code',
        toolbar_mode: 'wrap',

        paste_as_text: true,


        image_title: true,
        automatic_uploads: true,
        images_upload_url: '/admin/upload/article-image-upload',

        imagetools_toolbar: "rotateleft rotateright | flipv fliph | editimage imageoptions",
        images_upload_base_path: '/folder_articles',
        automatic_uploads: true,
        convert_urls: false,
        image_caption: true,
        image_advtab: true,
        image_dimensions: false,
        file_picker_types: 'image',
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', "{{ route('admin.upload.article.image-upload') }}");
            var token = '{{ csrf_token() }}';
            xhr.setRequestHeader("X-CSRF-Token", token);
            xhr.onload = function() {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                try {
                    json = JSON.parse(xhr.responseText);
                } catch (error) {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        },
        

        promotion: false
      });





    </script>
    <!-- <style>.tox-promotion{display:none}</style>  -->






