@extends('admin.index')

@section('styles')
<!-- for multiple select -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #0d6efd;
    }

    /* Banner */
        {{--
        #image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        --}}

        #banner-image {
            display: none;
        }
        
        #edit-icon {
            position: absolute;
            top: 50px;
            right: 25px;
            padding: 2px 5px;
            border-radius: 5px;
            /* box-shadow: rgba(0, 0, 0, 1.0) 0px 2px 8px; */
            box-shadow: 2px 2px 4px 4px rgba(0,0,0,0.3);
            font-size: 30px;
            color: #888888;
            /* font-weight: bold; */
            background-color: #F5F5F5;
            cursor: pointer;
        }

        #edit-icon:hover {
            background-color: #4B7BC9;
            color: #FFFFFF;

        }

        #image-container {
            border-radius: 10px;
            border: 1px solid #999999;
            /* box-shadow: 2px 2px 4px 4px rgba(0,0,0,0.2); */
            height: 35vw;
            overflow: hidden;
            background-color: #EEEEEE;
        }

        #image-container img {
            /* border-radius: 10px; */
            width: 100%;
            
        }

    /* END Banner */
</style>

@endsection

@section('scripts-bottom')

    <!-- TinyMCE -->
    @include('admin.components.tinymce-articles')

    <!-- for multiple select -->
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $("#cField").select2({
                placeholder: 'Select an option'
            });

            $('#edit-icon').on('click', function(e){
                $('#banner-image').trigger('click');
            });

            $('#banner-image').on('change', function(e){
                // e.preventDefault();

                var file = e.target.files[0];
                
                // Check if a file is selected
                if (!file) {
                    console.log("No file selected.");
                    return;
                }

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(file);
            });
            
        });
    </script>
    
@endsection

@section('contentAdmin')
 
<!-- <sec
 -->

<section>
    <div class="card col-lg-12 col-xl-9 mx-auto">
    <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
    <div class="card-body">
        <!-- <h1 class="card-title">Add Article</h1> -->
        
        <div class="container">
            <div class="row">
                <div class="col mb-4">
                    <h1>Add Article</h1>
                </div>
            </div>
            <div class="row">
                <div class="col mb-4">
                    <label for="title">Title</label>
                    <input class="form-control form-control-lg" id="title" name="title" type="text" placeholder="Title">
                </div>
            </div>
            <div class="row">
                <div class="col mb-4">
                    <label for="subheader">Subheader</label>
                    <input class="form-control form-control-lg" id="subheader" name="subheader" type="text" placeholder="Subheader">
                </div>
            </div>
            <div class="row">
                <div class="col mb-4">
                    <label for="cField">Creative Field</label>
                    <select name="cField" id="cField" class="form-control form-control-lg" multiple="multiple" style="width: 100%">
                        @foreach($creativeFields->groupBy('category') as $category => $items)
                            <optgroup label="{{ strtoupper($category) }}">
                                @foreach($items as $item)
                                    <option value="{{ $item->value }}">{{ $item->value }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>
            

            <div class="row">
                <div class="col-12 mb-4">
                    <label for="image-preview">Banner Image</label>
                    <div id="image-container">
                        <center>
                            <img id="image-preview" class="img-fluid" src="{{ asset('img/banner-default.jpg') }}" alt="Default Image">
                        </center>
                        
                        <div id="edit-icon">
                            &#9998; <!-- Edit icon (you can replace this with an actual icon) -->
                        </div>
                    </div>
                    <input type="file" id="banner-image" accept="image/*">

                </div>
            </div>
            

            <div class="row">
                <dv class="col-md-6 mb-4">
                    <label for="author">Author</label>
                    <input class="form-control form-control-lg" id="author" name="author" type="text" placeholder="Author">
                </dv>
            </div>
            <div class="row">
                <div class="col mb-4">
                    <label for="article-content">Content</label>
                    <textarea class="form-control" id="article-content" name="article-content" rows="15">
                        Content goes here
                    </textarea>
                </div>
            </div>
            <div class="row">
                <div class="col mb-4">
                    <label for="seoTitle">SEO Title</label>
                    <input class="form-control form-control-lg" id="seoTitle" name="seoTitle" type="text" placeholder="SEO Title">
                </div>
            </div>
            <div class="row">
                <div class="col mb-4">
                    <label for="seoDescription">SEO Description</label>
                    <input class="form-control form-control-lg" id="seoDescription" name="seoDescription" type="text" placeholder="SEO Description">
                </div>
            </div>
            <div class="row">
                <div class="col mb-4">
                    <label for="seoKeyword">SEO Keyword</label>
                    <input class="form-control form-control-lg" id="seoKeyword" name="seoKeyword" type="text" placeholder="SEO Keyword">
                </div>
            </div>
            <div class="row">
                <div class="col mb-4">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="publish" name="publish">
                      <label class="custom-control-label" for="publish">Publish Article</label>
                    </div>
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="feature" name="feature">
                      <label class="custom-control-label" for="feature">Feature Article</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-4">
                    <button type="button" class="btn btn-primary btn-lg">Save</button>
                    <button type="reset" class="btn btn-secondary btn-lg">Clear</button>
                </div>
            </div>

            
        </div>

        <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a> -->
    </div>
    </div>
</section>



@endsection