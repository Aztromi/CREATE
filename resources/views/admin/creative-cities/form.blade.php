@extends('admin.index')

@section('contentAdmin')
 
<section>
    <h1>Creative City</h1>
    <hr>
    <div>
        <form>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Banner Image</label>
                    <input class="form-control form-control-lg" type="file" placeholder="Banner Image">
                </div>
                <div class="col img-holder">
                    <img src="" alt="" class="img-fluid">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">City Name</label>
                    <input class="form-control form-control-lg" type="text" placeholder="City Name">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Subheader</label>
                    <input class="form-control form-control-lg" type="text" placeholder="Subheader">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Content</label>
                    <textarea class="form-control form-control-lg" id="exampleFormControlTextarea1" rows="15">
                        Content goes here
                    </textarea>
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Featured Images (Can be multiple images.)</label>
                    <input type="file" name="filefield" class="form-control form-control-lg" multiple="multiple">
                </div>
            </div>
            <div class="row mb-40 mt-60">
                <hr>
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
            <div class="row mb-40 form-group">
                <div class="col">
                    <button class="btn btn-primary">SUBMIT</button>
                    <a href="{{ url('admin/articles') }}" class="btn btn-disabled">CANCEL</a>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection