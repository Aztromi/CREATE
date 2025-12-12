<div class="modal" id="modal-game-form" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body mx-auto">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center mb-3">
                            <h2 id="game-label">GAME</h2>
                        </div>
                        <div class="mb-3" id="game-score-container">
                            <span id="game-score-label">Score: <span id="game-score">123456789</span></span>
                        </div>
                        {{-- <div class="mb-3" id="play-id-container">Play ID: <span id="play-id">-</span></div> --}}
                        <div class="mb-4 gen-format">
                            <span>Congratulations! You’ve ranked among the top 3 highest scorers in this game. Fill out the form below to submit your score.</span>
                            <br><br>
                            <span>Scores and final rankings are provisional and subject to validation.</span>
                        </div>
                    </div>
                    <div class="col-12 form-container">
                        <form action="">
                            <div class="input-group mb-3">
                                <input type="hidden" name="game-play-id" id="game-play-id" value="">
                                <input type="hidden" name="game-type" id="game-type" value="">
                                <!-- <label for="nickname" class="form-label">Nickname</label> -->
                                <span class="input-group-text" id="nickname-label">Nickname</span>
                                <input type="text" class="form-control" id="nickname" name="nickname" aria-describedby="nickname-label" maxlength="6" required>
                            </div>
                            <div class="input-group mb-3">
                                <!-- <label for="firstname" class="form-label">First Name</label> -->
                                <span class="input-group-text" id="firstname-label">First Name</span>
                                <input type="text" class="form-control" id="firstname" name="firstname" aria-describedby="firstname-label" maxlength="30" required>
                            </div>
                            <div class="input-group mb-3">
                                <!-- <label for="lastname" class="form-label">Last Name</label> -->
                                <span class="input-group-text" id="lastname-label">Last Name</span>
                                <input type="text" class="form-control" id="lastname" name="lastname" aria-describedby="lastname-label" maxlength="30" required>
                            </div>
                            <div class="input-group mb-3">
                                <!-- <label for="email" class="form-label">Email address</label> -->
                                <span class="input-group-text" id="email-label">Email address</span>
                                <input type="email" class="form-control" id="email" name="email" aria-describedby="email-label" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="contact-label">Contact Number</span>
                                <input type="tel" class="form-control" id="contact_number" name="contact_number" aria-describedby="contact-label" placeholder="+639171234567" required>
                            </div>
                            <div class="text-end mt-4">
                                <button type="submit" id="btn-submit" class="btn btn-primary btn-lg">Submit</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>