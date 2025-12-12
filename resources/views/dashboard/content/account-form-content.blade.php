{{--
<input type="hidden" name="uEmail" id="uEmail" value="">
<input type="hidden" name="uID" id="uID" value="">
--}}

<hr style="">

<div class="row">
    <div class="col mb-4">
        <h2>Basic Information</h2>
    </div>
</div>


<div class="row" id="accStates">
    <div class="col-md-3 mb-4">
        <h4>Account Type</h4>
        <span id="lbl-verified">
            -
        </span>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <input type="hidden" name="uID" id="uID" value="{{ $uID }}">
        {{--<input type="hidden" name="uEdit" id="uID" value="{{ $uEdit }}">--}}
        <label for="fname">First Name <span style="color: red;">*</span></label>
        <input class="form-control form-control-lg" type="text" id="fname" name="fname" placeholder="First Name" required>
        <div class="error-message text-danger pt-1" id="fname-error"></div>
    </div>
    <div class="col-md-6 mb-4">
        <label for="lname">Last Name <span style="color: red;">*</span></label>
        <input class="form-control form-control-lg" type="text" id="lname" name="lname" placeholder="Last Name" required>
        <div class="error-message text-danger pt-1" id="lname-error"></div>
    </div>

    <!-- NEWADDS -->
    <div class="col-md-6 mb-4">
        <label for="gender">Gender <span style="color: red;">*</span></label>
        <select id="gender" name="gender" class="form-control form-control-lg" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="prefer not to say">Prefer not to say/answer</option>
            
        </select>
        <div class="error-message text-danger pt-1" id="rep-error"></div>
    </div>
    <!-- END NEW ADDS -->
    
</div>

<div class="row brief-desc mb-4">
    <div class="col-12">
        <label for="briefDesc">Brief Description</label><br>
        <textarea name="briefDesc" id="briefDesc" rows="4" maxlength="250" class="form-control form-control-lg" placeholder="Brief Description..."></textarea>
    </div>
    <div class="col-12 taCounter">0/250</div>
</div>


        

<div class="row">
    <div class="col-md-6 mb-4">
        <label for="email">Email Address <span style="color: red;">*</span></label>
        <input class="form-control form-control-lg" type="email" id="email" name="email" placeholder="Email Address" required disabled>
        <div class="error-message text-danger pt-1" id="email-error"></div>
    </div>
    <div class="col-md-6 mb-4">
        <label for="email-alternate">Alternate Email Address</label>
        <input class="form-control form-control-lg" type="email" placeholder="Alternate Email Address" id="email-alternate" name="email-alternate">
        <small class="form-text text-muted">&emsp;&emsp;optional</small>
        <div class="error-message text-danger pt-1" id="email-alternate-error"></div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="row">
            <div class="col">
                <label for="mobile">Mobile number <span style="color: red;">*</span></label>
                <input type="tel" pattern="[0-9]*" id="mobile" name="mobile" class="form-control form-control-lg" placeholder="Mobile number" required>
                <div class="error-message text-danger pt-1" id="mobile-error"></div>
            </div>
        </div>
        <div class="row flex-nowrap">
            <div class="col pl-5">
                <input class="form-check-input " type="checkbox" value="viber" id="m_viber" name="m_viber">
                <label class="form-check-label" for="m_viber">
                    Viber
                </label>
            </div>
        </div>
        <div class="row flex-nowrap">
            <div class="col pl-5">
                <input class="form-check-input" type="checkbox" value="whatsapp" id="m_whatsapp" name="m_whatsapp">
                <label class="form-check-label" for="m_whatsapp">
                    WhatsApp
                </label>
            </div>
        </div>
        <div class="row flex-nowrap">
            <div class="col pl-5">
                <input class="form-check-input" type="checkbox" value="others" id="m_others" name="m_others">
                <label class="form-check-label" for="m_others">
                    Others:
                </label>
            </div>
        </div>
        <div class="row flex-nowrap">
            <div class="col pl-4">
                <input type="text" class="form-control form-control-lg" placeholder="Others..." id="m_text" name="m_text">
                <div class="error-message text-danger pt-1" id="m_text-error"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <label for="mobile-alternate">Alternate Mobile number</label>
        <input type="tel" pattern="[0-9]*" id="mobile-alternate" name="mobile-alternate" class="form-control form-control-lg" placeholder="Alternate Mobile Number">
        <small class="form-text text-muted">&emsp;&emsp;optional</small>
        <div class="error-message text-danger pt-1" id="mobile-alternate-error"></div>
    </div>
    <div class="col-md-6 mb-4">
        <label for="telephone">Landline number</label>
        <input type="text" pattern="[0-9]*" id="telephone" name="telephone" class="form-control form-control-lg" placeholder="Telephone number" >
        <small class="form-text text-muted">&emsp;&emsp;optional</small>
        <div class="error-message text-danger pt-1" id="telephone-error"></div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col mb-4">
        <h2>Address</h2>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <label for="country">Country <span style="color: red;">*</span></label>
        <select class="form-control select2" name="country" id="country" required>
            <option value="">-</option>
        </select>
        <div class="error-message text-danger pt-1" id="country-error"></div>
        <!-- <p class="error-message"></p> -->
    </div>
</div>

<div class="row" id="addrLocal">
    <div class="col-md-6 mb-4">
        <label for="regionM">Region <span style="color: red;">*</span></label>
        <select class="form-control form-control-lg" name="regionM" id="regionM" disabled>
            <option value="">-</option>
        </select>
        <div class="error-message text-danger pt-1" id="regionM-error"></div>
    </div>
    <div class="col-md-6 mb-4">
        <label for="provinceM">Province <span style="color: red;">*</span></label>
        <select class="form-control form-control-lg" name="provinceM" id="provinceM" disabled>
            <option value="">-</option>
        </select>
        <div class="error-message text-danger pt-1" id="provinceM-error"></div>
    </div>
    <div class="col-md-6 mb-4">
        <label for="cityM">City/Municipality <span style="color: red;">*</span></label>
        <select class="form-control form-control-lg" name="cityM" id="cityM" disabled>
            <option value="">-</option>
        </select>
        <div class="error-message text-danger pt-1" id="cityM-error"></div>
    </div>
</div>
<div class="row" id="addrIntl">
    <div class="col-md-6 mb-4">
        <label for="regionI">State/Province/Region <span style="color: red;">*</span></label>
        <input class="form-control form-control-lg" type="text" id="regionI" name="regionI"  placeholder="State/Province/Region">
    </div>
    <div class="col-md-6 mb-4">
        <label for="cityI">City <span style="color: red;">*</span></label>
        <input class="form-control form-control-lg" type="text" id="cityI" name="cityI"  placeholder="City">
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <label for="addr1">Address Line 1</label>
        <input class="form-control form-control-lg" type="text" id="addr1" name="addr1"  placeholder="Address Line 1">
    </div>
    <!-- <div class="col-12 mb-4">
        <label for="addr2">Address Line 2</label>
        <input class="form-control form-control-lg" type="text" id="addr2" name="addr2"  placeholder="Address Line 2">
    </div> -->
    <div class="col-md-6 mb-4">
        <label for="zip">Zipcode</label>
        <input class="form-control form-control-lg" type="text" id="zip" name="zip" placeholder="Zipcode">
    </div>
</div>


<hr>



<div class="row">
    <div class="col mb-4">
        <h2>Representation</h2>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <label for="rep">Representation / Category <span style="color: red;">*</span></label>
        <select id="rep" name="rep" class="form-control form-control-lg" required>
            <option value="">Select Representation / Category</option>
            <option value="Individual / Independent / Freelance / Student">Individual / Independent / Freelance / Student</option>
            <option value="Creative Organization / Association / Group">Creative Organization / Association / Group</option>
            <option value="Academe / Learning Institution">Academe / Learning Institution</option>
            <option value="Business / Company">Business / Company</option>
            <option value="Government Agency">Government Agency</option>
            <option value="Others">Others</option>
        </select>
        <div class="error-message text-danger pt-1" id="rep-error"></div>
    </div>
</div>

<!-- NEWUPDATES -->

<div id="optCompany">

    <div class="row">
        <div class="col-12 mb-4">
            <label for="org">Name of Company <span style="color: red;">*</span></label>
            <input type="text" id="org" name="org" class="form-control form-control-lg" placeholder="Name of Company / Academe / Association / Group / Agency">
            <div class="error-message text-danger pt-1" id="org-error"></div>
        </div>
    </div>

    <br><br>
    <!-- Company Address -->

    <div class="row">
        <div class="col mb-4 text-center">
            <h3 id="head_rep_address">Company Address</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <label for="co_country">Country <span style="color: red;">*</span></label>
            <select class="form-control form-control-lg select2" name="co_country" id="co_country">
                <option value="">-</option>
                
            </select>
            <div class="error-message text-danger pt-1" id="co_country-error"></div>
        </div>
    </div>

    
    <div class="row" id="co_addrLocal">
        <div class="col-md-6 mb-4">
            <label for="co_regionM">Region <span style="color: red;">*</span></label>
            <select class="form-control form-control-lg" name="co_regionM" id="co_regionM" disabled>
            </select>
            <div class="error-message text-danger pt-1" id="co_regionM-error"></div>
        </div>
        <div class="col-md-6 mb-4">
            <label for="co_provinceM">Province <span style="color: red;">*</span></label>
            <select class="form-control form-control-lg" name="co_provinceM" id="co_provinceM" disabled>
            </select>
            <div class="error-message text-danger pt-1" id="co_provinceM-error"></div>
        </div>
        <div class="col-md-6 mb-4">
            <label for="co_cityM">City/Municipality <span style="color: red;">*</span></label>
            <select class="form-control form-control-lg" name="co_cityM" id="co_cityM" disabled>
            </select>
            <div class="error-message text-danger pt-1" id="co_cityM-error"></div>
        </div>
        <!-- <div class="col-md-6 mb-4">
            <label for="country">Barangay</label>
            <select class="form-control form-control-lg" name="brgyM" id="brgyM" disabled>
            </select>
            <div class="error-message text-danger pt-1" id="brgyM-error"></div>
        </div> -->
    </div>
    <div class="row" id="co_addrIntl">
        <div class="col-md-6 mb-4">
            <label for="co_regionI">State/Province/Region <span style="color: red;">*</span></label>
            <input class="form-control form-control-lg" type="text" id="co_regionI" name="co_regionI"  placeholder="State/Province/Region">
            <div class="error-message text-danger pt-1" id="co_regionI-error"></div>
        </div>
        <div class="col-md-6 mb-4">
            <label for="co_cityI">City <span style="color: red;">*</span></label>
            <input class="form-control form-control-lg" type="text" id="co_cityI" name="co_cityI"  placeholder="City">
            <div class="error-message text-danger pt-1" id="co_cityI-error"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4">
            <label for="co_addr1">Address Line 1</label>
            <input class="form-control form-control-lg" type="text" id="co_addr1" name="co_addr1"  placeholder="Address Line 1">
        </div>
        <!-- <div class="col-12 mb-4">
            <label for="addr2">Address Line 2</label>
            <input class="form-control form-control-lg" type="text" id="addr2" name="addr2"  placeholder="Address Line 2">
        </div> -->
        <div class="col-md-6 mb-4">
            <label for="co_zip">Zipcode</label>
            <input class="form-control form-control-lg" type="text" id="co_zip" name="co_zip" placeholder="Zipcode">
        </div>
    </div>

    <!-- END Company Address -->

    <br><br>

    <div class="row">
        <div class="col mb-4 text-center">
            <h3 id="head_rep_details">Company Details</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <label for="co_size">Company Size<span style="color: red;">*</span></label>
            <select id="co_size" name="co_size" class="form-control form-control-lg">
                <option value="">Select Company Size</option>
                <option value="Micro (Less than or equal to 3M)">Micro (Less than or equal to 3M)</option>
                <option value="Small (More than 3M but Less than or equal to 15M)">Small (More than 3M but Less than or equal to 15M)</option>
                <option value="Medium (More than 15M but Less than or equal to 100M)">Medium (More than 15M but Less than or equal to 100M)</option>
                <option value="Large (More than 100M)">Large (More than 100M)</option>
                <option value="Not Applicable">Not Applicable</option>
            </select>
            <div class="error-message text-danger pt-1" id="rep-error"></div>
        </div>
        
        <div class="col-md-6 mb-4">
            <label for="co_direct">No. Direct Workers <span style="color: red;">*</span></label>
            <input class="form-control form-control-lg" type="number" id="co_direct" name="co_direct" placeholder="Direct Workers">
            <div class="error-message text-danger pt-1" id="co_direct-error"></div>
        </div>
        <div class="col-md-6 mb-4">
            <label for="co_indirect">No. of Indirect Workers <span style="color: red;">*</span></label>
            <input class="form-control form-control-lg" type="number" id="co_indirect" name="co_indirect" placeholder="Indirect Workers">
            <div class="error-message text-danger pt-1" id="co_indirect-error"></div>
        </div>
    </div>



    <br><br>

    <div class="row">
        <div class="col mb-4 text-center">
            <h3>Representative Details</h3>
        </div>
    </div>

    <div class="row" id="repPersonGroup">
        <div class="col-md-6 mb-4">
            <label for="rep_fname">Representative First Name <span style="color: red;">*</span></label>
            <input class="form-control form-control-lg" type="text" id="rep_fname" name="rep_fname" placeholder="First Name">
            <div class="error-message text-danger pt-1" id="rep_fname-error"></div>
        </div>
        <div class="col-md-6 mb-4">
            <label for="rep_lname">Representative Last Name <span style="color: red;">*</span></label>
            <input class="form-control form-control-lg" type="text" id="rep_lname" name="rep_lname" placeholder="Last Name">
            <div class="error-message text-danger pt-1" id="rep_lname-error"></div>
        </div>
    
        <!-- NEWADDS -->
        <div class="col-md-6 mb-4">
            <label for="rep_gender">Gender <span style="color: red;">*</span></label>
            <select id="rep_gender" name="rep_gender" class="form-control form-control-lg">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="prefer not to say">Prefer not to say/answer</option>
                
            </select>
            <div class="error-message text-danger pt-1" id="rep_gender-error"></div>
        </div>
        <!-- END NEW ADDS -->
    
        <div class="col-md-6 mb-4">
            <label for="rep_email">Representative Email Address <span style="color: red;">*</span></label>
            <input class="form-control form-control-lg" type="email" id="rep_email" name="rep_email" placeholder="Email Address">
            <div class="error-message text-danger pt-1" id="rep_email-error"></div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="row">
                <div class="col">
                    <label for="rep_mobile">Representative Mobile number <span style="color: red;">*</span></label>
                    <input type="tel" pattern="[0-9]*" id="rep_mobile" name="rep_mobile" class="form-control form-control-lg" placeholder="Mobile number">
                    <div class="error-message text-danger pt-1" id="rep_mobile-error"></div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <label for="job">Job Title/Designation <span style="color: red;">*</span></label>
                    <input type="text" id="job" name="job" class="form-control form-control-lg mb-1" placeholder="">
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-right">
                    <button type="button" id="jobsAdd" class="btn btn-secondary">Add Job Title/Designation</button>
                </div>
            </div>
            <div class="row mt-3 px-4">
                <div class="col-12">
                    <table id="jobsList" class="table table-light table-hover" style="display: none;">
                        <thead class="thead-light">
                            <tr>
                                <th></th>
                                <th>Job Title/Designation</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <input type="hidden" name="jobsArr" id="jobsArr" name="jobsArr">
                    <div class="error-message text-danger pt-1" id="jobsArr-error"></div>
                </div>
            </div>
        </div>
    </div>

    <br><br>


    <div class="row">
        <div class="col mb-4 text-center">
            <h3>Owner Details</h3>
        </div>
    </div>

    <div class="row">
    
        <div class="col-12 mb-4">
            <input class="form-check-input " type="checkbox" value="1" id="same_rep_owner" name="same_rep_owner">
            <label class="form-check-label" for="same_rep_owner">
                Same as Representative Details
            </label>
        </div>
        <div class="col-md-6 mb-4">
            <label for="owner_fname">Owner First Name <span style="color: red;">*</span></label>
            <input class="form-control form-control-lg" type="text" id="owner_fname" name="owner_fname" placeholder="First Name">
            <div class="error-message text-danger pt-1" id="owner_fname-error"></div>
        </div>
        <div class="col-md-6 mb-4">
            <label for="owner_lname">Owner Last Name <span style="color: red;">*</span></label>
            <input class="form-control form-control-lg" type="text" id="owner_lname" name="owner_lname" placeholder="Last Name">
            <div class="error-message text-danger pt-1" id="owner_lname-error"></div>
        </div>

        

        <!-- NEWADDS -->
        <div class="col-md-6 mb-4">
            <label for="owner_gender">Owner Gender <span style="color: red;">*</span></label>
            <select id="owner_gender" name="owner_gender" class="form-control form-control-lg">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="prefer not to say">Prefer not to say/answer</option>
                
            </select>
            <div class="error-message text-danger pt-1" id="owner_gender-error"></div>
        </div>
        <!-- END NEW ADDS -->

        <div class="col-md-6 mb-4">
            <label for="owner_email">Owner Email Address <span style="color: red;">*</span></label>
            <input class="form-control form-control-lg" type="email" id="owner_email" name="owner_email" placeholder="Email Address">
            <div class="error-message text-danger pt-1" id="owner_email-error"></div>
        </div>

        {{--
        <div class="col-md-6 mb-4">
            <label for="owner_mobile">Owner Mobile number <span style="color: red;">*</span></label>
            <input type="tel" pattern="[0-9]*" id="owner_mobile" name="owner_mobile" class="form-control form-control-lg" placeholder="Mobile number">
            <div class="error-message text-danger pt-1" id="owner_mobile-error"></div>
        </div>
        --}}
        
    </div>

    

</div>

<!-- END NEWUPDATES -->





<hr>



<div class="row">
    <div class="col mb-4">
        <h2>Privacy</h2>
    </div>
</div>

<div class="row pl-4">
    <div class="col-md-4">
        <input class="form-check-input " type="checkbox" value="viber" id="hEmail" name="hEmail">
        <label class="form-check-label" for="hEmail">
            Hide E-mail
        </label>
    </div>
    <div class="col-md-4">
        <input class="form-check-input" type="checkbox" value="whatsapp" id="hContact" name="hContact">
        <label class="form-check-label" for="hContact">
            Hide Contact Numbers
        </label>
    </div>
    <div class="col-md-4">
        <input class="form-check-input" type="checkbox" value="others" id="hAddress" name="hAddress">
        <label class="form-check-label" for="hAddress">
            Hide Address
        </label>
    </div>
</div>

<hr>



<div class="row">
    <div class="col mb-4">
        <h2>Social Media Accounts and Websites</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <label for="facebook">Facebook</label>
        <input type="text" id="facebook" name="facebook" class="form-control form-control-lg mb-1" placeholder="">
        <div class="error-message text-danger pt-1" id="facebook-error"></div>
    </div>
    <div class="col-md-6 mb-4">
        <label for="instagram">Instagram</label>
        <input type="text" id="instagram" name="instagram" class="form-control form-control-lg mb-1" placeholder="">
        <div class="error-message text-danger pt-1" id="instagram-error"></div>
    </div>
    <div class="col-md-6 mb-4">
        <label for="twitter">Twitter</label>
        <input type="text" id="twitter" name="twitter" class="form-control form-control-lg mb-1" placeholder="">
        <div class="error-message text-danger pt-1" id="twitter-error"></div>
    </div>
    <div class="col-md-6 mb-4">
        <label for="youtube">Youtube</label>
        <input type="text" id="youtube" name="youtube" class="form-control form-control-lg mb-1" placeholder="">
        <div class="error-message text-danger pt-1" id="youtube-error"></div>
    </div>
    <div class="col-md-6 mb-4">
        <label for="tiktok">Tiktok</label>
        <input type="text" id="tiktok" name="tiktok" class="form-control form-control-lg mb-1" placeholder="">
        <div class="error-message text-danger pt-1" id="tiktok-error"></div>
    </div>
    <div class="col-md-6 mb-4">
        <label for="behance">Behance</label>
        <input type="text" id="behance" name="behance" class="form-control form-control-lg mb-1" placeholder="">
        <div class="error-message text-danger pt-1" id="behance-error"></div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-12">
                <label for="web">Website/s</label>
                <input type="url" id="web" name="web" class="form-control form-control-lg mb-1" placeholder="">
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-right">
                <button type="button" id="webAdd" class="btn btn-secondary">Add Website</button>
            </div>
        </div>
        <div class="row mt-3 px-4">
            <div class="col-12">
                <table id="webList" class="table table-light table-hover" style="display: none;">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>Websites</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <input type="hidden" name="webArr" id="webArr">
                <div class="error-message text-danger pt-1" id="webArr-error"></div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col mb-4">
        <h2>Display Name <span style="color: red;">*</span></h2>
    </div>
</div>

<div class="row pl-4">
    <div class="col-md-4">
        <input class="form-check-input" type="radio" value="fullname" name="dispName" id="nameRadioFull">
        <label class="form-check-label" for="nameRadioFull">
            Full Name
        </label>
    </div>
    
    <!-- NEWUPDATES -->
    <div class="col-md-4 pr-5" id="dispNameCompany">
        <input class="form-check-input" type="radio" value="company_name" name="dispName" id="nameRadioCompany">
        <label class="form-check-label" for="nameRadioCompany">
            Name of Company / Academe / Association / Group / Agency
        </label>
    </div>
    <!-- END NEWUPDATES -->

    <div class="col-md-4">
        <div class="row">
            <div class="col-12">
                <input class="form-check-input" type="radio" value="other_name" name="dispName" id="nameRadioOther">
                <label class="form-check-label" for="nameRadioOther">
                    Others:
                </label>
            </div>
            <div class="col-12">
                <input type="text" class="form-control form-control-lg" placeholder="Please specify" id="name-other" name="name-other" disabled hidden>
                <div class="error-message text-danger pt-1" id="name-other-error"></div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="error-message text-danger pt-1" id="dispName-error"></div>
    </div>
</div>

<hr>

<input type="hidden" name="oth" id="oth">

<div class="row">
    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-12">
                <h2>Sectors of Interest <span style="color: red;">*</span></h2>
            </div>
            <div class="col-12">
                <select name="interests[]" id="interests" class="form-control select2" multiple="multiple" style="width: 100%;" required>
                    <option value="">-</option>
                </select>
                <div class="p-2">
                    <button type="button" id="btnOthInt" class="btn btn-secondary">Other Sectors of Interest (Not in List)</button>
                </div>
                <div class="error-message text-danger pt-1" id="interests-error"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-12">
                <h2>Area of Expertise <span style="color: red;">*</span></h2>
            </div>
            <div class="col-12">
                <select name="expertises[]" id="expertises" class="form-control select2" multiple="multiple" style="width: 100%;" required>
                    <option value="">-</option>
                </select>
                <div class="p-2">
                    <button type="button" id="btnOthExp" class="btn btn-secondary">Other Expertise (Not in List)</button>
                </div>
                <div class="error-message text-danger pt-1" id="expertises-error"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <label for="expertises">Main Creative Services Offered <span style="color: red;">*</span></label>
        <select name="main-expertise" id="main-expertise" class="form-control select2" required>
            <option value="">-</option>
        </select>
        <div class="p-2">
            <button type="button" id="btnOthMainExp" class="btn btn-secondary">Other Main Services Offered (Not in List)</button>
        </div>
        <div class="error-message text-danger pt-1" id="main-expertise-error"></div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col mb-4">
        <h2>List of Clients</h2>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-12">
                <label for="clientName">Enter Client Name:</label>
                <input type="text" id="clientName" name="clientName" class="form-control form-control-lg mb-1" maxlength="150">
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-right">
                <button type="button" id="clientAdd" class="btn btn-secondary">Add Client</button>
            </div>
        </div>
        <div class="row mt-3 px-4">
            <div class="col-12">
                <table id="clientsList" class="table table-light table-hover" style="display: none;">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>Client Names</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <input type="hidden" name="clientsArr" id="clientsArr" name="clientsArr">
                <div class="error-message text-danger pt-1" id="clientsArr-error"></div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col mb-4">
        <h2>Awards and Recognitions</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <label for="award">Name of Award or Recognition:</label>
        <input type="text" id="award" name="award" class="form-control form-control-lg mb-3" />
    </div>
    <div class="col-md-6 mb-4">
        <label for="presenter">Presented or Given By:</label>
        <input type="text" maxlength="50" id="presenter" name="presenter" class="form-control form-control-lg mb-3"  />
    </div>
    <div class="col-md-6 mb-4">
        <label for="presentYear">Year Given:</label>
        <input type="number" min="1000" max="9999" pattern="\d{4}" id="presentYear" name="presentYear" class="form-control form-control-lg mb-1"   />
    </div>
</div>

<div class="row">
    <div class="col-12 text-right">
        <button type="button" id="awardAdd" class="btn btn-secondary align-bottom">Add Award / Recognition</button>
    </div>
</div>

<div class="row mt-3 px-4">
    <div class="col-12">
        <table id="awardsList" class="table table-light table-hover" style="display: none;">
            <thead class="thead-light">
                <tr>
                    <th></th>
                    <th>Award</th>
                    <th>Presented By</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <input type="hidden" name="awardsArr" id="awardsArr">
        <div class="error-message text-danger pt-1" id="awardsArr-error"></div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col mb-4">
        <h2>Document Requirements</h2>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-12">
                <h3>Sample Works</h3>
            </div>
            <div class="col-12 px-4">
                <table id="portfolioList" class="table table-light table-hover" style="display: none;">
                    <thead class="thead-light">
                        <tr>
                            <th>Filename</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="error-message text-danger pt-1" id="portfolioList-error"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-12">
                <h3>Drive Link</h3>
            </div>
            <div class="col-12 px-4" id="driveLink">
                -
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-12">
                <h3>Business Permit / Identification</h3>
            </div>
            <div class="col-12 px-4">
                <table id="govDocList" class="table table-light table-hover" style="display: none;">
                    <thead class="thead-light">
                        <tr>
                            <th>Filename</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="error-message text-danger pt-1" id="govDocList-error"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-12">
                <h3>Certification of Registration</h3>
            </div>
            <div class="col-12 px-4">
                <table id="birList" class="table table-light table-hover" style="display: none;">
                    <thead class="thead-light">
                        <tr>
                            <th>Filename</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="error-message text-danger pt-1" id="birList-error"></div>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-12 mb-4 text-right">
        <button type="submit" class="btn btn-primary btn-lg">Update</button>
    </div>
</div>