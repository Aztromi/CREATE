@extends('admin.index')

@section('styles')
    <!-- for multiple select -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link href="{{ asset('plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/shared/loadingModal-custom.css?ver='.time()) }}">

    <link rel="stylesheet" href="{{ asset('css/admin/articles/form.css') }}">

    <style>
        #banner .dropify-wrapper .dropify-message {
            top: 23%;
        }

        #banner .dropify-wrapper .dropify-message .file-icon p{
            font-size: 16px;
        }

        #banner .dropify-wrapper .dropify-message .file-icon::before {
            /* CLOUD ICON */
            content: '';
        }

        #banner .dropify-wrapper .dropify-preview .dropify-render img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endsection

@section('scripts-bottom')

    <!-- TinyMCE -->
    @include('admin.components.tinymce-articles')

    <!-- for multiple select -->
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('js/shared/tags.js?ver='.time()) }}"></script>
    <script src="{{ asset('js/admin/articles/form.js?ver='.time()) }}"></script>
    
    <script>
        $articleID = "{{ isset($article) && !empty($article) ? $article->id : '' }}";
        $(document).ready(function(){

            $("#loadingModal").modal({ 
                backdrop: "static", 
                keyboard: false, 
            }); 

            $('#loadingModal').modal('show');
            $('#main-content').hide();
            
            $("#cField").select2({
                placeholder: 'Select an option'
            });
            
            initializeAll();
            
        });
    </script>
    
@endsection

@section('contentAdmin')
    <section>

        <div class="modal" id="loadingModal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-white">
                    <div class="modal-body text-center">
                        <i class="fas fa-spinner fa-spin fa-3x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-lg-12 col-xl-9 mx-auto">
        <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
        <div class="card-body">
            <!-- <h1 class="card-title">Add Article</h1> -->
            
            <div class="container" id="main-content">
                <form id="frm-article" action="{{ route('admin.process-article') }}">
                    <div class="row">
                        <div class="col mb-4">
                            <h1>{{ isset($article) && !empty($article) ? 'Edit Article' : 'Add Article' }}</h1>
                        </div>
                    </div>
                    <div class="row mb-3">
                        @if(isset($article) && !empty($article))
                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                        @endif
                        <div class="col-12">
                            <label for="title">Title</label>
                            <input 
                                class="form-control form-control-lg" 
                                id="title" 
                                name="title" 
                                type="text" 
                                value="{{ old('title', $article->name ?? '') }}"
                                placeholder="Title" required>
                        </div>
                        <div class="col-12">
                            <div class="error-message text-danger pb-2" id="title-error"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="subheader">Subheader</label>
                            <input 
                                class="form-control form-control-lg" 
                                id="subheader" 
                                name="subheader" 
                                type="text" 
                                value="{{ old('subheader', $article->subheader ?? '') }}"
                                placeholder="Subheader">
                        </div>
                        <div class="col-12">
                            <div class="error-message text-danger pb-2" id="subheader-error"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div id="banner">
                            <label for="masthead">Masthead <span style="color: red;">*</span></label>
                                <input type="file" id="masthead" name="masthead" class="dropify" data-max-file-size="5M" data-allowed-file-extensions="png jpg jpeg" data-height="200" @if(isset($article) && !empty($article)) data-default-file="{{ $masthead }}" @endif data-errors-position="outside"/>
                                <input type="hidden" id="masthead-change" name="masthead-change">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="error-message text-danger pb-2" id="masthead-error"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="banner_caption">Masthead caption</label>
                            <input 
                                class="form-control form-control-lg" 
                                id="banner_caption" 
                                name="banner_caption" 
                                type="text" 
                                value="{{ old('banner_caption', $article->banner_caption ?? '') }}"
                                placeholder="Banner caption">
                        </div>
                        <div class="col-12">
                            <div class="error-message text-danger pb-2" id="banner_caption-error"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="author">Author</label>
                            <input 
                                class="form-control form-control-lg" 
                                id="author" 
                                name="author" 
                                type="text" 
                                value="{{ old('author', $article->author ?? '') }}"
                                placeholder="Author">
                        </div>
                        <div class="col-12">
                            <div class="error-message text-danger pb-2" id="author-error"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-4">
                            <label for="article-content">Content</label>
                            <textarea class="form-control" id="article-content" name="article-content" rows="15" required>
                                {{ old('article-content', $article->content ?? 'Content goes here') }}
                            </textarea>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="cField">Creative Field</label>
                            <select name="cField[]" id="cField" class="form-control form-control-lg" multiple="multiple" style="width: 100%" required>
                                -
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="error-message text-danger pb-2" id="cField-error"></div>
                        </div>
                    </div>
                    
                    {{--
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
                    --}}
                    <div class="row">
                        <div class="col mb-4">
                            <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="publish" name="publish" {{ old('publish', isset($article) && $article->published == 'published' ? 'checked' : '') }}>
                            <label class="custom-control-label" for="publish">Publish Article</label>
                            </div>
                            <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="feature" name="feature" {{ old('feature', isset($article) && $article->featured == 1 ? 'checked' : '') }}>
                            <label class="custom-control-label" for="feature">Feature Article</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-4 text-end">
                            <button type="submit" class="btn btn-primary btn-lg">Save</button>
                            <button type="reset" class="btn btn-secondary btn-lg">Clear</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a> -->
        </div>
        </div>
    </section>
@endsection