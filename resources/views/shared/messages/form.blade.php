
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

    <div class="card card-main col-12">
        <div class="card-body">
            <div class="container" id="main-content" style="display: none;">
                <div class="row">
                    <div class="col-12 mt-4 mb-4 text-center">
                        <h1>Messages</h1>
                    </div>
                    @if(Auth::user()->isMember())
                    <div class="col-12 mt-2 mb-3 text-end top-elements">
                        <a href="{{ route('directory') }}" class="btn btn-primary">
                            Browse the Directory
                        </a>
                    </div>
                    @elseif(Auth::user()->isAdminOG() || Auth::user()->isCreative())
                    <div class="col-12 search-container top-elements">
                        <div class="input-group">
                            <input id="search" name="search" type="search" class="form-control" placeholder="Search...">
                            <button id="search-button" type="submit" class="btn btn-primary" disabled>
                            <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    @endif
                    
                    <div class="col message-container list">
                        <center>No Messages</center>
                    </div>

                    <div class="col message-container details" style="display: none;">
                        <div class="head">
                            <div class="row">
                                <div class="col-12">
                                    <span class="back-to-list">
                                        &larr; Back
                                    </span>
                                </div>
                                <div class="col-12 participant-name-container">
                                    <span class="participant-name">Co-Participant</span>
                                </div>
                            </div>
                            
                        </div>
                        <div class="body">
                            <div class="message message-ext">
                                <div class="sender">Sender Name</div>
                                <div class="content">Hi, How are ayou</div>
                                <div class="datetime">September 31, 2025 12:31 pm</div>
                            </div>
                            <div class="message message-own">
                                <!-- <div class="sender"></div> -->
                                <div class="content">I'm good. How bout you</div>
                                <div class="datetime">25 Mar 2025 12:31 pm</div>
                            </div>
                            
                        </div>
                        <div class="footer">
                            <div class="row">
                                <div class="col-12">
                                    <textarea name="" id="" maxlength="200" placeholder="Message..."></textarea>
                                </div>
                                <div class="col-6 taCounter">0/200</div>
                                <div class="col-6 btn-container">
                                    <button id="btn-send">Send</button>
                                    <button id="btn-clear">Clear</button>
                                </div>
                            </div>
                                
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    
</section>