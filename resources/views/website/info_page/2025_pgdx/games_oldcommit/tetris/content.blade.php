<div class="container-fluid" id="tetris-container-game" style="display: none;"> <div class="row">
        <div class="col-12">
            <div class="tetris-bg d-none d-lg-block">
                <div class="tetris-container">
                <div class="side-panel left-panel">
                    <div class="logo">TETRIS</div>
                    <div class="hold-panel panel">
                    <div class="panel-label">HOLD</div>
                    <canvas id="tetris-hold" width="80" height="80"></canvas> </div>
                </div>
                <div class="main-game-area">
                    <div class="game-border">
                    <div class="screen">
                        <canvas id="tetris-game" width="300" height="600"></canvas> <div id="tetris-gameOver" class="game-over-overlay">GAME OVER</div> </div>
                    </div>
                </div>
                <div class="side-panel right-panel">
                    <div class="next-panel panel">
                    <div class="panel-label">NEXT</div>
                    <canvas id="tetris-next" width="80" height="80"></canvas> </div>
                    <div class="score-panel panel">
                    <div class="panel-label">SCORE</div>
                    <div class="panel-value" id="tetris-score">0</div> </div>
                    <div class="controls-panel panel">
                    <button id="tetris-startBtn" class="btn btn-warning">Start Game</button> <button id="tetris-restartBtn" class="btn btn-success" style="display:none;">Play Again</button> </div>
                </div>
                </div>
            </div>

            <div class="mobile-tetris-container d-block d-lg-none vh-100 w-100 d-flex flex-column align-items-center justify-content-between p-0 m-0" style="min-height:100vh;">
                <div class="w-100 text-center pt-2 pb-1">
                <div class="mobile-score-display bg-primary text-white rounded mx-auto px-3 py-2 d-inline-block">
                    <span class="mobile-score mr-3">Score: <span id="tetris-mobileScore" class="font-weight-bold">0</span></span> <span class="mobile-level">Level: <span id="tetris-mobileLevel" class="font-weight-bold">1</span></span> </div>
                </div>
                <div class="flex-grow-1 d-flex align-items-center justify-content-center w-100" style="min-height:0;">
                <div class="mobile-game-container position-relative w-100" style="width: 100%; max-width: 98vw; aspect-ratio: 0.5;">
                    <canvas id="tetris-mobileGame" class="grid" width="300" height="600"></canvas> <div id="tetris-mobileGameOver" class="game-over-overlay" style="display: none;">GAME OVER</div> <div id="tetris-mobileHoldFloating" class="mobile-hold-floating" style="display:none;"> <canvas id="tetris-mobileHoldCanvas" width="64" height="64"></canvas> </div>
                </div>
                </div>
                <div class="mobile-controls-row w-100">
                <div class="d-flex justify-content-around w-100 mobile-controls-top mb-2">
                    <button id="tetris-btn-rotate-ccw" class="btn btn-primary btn-lg"><i class="fas fa-undo"></i></button> <button id="tetris-btn-rotate-cw" class="btn btn-success btn-lg"><i class="fas fa-redo"></i></button> <button id="tetris-btn-hold" class="btn btn-info btn-lg">HOLD</button> </div>
                <div class="d-flex justify-content-around w-100 mobile-controls-bottom">
                    <div class="dpad-container d-flex align-items-center" style="gap: 16px;">
                    <button id="tetris-dpad-left" class="dpad-btn dpad-left"><span class="dpad-arrow">&#9664;</span></button> <button id="tetris-dpad-center" class="dpad-btn dpad-center"></button> <button id="tetris-dpad-right" class="dpad-btn dpad-right"><span class="dpad-arrow">&#9654;</span></button> <button id="tetris-dpad-down" class="dpad-btn dpad-down"><span class="dpad-arrow">&#9660;</span></button> </div>
                    <div class="ab-container d-flex flex-column align-items-center justify-content-center" style="gap: 48px; margin-left: 32px;">
                    <button id="tetris-btn-b" class="ab-btn ab-b">B</button> <button id="tetris-btn-a" class="ab-btn ab-a">A</button> </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button id="tetris-mobileStartBtn" class="btn btn-info start-btn">START</button> </div>
                </div>
                <div id="tetris-mobileGameOverModal" class="game-over-modal" style="display:none;"> <div class="game-over-content">
                    <div class="game-over-title">GAME OVER</div>
                    <button id="tetris-mobileRestartBtn" class="btn btn-success play-again-btn mt-4">Play Again</button> </div>
                </div>
            </div>
            </div>
    </div>
</div>