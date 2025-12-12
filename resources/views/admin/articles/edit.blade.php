@extends('admin.index')

@section('contentAdmin')
 
<section>
    <h1>Edit Article</h1>
</section>
<section>
    <div>
        <form>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Banner Image</label>
                    <input class="form-control form-control-lg" type="file" placeholder="Banner Image">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Title</label>
                    <input class="form-control form-control-lg" type="text" placeholder="Title">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Subheader</label>
                    <input class="form-control form-control-lg" type="text" placeholder="Subheader">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col-xs-12 col-sm-8">
                    <label for="">Author</label>
                    <input class="form-control form-control-lg" type="text" placeholder="Author">
                </div>
                <div class="col-xs-12 col-sm-4">
                    <label for="">Date Created</label>
                    <input class="form-control form-control-lg" type="date" placeholder="Date Created">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Content</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="15">
                        Content goes here
                    </textarea>
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">SEO Title</label>
                    <input class="form-control form-control-lg" type="text" placeholder="SEO Title">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">SEO Description</label>
                    <input class="form-control form-control-lg" type="text" placeholder="SEO Description">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">SEO Keyword</label>
                    <input class="form-control form-control-lg" type="text" placeholder="SEO Keyword">
                </div>
            </div>
        </form>
    </div>
</section>

@endsection