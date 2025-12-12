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

    <div class="card col-12 mx-auto">
        <div class="card-body">
            <div class="container-fluid" id="main-content" style="display: none;">
                <div class="row">
                    <div class="col mt-4 mb-4 text-center">
                        <h1>Connect with a Creative Response</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-5">
                        

                            <div class="row mb-3 guest-info">
                                <div class="col col-6">
                                    <span class="request_label">Name:</span>
                                    <span class="request_detail">{{ $details->name }}</span>
                                    <span class="requester_type {{ $details->type }}">
                                        {{ $details->type }}
                                    </span>
                                </div>

                                <div class="col col-6">
                                    <span class="request_label">Status:</span>
                                    <span class="request_detail">{{ $details->statusText }}</span>
                                </div>

                                <div class="col col-6">
                                    <span class="request_label">Submission Date/Time:</span>
                                    <span class="request_detail">{{ $details->date_requested->isToday() ? 'Today' : \Carbon\Carbon::parse($details->date_requested)->format('F d, Y') }}</span>
                                    <span class="request_detail">{{ \Carbon\Carbon::parse($details->date_requested)->format('h:i a') }}</span>
                                </div>

                                @if($details->type == 'Guest')
                                    <div class="col col-6">
                                        <span class="request_label">Company Name:</span>
                                        <span class="request_detail">{{ $details->company_name }}</span>
                                    </div>
                                @endif

                                <div class="col col-12">
                                    <span class="request_label">E-mail:</span>
                                    <span class="request_detail">{{ $details->email }}</span>
                                </div>
                                
                                @if($details->type == 'Guest')
                                    <div class="col col-12">
                                        <span class="request_label">Address:</span>
                                        <span class="request_detail">{{ $details->address }}</span>
                                        <span class="request_detail">{{ $details->country }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3 addtnl-details">
                                <div class="col col-12">
                                    <span class="request_label">I'm looking for:</span>
                                    <span class="request_detail">{{ $details->looking_for }}</span>
                                </div>

                                <div class="col col-12">
                                    <span class="request_label">What type of creative professional are you looking for?:</span>
                                    @foreach($details->professionals as $prof)
                                        <span class="request_multiple">{{ $prof->value }}</span>
                                    @endforeach
                                </div>

                                <div class="col col-12">
                                    <span class="request_label">What is the goal of your project or requirement?:</span>
                                    @foreach($details->goals as $goal)
                                        <span class="request_multiple">{{ $goal->value }}</span>
                                    @endforeach
                                </div>

                                <div class="col col-12">
                                    <span class="request_label">What is your budget range?:</span>
                                    <span class="request_detail">{{ $details->budget_range }}</span>
                                </div>

                                <div class="col col-12">
                                    <span class="request_label">Do you have a specific style, theme, or other requirements in mind?:</span>
                                    <span class="request_detail">{{ $details->other_requirements }}</span>
                                </div>

                                <div class="col col-12">
                                    <span class="request_label">Are there any specific skills, tools, or experience you're looking for in a creative?:</span>
                                    <span class="request_detail">{{ $details->other_exp }}</span>
                                </div>
                            </div>

                            <div class="row recommended-creatives-container">
                                <label for="">Creatives to Recommend</label>
                                <div class="recommended-creatives">
                                    {{-- <span class="request_multiple"><span>Value 1</span><span class="rc_x">×</span></span> --> --}}
                                </div>
                            </div>

                            
                            <div class="row mt-3 mb-5">
                                <div class="col-12 text-end">
                                    <button class="btn btn-primary btn-submit">Submit</button>
                                    <button class="btn btn-secondary btn-cancel">Cancel</button>
                                </div>
                            </div>
                    </div>
                    <div class="col-7 creative-view">
                        @if($details->status == 0)
                            <div class="filter">
                                
                                <label for="cField">Creative Fields</label>
                                <div class="d-flex align-items-start gap-1">
                                    <select name="cField[]" id="cField" class="form-control form-control-lg" multiple="multiple">-</select>
                                    <button class="btn btn-secondary btn-filter">Filter</button>
                                </div>
                            </div>
                            <div class="creatives w-100 mt-3">
                                <label for="creatives">Creatives</label>
                                <select class="form-control form-control-lg" id="creatives" name="creatives">
                                    <option value="">-</option>
                                </select>
                                <div class="text-end mt-1">
                                    <button class="btn btn-primary btn-add">Add</button>
                                </div>
                            </div>
                            <div class="profile-viewer">
                                <center>Profile Viewer</center>
                                {{--
                                <div class="container-fluid">
                                    <div class="col-6">
                                    </div>
                                    <div class="col-6"></div>
                                </div>
                                --}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>



</section>