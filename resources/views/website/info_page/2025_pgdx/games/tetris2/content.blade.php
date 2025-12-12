<div class="modal" id="modal-tetris-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body mx-auto">
                <div class="row">
                    <div class="col col-12 text-center text-light">
                        <h1>TETRIS</h1>
                    </div>
                </div>
                <div class="row game-over-container">
                    <div class="col col-12 text-center">
                        <h3>Game Over</h3>
                    </div>
                </div>
                <div class="row score-container">
                    <div class="col col-12">
                        <span class="score-label">Score:</span> <span class="score-actual">0</span>
                    </div>
                </div>

                <div class="row button-container">
                    <div class="col col-12">
                        <button id="btn-start">START GAME</button>
                        <br>
                        <button id="btn-exit">EXIT</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br>
<div class="game-wrapper mx-auto">
    <div class="game-container">
        <div class="game-board">
            <canvas id="gameCanvas" width="300" height="600"></canvas>
        </div>
        <div class="side-panel">
            <div class="game-info">
                <div class="score-section">
                    <h3>Score: <span id="score">0</span></h3>
                    <h3>Lines: <span id="lines">0</span></h3>
                    <h3>Combo: <span id="combo">0</span></h3>
                    <h3>Max Combo: <span id="maxCombo">0</span></h3>
                </div>
                <div class="meter-box">
                    <h2>Explosion Meter</h2>
                    <div class="explosion-meter-bar">
                        <div class="explosion-meter-fill" id="explosionMeterFill"></div>
                    </div>
                    <div class="explosion-meter-value">
                        <span id="explosionMeter">0</span> / 5
                    </div>
                    <div class="explosion-mode-indicator" id="explosionModeIndicator">MEGA EXPLOSION!</div>
                </div>
                <div class="next-piece">
                    <h3>Next Piece</h3>
                    <canvas id="nextCanvas" width="120" height="120"></canvas>
                </div>
                <div class="hold-piece">
                    <h3>Hold</h3>
                    <canvas id="holdCanvas" width="120" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="mobile-controls">
        <div class="d-pad">
            <button id="btn-up" class="control-btn up">▲</button>
            <button id="btn-left" class="control-btn left">◀</button>
            <button id="btn-right" class="control-btn right">▶</button>
            <button id="btn-down" class="control-btn down">▼</button>
        </div>
        <div class="action-buttons">
            <button id="btn-hold" class="control-btn hold">HOLD</button>
            <button id="btn-drop" class="control-btn drop">DROP</button>
        </div>
    </div>
</div>

<div class="controls-overlay">
    <h3>Controls</h3>
    <p>← → / A D: Move</p>
    <p>↓ / S: Soft Drop</p>
    <p>↑ / W: Rotate</p>
    <p>Space: Hard Drop</p>
    <p>C: Hold Piece</p>
    <p>P: Pause</p>
</div>