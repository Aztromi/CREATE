@extends('layouts.app')

@section('content')

<section class="bg_light_grey">
    <div class="container-fluid">
        {{-- insert url to creative banner in in-line style --}}
        <div class="creative-banner" style="background-image: url(https://createphilippines.com/upload/stories/CreatePHHati-dKrcNsnX.png">
            {{-- EDIT Function --}}
            <div class="edit-fn-holder bottom">
                <button class="btn" title="Update cover photo" data-toggle="modal" data-target="#modalUpdateCoverPhoto">
                    <i class="fa fa-edit"></i>
                </button>
            </div>
        </div>
        
        <div class="row">
            <div class="col-col-xs-12 col-sm-1"></div>
            <div class="col-col-xs-12 col-sm-3">
                <div class="left-hand">
                    <div class="profile-container">
                        <div class="profile-img-holder">
                            <img src="{{ url('/img/default_profile_img.png') }}" alt="Display Name" class="img-fluid">
                            <img src="{{ url('/img/verified.png') }}" alt="Verified Creative">
                            {{-- EDIT Function --}}
                            <div class="edit-fn-holder top">
                                <button class="btn" title="Update profile photo" data-toggle="modal" data-target="#modalUpdateProfilePhoto">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        <div class="display-name-holder">
                            <h1>
                                {{-- Insert Display Name --}}
                                DISPLAY NAME
                            </h1>
                            
                            {{-- EDIT Function --}}
                            <div class="edit-fn-holder bottom-off25">
                                <button class="btn" title="Update display name" data-toggle="modal" data-target="#modalUpdateDisplayName">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        <div class="profile-contact-holder">
                            <dl>
                                <dd>Address</dd>
                                    <dt>
                                        {{-- Insert Address --}}
                                        Manila, Philippines

                                        {{-- EDIT Function --}}
                                        <div class="edit-fn-holder-float">
                                            <button class="btn" title="Update address" data-toggle="modal" data-target="#modalUpdateAddress">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </div>
                                    </dt>
                                <dd>Email Address</dd>
                                    <dt>
                                        {{-- Insert Email Address --}}
                                        sample@email.com

                                        {{-- EDIT Function --}}
                                        <div class="edit-fn-holder-float">
                                            <button class="btn" title="Update email address" data-toggle="modal" data-target="#modalUpdateEmailAddress">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </div>
                                    </dt>
                                <dd>Website</dd>
                                    {{-- Insert Website/s --}}
                                    <dt>
                                        <a href="#">email.com<i class="fa fa-external-link-alt"></i></a>

                                        {{-- EDIT Function --}}
                                        <div class="edit-fn-holder-float">
                                            <button class="btn" title="Update website" data-toggle="modal" data-target="#modalUpdateWebsite">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </div>
                                    </dt>
                            </dl>
                        </div>
                        <div class="profile-social-holder">
                            <dl>
                                <dd>Follow this creative on social!</dd>
                            </dl>
                            <ul>
                                {{-- Insert available social media links --}}
                                <li>
                                    <a href="">
                                        <i class="fa-brands fa-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <i class="fa-brands fa-youtube"></i>
                                    </a>
                                </li>
                                <li> 
                                    <a href="">
                                        <i class="fa-brands fa-tiktok"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <i class="fa-brands fa-behance"></i>
                                    </a>
                                </li>
                            </ul>

                            {{-- EDIT Function --}}
                            <div class="edit-fn-holder top">
                                <button class="btn" title="Update social media links" data-toggle="modal" data-target="#modalUpdateSocialMedia">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-col-xs-12 col-sm-7">
                <div class="right-hand">
                    <div class="profile-container creative-profile">
                        <h2>
                            Contact Details
                        </h2>
                        <dl>
                            <dd>NAME & DESIGNATION</dd>
                                {{-- Insert Contact Person Name and designation --}}
                                <dt>
                                    CONTACT PERSON NAME
                                    <br><span>Designation</span>

                                    {{-- EDIT Function --}}
                                    <div class="edit-fn-holder-float">
                                        <button class="btn" title="Update name and designation" data-toggle="modal" data-target="#modalUpdateNameDesignation">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </div>
                                </dt>
                            <dd>EMAIL ADDRESS</dd>
                                {{-- Insert Email Address here --}}
                                <dt>
                                    <a href="">email@sample.com</a>

                                    {{-- EDIT Function --}}
                                    <div class="edit-fn-holder-float">
                                        <button class="btn" title="Update email address" data-toggle="modal" data-target="#modalUpdateContactEmailAddress">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </div>
                                </dt>
                        </dl>
                        <hr>
                        <h3>
                            About the Company / Business / Individual
                        </h3>
                        {{-- Insert Description here --}}
                        <p>
                            Pixel Perfect is a dynamic graphic design company specializing in creating visual communication solutions for businesses across industries. With a team of highly skilled designers, they offer a range of services including branding, print and digital design, web development, and marketing collateral. Their attention to detail, creativity and ability to tailor designs to clients’ needs have helped them build a strong reputation for delivering exceptional work that truly stands out.
                        </p>

                        {{-- EDIT Function --}}
                        <div class="edit-fn-holder-float">
                            <button class="btn" title="Update description" data-toggle="modal" data-target="#modalUpdateDescription">
                                <i class="fa fa-edit"></i>
                            </button>
                        </div>
                    </div>
                    <div class="profile-container creative-profile mt-60">
                        <h2>
                            Expertise Classification
                        </h2>
                        <dl>
                            <dd>CATEGORY</dd>
                                {{-- Insert category --}}
                                <dt>
                                    Company/Business

                                    {{-- EDIT Function --}}
                                    <div class="edit-fn-holder-float">
                                        <button class="btn" title="Update category" data-toggle="modal" data-target="#modalUpdateCategory">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </div>
                                </dt>
                            <hr>
                            <dd>SERVICES</dd>
                                {{-- Insert EXPERTISE AND SERVICES --}}
                                <dt>
                                    Graphic Design

                                    {{-- EDIT Function --}}
                                    <div class="edit-fn-holder-float">
                                        <button class="btn" title="Update services" data-toggle="modal" data-target="#modalUpdateServices">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </div>
                                </dt>
                            <hr>
                            <dd>AREA/S OF EXPERTISE</dd>
                                {{-- Insert AREA/S OF EXPERTISE --}}
                                <dt>
                                    Visual Design, Branding Direction

                                    {{-- EDIT Function --}}
                                    <div class="edit-fn-holder-float">
                                        <button class="btn" title="Update area/s of expertise" data-toggle="modal" data-target="#modalUpdateExpertise">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </div>
                                </dt>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-col-xs-12 col-sm-1"></div>
        </div>
    </div>
</section>

  
<!-- COVER PHOTO -->
<div class="modal fade modal-lg" id="modalUpdateCoverPhoto" tabindex="-1" role="dialog" aria-labelledby="modalUpdateCoverPhotoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUpdateCoverPhotoLabel">
            Update Cover Photo
          </h5>
        </div>
        <div class="modal-body">
          <form action="">
            <div class="row mb-30">
                <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label mb-20">
                            Accepted file types: <b>.png or .jpg</b>
                            <br>Recommendations:
                            <br>Dimension - <b>1920px (w) by 432px (h)</b>
                            <br>Resolution - <b>72dpi</b>
                            <br>File size - <b>Less than 1MB</b>
                        </label>
                        <input class="form-control" type="file" id="" value="">
                      </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <button class="btn btn-primary" type="button">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<!-- PROFILE PHOTO -->
<div class="modal fade modal-lg" id="modalUpdateProfilePhoto" tabindex="-1" role="dialog" aria-labelledby="modalUpdateProfilePhotoLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUpdateProfilePhotoLabel">
            Update Profile Photo
          </h5>
        </div>
        <div class="modal-body">
          <form action="">
            <div class="row mb-30">
                <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label mb-20">
                            Accepted file types: <b>.png or .jpg</b>
                            <br>Recommendations:
                            <br>Dimension - <b>300px (w) by 300px (h)</b>
                            <br>Resolution - <b>72dpi</b>
                            <br>File size - <b>Less than 1MB</b>
                        </label>
                        <input class="form-control" type="file" id="" value="">
                      </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <button class="btn btn-primary" type="button">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<!-- DISPLAY NAME -->
<div class="modal fade modal-lg" id="modalUpdateDisplayName" tabindex="-1" role="dialog" aria-labelledby="modalUpdateDisplayNameLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUpdateDisplayNameLabel">
            Update Display Name
          </h5>
        </div>
        <div class="modal-body">
          <form action="">
            <div class="row mb-30">
                <div class="col">
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
                        <input type="text" class="form-control" placeholder="Please specify">
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <button class="btn btn-primary" type="button">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<!-- Address -->
<div class="modal fade modal-lg" id="modalUpdateAddress" tabindex="-1" role="dialog" aria-labelledby="modalUpdateAddressLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUpdateAddressLabel">
            Update Address
          </h5>
        </div>
        <div class="modal-body">
          <form action="">
            <div class="row mb-30">
                <div class="col">
                    <select class="form-control" id="country">
                        <option value="">-- Select Country --</option>
                        <option value="Philippines">Philippines</option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <select class="form-control" id="region">
                        <option value="">-- Select Region --</option>
                        <option value="NCR">NCR</option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <select class="form-control" id="province">
                        <option value="">-- Select Province --</option>
                        <option value="Metro Manila">Metro Manila</option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <select class="form-control" id="city_town">
                        <option value="">-- Select City/Town --</option>
                        <option value="Pasay City">Pasay City</option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <select class="form-control" id="area">
                        <option value="">-- Select Area --</option>
                        <option value="Mall of Asia Complex (MOA)">Mall of Asia Complex (MOA)</option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Zipcode" id="zipcode" value="1300" disabled>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Adress Line" id="address_line">
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <button class="btn btn-primary" type="button">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<!-- Email Address -->
<div class="modal fade modal-lg" id="modalUpdateEmailAddress" tabindex="-1" role="dialog" aria-labelledby="modalUpdateEmailAddressLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUpdateEmailAddressLabel">
            Update Email Address
          </h5>
        </div>
        <div class="modal-body">
          <form action="">
            <div class="row mb-30">
                <div class="col">
                    <input type="email" class="form-control" placeholder="Email address" value="">
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <button class="btn btn-primary" type="button">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<!-- Website -->
<div class="modal fade modal-lg" id="modalUpdateWebsite" tabindex="-1" role="dialog" aria-labelledby="modalUpdateWebsiteLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUpdateWebsiteLabel">
            Update Website
          </h5>
        </div>
        <div class="modal-body">
          <form action="">
            <div class="row mb-30">
                <div class="col">
                    <input type="email" class="form-control" placeholder="Website" value="">
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <button class="btn btn-primary" type="button">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<!-- Social Media -->
<div class="modal fade modal-lg" id="modalUpdateSocialMedia" tabindex="-1" role="dialog" aria-labelledby="modalUpdateSocialMediaLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUpdateSocialMediaLabel">
            Update Social Media
          </h5>
        </div>
        <div class="modal-body">
          <form action="">
            <div class="row mb-30">
                <div class="col">
                    <label for="">Facebook</label>
                    <div class="input-group">
                        <span id="basic-addon3" class="input-group-text">https://www.facebook.com/</span> 
                        <input type="text" name="facebook" placeholder="" value="" maxlength="200" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <label for="">Instagram</label>
                    <div class="input-group">
                        <span id="basic-addon3" class="input-group-text">https://www.instagram.com/</span> 
                        <input type="text" name="instagram" placeholder="" value="" maxlength="200" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <label for="">Twitter</label>
                    <div class="input-group">
                        <span id="basic-addon3" class="input-group-text">https://www.twitter.com/</span> 
                        <input type="text" name="twitter" placeholder="" value="" maxlength="200" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <label for="">YouTube</label>
                    <div class="input-group">
                        <span id="basic-addon3" class="input-group-text">https://www.youtube.com/</span> 
                        <input type="text" name="youtube" placeholder="" value="" maxlength="200" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <label for="">Tiktok</label>
                    <div class="input-group">
                        <span id="basic-addon3" class="input-group-text">https://www.tiktok.com/</span> 
                        <input type="text" name="tiktok" placeholder="" value="" maxlength="200" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <label for="">Behance</label>
                    <div class="input-group">
                        <span id="basic-addon3" class="input-group-text">https://www.behance.com/</span> 
                        <input type="text" name="behance" placeholder="" value="" maxlength="200" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <label for="">Other</label>
                    <div class="input-group">
                        <span id="basic-addon3" class="input-group-text">https://</span> 
                        <input type="text" name="other" placeholder="" value="" maxlength="200" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <button class="btn btn-primary" type="button">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<!-- Contact Name and Designation -->
<div class="modal fade modal-lg" id="modalUpdateNameDesignation" tabindex="-1" role="dialog" aria-labelledby="modalUpdateNameDesignationLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUpdateNameDesignationLabel">
            Update Contact Person Name & Designation
          </h5>
        </div>
        <div class="modal-body">
          <form action="">
            <div class="row mb-30">
                <div class="col">
                    <input type="email" class="form-control" placeholder="First Name" value="">
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <input type="email" class="form-control" placeholder="Last Name" value="">
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <input type="email" class="form-control" placeholder="Designation" value="">
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <button class="btn btn-primary" type="button">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<!-- Contact Email Address -->
<div class="modal fade modal-lg" id="modalUpdateContactEmailAddress" tabindex="-1" role="dialog" aria-labelledby="modalUpdateContactEmailAddressLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUpdateContactEmailAddressLabel">
            Update Contact Email Address
          </h5>
        </div>
        <div class="modal-body">
          <form action="">
            <div class="row mb-30">
                <div class="col">
                    <input type="email" class="form-control" placeholder="Email Address" value="">
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <button class="btn btn-primary" type="button">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<!-- Description -->
<div class="modal fade modal-lg" id="modalUpdateDescription" tabindex="-1" role="dialog" aria-labelledby="modalUpdateDescriptionLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUpdateDescriptionLabel">
            Update Description
          </h5>
        </div>
        <div class="modal-body">
          <form action="">
            <div class="row mb-30">
                <div class="col">
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" id="textAreaProfileDescription">
                        Update your profile description
                    </textarea>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <button class="btn btn-primary" type="button">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<!-- Category -->
<div class="modal fade modal-lg" id="modalUpdateCategory" tabindex="-1" role="dialog" aria-labelledby="modalUpdateCategoryLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUpdateCategoryLabel">
            Update Category
          </h5>
        </div>
        <div class="modal-body">
          <form action="">
            <div class="row mb-30">
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Advertising
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Animation
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Architecture
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Books, Publishing
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Comics
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Communications & Graphic Design
                        </label>
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <button class="btn btn-primary" type="button">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<!-- Services -->
<div class="modal fade modal-lg" id="modalUpdateServices" tabindex="-1" role="dialog" aria-labelledby="modalUpdateServicesLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUpdateServicesLabel">
            Update Services
          </h5>
        </div>
        <div class="modal-body">
          <form action="">
            <div class="row mb-30">
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Advertising
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Animation
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Architecture
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Books, Publishing
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Comics
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Communications & Graphic Design
                        </label>
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <button class="btn btn-primary" type="button">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<!-- Expertise -->
<div class="modal fade modal-lg" id="modalUpdateExpertise" tabindex="-1" role="dialog" aria-labelledby="modalUpdateExpertiseLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUpdateExpertiseLabel">
            Update Expertise
          </h5>
        </div>
        <div class="modal-body">
          <form action="">
            <div class="row mb-30">
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Advertising
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Animation
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Architecture
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Books, Publishing
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Comics
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 pb-20">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="">
                        <label class="form-check-label" for="">
                            Communications & Graphic Design
                        </label>
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col">
                    <button class="btn btn-primary" type="button">
                        <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

@endsection