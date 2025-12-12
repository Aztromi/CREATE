<section>
    <!-- Full-screen modal -->
    <div class="modal" id="loadingModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-white">
                <div class="modal-body text-center">
                    <i class="fas fa-spinner fa-spin fa-3x text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card col-12 col-md-5 mx-auto">
        <div class="card-body">
            <div class="container" id="main-content" style="display: none;">
                <div class="row">
                    <div class="col mt-4 mb-4 text-center">
                        <h2>CHANGE PASSWORD</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <form id="frm-change-password" method="POST">
                            <div class="row">
                                <div class="col-12 password-container">
                                    <label for="password_current">Current Password <span style="color: red;">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control form-control-lg" type="password" id="password_current" placeholder="Current Password" required>
                                        <i class="fas fa-eye"></i>
                                    </div>
                                    <div class="error-message text-danger pt-1" id="title-error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 password-container">
                                    <label for="password_new">New Password <span style="color: red;">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control form-control-lg" type="password" id="password_new" placeholder="New Password" required>
                                        <i class="fas fa-eye"></i>
                                    </div>
                                    <div class="error-message text-danger pt-1" id="title-error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 password-container">
                                    <label for="password_retype">Re-type Password <span style="color: red;">*</span></label>
                                    <div class="input-group">
                                        <input class="form-control form-control-lg" type="password" id="password_retype" placeholder="Re-type Password" required>
                                        <i class="fas fa-eye"></i>
                                    </div>
                                    <div class="error-message text-danger pt-1" id="title-error"></div>
                                </div>
                            </div>

                            <div class="row ml-2" id="passwordConditions" style="display: none;">
                                <div><i id="lengthIcon" class="fas fa-check"></i>&nbsp;<span>Minimum 8 characters</span></div>
                                <div><i id="uppercaseIcon" class="fas fa-check"></i>&nbsp;<span>One uppercase letter</span></div>
                                <div><i id="lowercaseIcon" class="fas fa-check"></i>&nbsp;<span>One lowercase letter</span></div>
                                <div><i id="numberIcon" class="fas fa-check"></i>&nbsp;<span>One number</span></div>
                                <div><i id="specialCharIcon" class="fas fa-check"></i>&nbsp;<span>One special character</span></div>
                                <div><i id="passwordMatchIcon" class="fas fa-check"></i>&nbsp;<span>New and re-typed password match</span></div>
                            </div>



                            <div class="row">
                                <div class="col-12 text-right">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                    <!-- <button type="reset" class="btn btn-secondary">Clear</button> -->
                                </div>
                            </div>

                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>