@extends('admin.index')

@section('contentAdmin')
 
<section>
    <h1>User</h1>
    <hr>
    <div class="mt-60 mb-60">
        <form>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Profile Photo</label>
                    <input class="form-control form-control-lg" type="file" placeholder="Profile Photo">
                </div>
                <div class="col img-holder">
                    <img src="" alt="" class="img-fluid">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">First Name</label>
                    <input class="form-control form-control-lg" type="text" placeholder="First Name">
                </div>
                <div class="col">
                    <label for="">Last Name</label>
                    <input class="form-control form-control-lg" type="text" placeholder="Last Name">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Email Address</label>
                    <input class="form-control form-control-lg" type="email" placeholder="Email Address">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <label for="">Password</label>
                    <input class="form-control form-control-lg" type="password" placeholder="Password">
                </div>
                <div class="col">
                    <label for="">Confirm Password</label>
                    <input class="form-control form-control-lg" type="password" placeholder="Confirm Password">
                </div>
            </div>
            <div class="row mb-40 form-group">
                <div class="col">
                    <button class="btn btn-primary">SUBMIT</button>
                    <a class="btn btn-disabled" href="{{ url('admin') }}">CANCEL</a>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection