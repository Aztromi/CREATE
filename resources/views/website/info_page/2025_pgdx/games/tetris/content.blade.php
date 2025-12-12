<div class="container-fluid" id="container-game-tetris" style="display: none;">
    <div class="row">
        <div class="col-12">
            <!-- !!! -->
            <!-- Desktop Layout -->
            <div class="tetris-bg d-none d-lg-block">
                <div class="tetris-container">
                <div class="side-panel left-panel">
                    <div class="logo">TETRIS</div>
                    <div class="hold-panel panel">
                    <div class="panel-label">HOLD</div>
                    <canvas id="hold" width="80" height="80"></canvas>
                    </div>
                </div>
                <div class="main-game-area">
                    <div class="game-border">
                    <div class="screen">
                        <canvas id="game" width="300" height="600"></canvas>
                        <div id="gameOver" class="game-over-overlay">GAME OVER</div>
                    </div>
                    </div>
                </div>
                <div class="side-panel right-panel">
                    <div class="next-panel panel">
                    <div class="panel-label">NEXT</div>
                    <canvas id="next" width="80" height="80"></canvas>
                    </div>
                    <div class="score-panel panel">
                    <div class="panel-label">SCORE</div>
                    <div class="panel-value" id="score">0</div>
                    </div>
                    <div class="controls-panel panel">
                    <button id="startBtn" class="btn btn-warning">Start Game</button>
                    <button id="restartBtn" class="btn btn-success" style="display:none;">Play Again</button>
                    </div>
                </div>
                </div>
            </div>

            <!-- Mobile Layout with Bootstrap -->
            <div class="mobile-tetris-container d-block d-lg-none vh-100 w-100 d-flex flex-column align-items-center justify-content-between p-0 m-0" style="min-height:100vh;">
                <!-- Score/Level Row -->
                <div class="w-100 text-center pt-2 pb-1">
                <div class="mobile-score-display bg-primary text-white rounded mx-auto px-3 py-2 d-inline-block">
                    <span class="mobile-score mr-3">Score: <span id="mobileScore" class="font-weight-bold">0</span></span>
                    <span class="mobile-level">Level: <span id="mobileLevel" class="font-weight-bold">1</span></span>
                </div>
                </div>
                <!-- Game Area Row -->
                <div class="flex-grow-1 d-flex align-items-center justify-content-center w-100" style="min-height:0;">
                <div class="mobile-game-container position-relative w-100" style="max-width: 100vw;">
                    <!-- Mobile Hold Floating Box -->
                    <div id="mobileHoldFloating" class="mobile-hold-floating d-lg-none" style="display: none;">
                    <span class="mobile-hold-label">HOLD</span>
                    <canvas id="mobileHoldCanvas" width="64" height="64"></canvas>
                    </div>
                    <canvas id="mobileGame" style="width:100%;height:auto;max-width:100vw;display:block;" width="300" height="600"></canvas>
                </div>
                </div>
                <!-- Controls Row -->
                <div class="w-100 pb-2">
                <div class="mobile-controls-row d-flex justify-content-between align-items-center px-3" style="min-height: 220px; gap: 0; padding: 0 24px;">
                    <!-- D-Pad -->
                    <div class="dpad-container d-flex align-items-center justify-content-center" style="margin-right: 32px;">
                    <div class="dpad-cross">
                        <button id="dpad-up" class="dpad-btn dpad-up"><span class="dpad-arrow">&#9650;</span></button>
                        <button id="dpad-left" class="dpad-btn dpad-left"><span class="dpad-arrow">&#9664;</span></button>
                        <button id="dpad-center" class="dpad-btn dpad-center"></button>
                        <button id="dpad-right" class="dpad-btn dpad-right"><span class="dpad-arrow">&#9654;</span></button>
                        <button id="dpad-down" class="dpad-btn dpad-down"><span class="dpad-arrow">&#9660;</span></button>
                    </div>
                    </div>
                    <!-- A/B Buttons -->
                    <div class="ab-container d-flex flex-column align-items-center justify-content-center" style="gap: 48px; margin-left: 32px;">
                    <button id="btn-b" class="ab-btn ab-b">B</button>
                    <button id="btn-a" class="ab-btn ab-a">A</button>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button id="mobileStartBtn" class="btn btn-info start-btn">START</button>
                </div>
                </div>
                <!-- Game Over Modal -->
                <div id="mobileGameOverModal" class="game-over-modal" style="display:none;">
                <div class="game-over-content">
                    <div class="game-over-title">GAME OVER</div>
                    <button id="mobileRestartBtn" class="btn btn-success play-again-btn mt-4">Play Again</button>
                </div>
                </div>
            </div>
            
            <!-- !!! -->


        </div>
    </div>
</div>