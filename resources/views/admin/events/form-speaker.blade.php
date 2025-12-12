@extends('admin.index')

@section('contentAdmin')
 
<section>
    <h1>CREATIVE FUTURES: Speakers</h1>
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
                    <label for="">Speaker Name</label>
                    <input class="form-control form-control-lg" type="text" placeholder="Speakers Name">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Creative Futures Year</label>
                    <select class="form-select mb-3" aria-label="">
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                      </select>
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <button class="btn btn-primary">SUBMIT</button>
                    <a href="{{ url('admin/speakers') }}" class="btn btn-disabled">CANCEL</a>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection