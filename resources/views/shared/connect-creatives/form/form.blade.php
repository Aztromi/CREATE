<section>
    <div class="modal" id="loadingModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-white">
                <div class="modal-body text-center">
                    <i class="fas fa-spinner fa-spin fa-3x text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card col-lg-12 col-xl-10 mx-auto">
        <div class="card-body">
            <div class="container" id="main-content" style="display: none;">
                <div class="row">
                    <div class="col mt-4 mb-4 text-center">
                        <h1>Connect with a Creative</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <form id="frm-connect-creative" method="POST" action="{{ $options->action_link }}" enctype="multipart/form-data">
                            @csrf

                            {{-- Guest Information --}}
                            @if($options->guest)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label for="name">Name <span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" id="name" name="name" required>
                                        <div class="error-message text-danger pt-1" id="name-error"></div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label for="company_name">Company Name <span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" id="company_name" name="company_name" required>
                                        <div class="error-message text-danger pt-1" id="company_name-error"></div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label for="company_email">Company e-mail <span style="color: red;">*</span></label>
                                        <input class="form-control" type="email" id="company_email" name="company_email" required>
                                        <div class="error-message text-danger pt-1" id="company_email-error"></div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label for="country">Country <span style="color: red;">*</span></label>
                                        <select class="form-control" id="country" name="country" required>
                                        <option value="">-</option>
                                        @foreach($options->countries as $value)
                                            <option value="{{ $value->name }}">{{ $value->name }}</option>
                                        @endforeach
                                        </select>
                                        
                                        <div class="error-message text-danger pt-1" id="country-error"></div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label for="company_address">Company address <span style="color: red;">*</span></label>
                                        <textarea class="w-100" rows="5" name="company_address" id="company_address" required></textarea>
                                        <div class="error-message text-danger pt-1" id="company_address-error"></div>
                                    </div>
                                </div>
                            @endif


                            
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label for="looking_for">I'm looking for <span style="color: red;">*</span></label>
                                    <select class="form-control" id="looking_for" name="looking_for" required>
                                    <option value="">-</option>
                                    @foreach($options->looking_for as $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                    </select>
                                    
                                    <div class="error-message text-danger pt-1" id="looking_for-error"></div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <label for="professional_types">What type of creative professional are you looking for?: <span style="color: red;">*</span></label>
                                    <div class="w-100 sub-label-container">
                                        <span class="sub-label">Check all that apply</span>
                                    </div>
                                    <select name="professional_types[]" id="professional_types" class="form-control select2" multiple="multiple" required>
                                        <option value="">-</option>
                                        @foreach($options->professional_types as $value)
                                            <option value="{{ $value }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <div class="error-message text-danger pt-1" id="professional_types-error"></div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <label for="project_goals">What is the goal of your project or requirement?: <span style="color: red;">*</span></label>
                                    <div class="w-100 sub-label-container">
                                        <span class="sub-label">Check all that apply</span>
                                    </div>
                                    <select name="project_goals[]" id="project_goals" class="form-control select2" multiple="multiple" required>
                                        <option value="">-</option>
                                        @foreach($options->project_goals as $value)
                                            <option value="{{ $value }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <div class="error-message text-danger pt-1" id="project_goals-error"></div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <label for="budget_range">What is your budget range? <span style="color: red;">*</span></label>
                                    <select class="form-control" id="budget_range" name="budget_range" required>
                                    <option value="">-</option>
                                    @foreach($options->budget_range as $value)
                                        <option value="{{ $value }}">{{ $value }}</option>
                                    @endforeach
                                    </select>
                                    
                                    <div class="error-message text-danger pt-1" id="budget_range-error"></div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <label for="other_requirements">Do you have a specific style, theme, or other requirements in mind? <span style="color: red;">*</span></label>
                                    <div class="w-100 sub-label-container">
                                        <span class="sub-label">Briefly describe, e.g., modern, natire-inspired, minimalist, etc.</span>
                                    </div>
                                    <textarea class="w-100" rows="5" name="other_requirements" id="other_requirements" required></textarea>
                                    <div class="error-message text-danger pt-1" id="other_requirements-error"></div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <label for="other_exp">Are there any specific skills, tools, or experience you're looking for in a creative? <span style="color: red;">*</span></label>
                                    <div class="w-100 sub-label-container">
                                        <span class="sub-label">e.g., experience in murals, proficiency in Photoshop, knowledge of event logistics</span>
                                    </div>
                                    <textarea class="w-100" rows="5" name="other_exp" id="other_exp" required></textarea>
                                    <div class="error-message text-danger pt-1" id="other_exp-error"></div>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-12 text-end">
                                    <button class="btn btn-primary btn-submit">Submit</button>
                                    <button class="btn btn-secondary btn-cancel">Cancel</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



</section>