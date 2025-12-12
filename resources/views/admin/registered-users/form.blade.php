@extends('admin.index')

@section('contentAdmin')
 
<section>
    <h1>User</h1>
    <hr>
    <div class="mt-60 mb-60">
        <form>
            <h2>Basic Information</h2>
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
                <div class="col">
                    <label for="">Alternate Email Address</label>
                    <input class="form-control form-control-lg" type="email" placeholder="Alternate Email Address">
                </div>
            </div>
            <div class="row mb-20">
                <div class="col">
                    <label for="">Mobile number</label>
                    <input type="text" class="form-control form-control-lg" placeholder="Mobile number" >
                </div>
            </div>
            <div class="row mb-40">
                <div class="col">
                    <input class="form-check-input " type="checkbox" value="" id="messagingApp">
                    <label class="form-check-label" for="messagingApp">
                        Viber
                    </label>
                </div>
                <div class="col">
                    <input class="form-check-input" type="checkbox" value="" id="messagingApp">
                    <label class="form-check-label" for="messagingApp">
                        WhatsApp
                    </label>
                </div>
                <div class="col">
                    <input class="form-check-input" type="checkbox" value="" id="messagingApp">
                    <label class="form-check-label" for="messagingApp">
                        Others:
                    </label>
                    <br>
                    <input type="text" class="form-control form-control-lg" placeholder="Please specify">
                </div>
                <br>
            </div>
            <div class="row mb-40">
                <div class="col">
                    <label for="">Telephone number</label>
                    <input type="text" class="form-control form-control-lg" placeholder="Telephone number" >
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <h3>
                        Address
                    </h3>
                </div>
            </div>
            <div class="row mb-20">
                <div class="col">
                    <label for="">Country</label>
                    <select class="form-control form-control-lg" >
                        <option>-- Select Country --</option>
                        <option></option>
                        <option></option>
                        <option></option>
                    </select>
                </div>
                <div class="col">
                    <label for="">Region</label>
                    <select class="form-control form-control-lg" >
                        <option>-- Select Region --</option>
                        <option></option>
                        <option></option>
                        <option></option>
                    </select>
                </div>
                <div class="col">
                    <label for="">City/Town</label>
                    <select class="form-control form-control-lg" >
                        <option>-- Select City/Town --</option>
                        <option></option>
                        <option></option>
                        <option></option>
                    </select>
                </div>
                <div class="col">
                    <label for="">Area</label>
                    <select class="form-control form-control-lg" >
                        <option>-- Select Area --</option>
                        <option></option>
                        <option></option>
                        <option></option>
                    </select>
                </div>
            </div>
            <div class="row mb-40">
                <div class="col-xs-12 col-sm-3">
                    <label for="">Zipcode</label>
                    <input class="form-control form-control-lg" type="text" placeholder="Zipcode" disabled>
                </div>
                <div class="col-xs-12 col-sm-9">
                    <label for="">Address Line</label>
                    <input class="form-control form-control-lg" type="text" placeholder="Address Line">
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <h3>
                        Representation Details
                    </h3>
                </div>
            </div>
            <div class="row mt-30 mb-40">
                <div class="col-xs-12 col-sm-9">
                    <label for="">Name of Company / Academe / Association / Group / Agency</label>
                    <input type="text" class="form-control form-control-lg" placeholder="Name of Company / Academe / Association / Group / Agency">
                </div>
                <div class="col-xs-12 col-sm-3 mt-40">
                    <input class="form-check-input" type="checkbox" value="" id="category">
                    <label class="form-check-label" for="category">
                        Not applicable
                    </label>
                </div>
            </div>
            <div class="row mb-40">
                <div class="col-xs-12 col-sm-9">
                    <label for="">Job Title/Designation</label>
                    <input type="text" class="form-control form-control-lg" placeholder="">
                </div>
                <div class="col-xs-12 col-sm-3 mt-40">
                    <input class="form-check-input" type="checkbox" value="" id="category">
                    <label class="form-check-label" for="category">
                        Not applicable
                    </label>
                </div>
            </div>
            <div class="row mb-40">
                <div class="col">
                    <label for="">Representation / Category</label>
                    <select class="form-control form-control-lg" required>
                        <option>-- Select Representation / Category --</option>
                        <option>Individual / Independent / Freelance / Student</option>
                        <option>Creative Organization / Association / Group</option>
                        <option>Academe / Learning Institution</option>
                        <option>Business / Company</option>
                        <option>Government Agency</option>
                        <option>Others</option>
                    </select>
                </div>
            </div>
            <hr>
            <div class="row mb-40">
                <div class="col">
                    <h3>
                        Display Name
                    </h3>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="displayName">
                        <label class="form-check-label" for="category">
                            Full Name
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="displayName">
                        <label class="form-check-label" for="displayName">
                            Name of Company / Academe / Association / Group / Agency
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="displayName">
                        <label class="form-check-label" for="displayName">
                            Others:
                        </label>
                        <br>
                        <input type="text" class="form-control form-control-lg" placeholder="Please specify">
                    </div>
                </div>
            </div>
            <hr>
            <h2>Sectors of Interest</h2>
            <div class="row mb-40">
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="interest">
                        <label class="form-check-label" for="interest">
                            Advertising
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="interest">
                        <label class="form-check-label" for="interest">
                            Animation
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="interest">
                        <label class="form-check-label" for="interest">
                            Architecture
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="interest">
                        <label class="form-check-label" for="interest">
                            Books, Publishing
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="interest">
                        <label class="form-check-label" for="interest">
                            Comics
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="interest">
                        <label class="form-check-label" for="interest">
                            Communications & Graphic Design
                        </label>
                    </div>
                </div>
            </div>
            <hr>
            <h2>Directory Page</h2>
            <div class="row mb-30">
                <h3>
                    Activate the Creative's page in the directory.
                </h3>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="createPage">
                        <label class="form-check-label" for="createPage">
                            Yes
                        </label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="createPage">
                        <label class="form-check-label" for="createPage">
                            No
                        </label>
                    </div>
                </div>
            </div>
            <hr>
            <h2>Document Requirements</h2>
            <div class="row mb-40 vWork-1">
                <div class="col">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload sample works. <br>Accepted file types: .pdf, .jpg, .png, .gif, .mp4, or .mp3</label>
                        <input class="form-control form-control-lg" type="file" id="formFile">
                        <a class="btn addWork" id="addWorkV2">
                            <i class="fas fa-plus"></i>
                        </a>
                      </div>
                </div>
            </div>
            <div class="row mb-40 vWork-2" style="display:none">
                <div class="col">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload sample works. <br>Accepted file types: .pdf, .jpg, .png, .gif, .mp4, or .mp3</label>
                        <input class="form-control form-control-lg" type="file" id="formFile">
                        <a class="btn addWork" id="addWorkV3">
                            <i class="fas fa-plus"></i>
                        </a>
                      </div>
                </div>
            </div>
            <div class="row mb-40 vWork-3" style="display:none">
                <div class="col">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload sample works. <br>Accepted file types: .pdf, .jpg, .png, .gif, .mp4, or .mp3</label>
                        <input class="form-control form-control-lg" type="file" id="formFile">
                      </div>
                </div>
            </div>
            <div class="row mb-40">
                <div class="col">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload a valid <b>business permit</b> (for businesses) or <b>identification</b> (for individuals). <br>Accepted file types: .pdf, .png, or .jpg</label>
                        <input class="form-control form-control-lg" type="file" id="formFile">
                      </div>
                </div>
            </div>
            <div class="row mb-40">
                <div class="col">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Upload a <b>BIR Certificate of Registration</b> (for businesses). <br>Accepted file types: .pdf, .png, or .jpg</label>
                        <input class="form-control form-control-lg" type="file" id="formFile">
                      </div>
                </div>
            </div>
            <hr>
            <h2>Account Credentials</h2>
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
            <hr>
            <div class="row mb-40 form-group">
                <div class="col">
                    <button class="btn btn-primary">SUBMIT</button>
                    <a class="btn btn-disabled" href="{{ url('admin/application-requests') }}">CANCEL</a>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection