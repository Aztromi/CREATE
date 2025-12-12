<script src="{{ URL::asset('tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea#addArticle',
    tollbarmode: 'wrap',
    menubar: true,
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss autosave insertdatetime fullscreen code',
    toolbar: [
      { name: 'history', items: [ 'undo', 'redo' ] },
      { name: 'styles', items: [ 'styles', 'fontfamily', 'fontsize', 'forecolor', 'backcolor' ] },
      { name: 'formatting', items: [ 'bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'superscript', 'subscript' ] },
      { name: 'alignment', items: [ 'align', 'lineheight' ] },
      { name: 'indentation', items: [ 'outdent', 'indent' ] },
      { name: 'list', items: [ 'checklist', 'numlist', 'bullist' ] },
      { name: 'multimedia', items: [ 'link', 'media', 'table' ] },
      { name: 'format', items: [ 'removeformat' ] },
      { name: 'misc', items : [ 'searchreplace' ] },
    ],
    
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ]
  });
</script>
    <style>.tox-promotion{display:none}</style>