@extends('admin.index')

@section('contentAdmin')
 
<section>
    <h1>CREATIVE FUTURES</h1>
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
                    <label for="">Event Title</label>
                    <input class="form-control form-control-lg" type="text" placeholder="Event Title">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Description</label>
                    <input class="form-control form-control-lg" type="text" placeholder="Description" rows="5">
                </div>
            </div>
            <div class="row form-group">
                <div class="col">
                    <label for="">Event Dates</label>
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Start Date</label>
                    <input class="form-control form-control-lg" type="date" placeholder="eventStartDate">
                </div>
                <div class="col">
                    <label for="">End Date</label>
                    <input class="form-control form-control-lg" type="date" placeholder="eventEndDate">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Speakers</label>
                    <select class="form-select" aria-label="Speakers" multiple>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
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
                    <a href="{{ url('admin/creative-futures') }}" class="btn btn-disabled">CANCEL</a>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection