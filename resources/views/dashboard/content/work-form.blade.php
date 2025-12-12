@extends('dashboard.index')

@section('userDashboard')

<section>
    <h1>Work</h1>
    <hr>
    <div class="mt-60 mb-60">
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
                    <label for="">Title</label>
                    <input class="form-control form-control-lg" type="text" placeholder="Title">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col-xs-12 col-sm-4">
                    <label for="">Date Created</label>
                    <input class="form-control form-control-lg" type="date" placeholder="Date Created">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Content</label>
                    <textarea class="form-control"  rows="15">
                        Content goes here
                    </textarea>
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
                    <button type="submit" name="publish" class="btn btn-primary">Publish</button>
                    <button type="submit" name="draft" class="btn btn-secondary">Save as Draft</button>
                    <a href="{{ route('user.index') }}" class="btn btn-disabled">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection