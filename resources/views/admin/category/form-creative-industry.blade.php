@extends('admin.index')

@section('contentAdmin')
 
<section>
    <h1>Creative Industry</h1>
    <hr>
    <div class="mt-60 mb-60">
        <form>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Cover Image</label>
                    <input class="form-control form-control-lg" type="file" placeholder="Cover Image">
                </div>
                <div class="col img-holder">
                    <img src="" alt="" class="img-fluid">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Industry Name</label>
                    <input class="form-control form-control-lg" type="text" placeholder="Industry Name">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Description</label>
                    <input type="text" name="" placeholder="Description" value="" class="form-control form-control-lg" rows="5">
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
                    <input class="form-control form-control-lg" type="text" placeholder="SEO Description" rows="5">
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
                    <a href="{{ url('admin/creative-industries') }}" class="btn btn-disabled">CANCEL</a>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection