<div class="modal" id="modal-game-snake">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-body mx-auto">
                <div class="row">
                    <div class="col-12">
                        <div id="snake-overlay" class="overlay">
                            <div class="overlay-content">
                                <h1 id="snake-status-text">Snake Game</h1>
                                <p id="snake-score-display">Score: 0</p>
                                <br><br>
                                <button id="snake-start-btn">Play</button>
                                <button id="snake-close-btn">Exit</button>
                            </div>
                        </div>

                        <div class="gba-wrapper">
                            <div class="gba-frame">
                            <div class="close-container">
                                <a href="" id="snake-close-game" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-circle-xmark fa-xl" style="color:rgb(161, 3, 3);"></i></a>
                            </div>
                            <div class="gba-top-label">SNAKE GAME</div>
                            <div id="snake-live-score" style="position: absolute; top: 10px; right: 10px; color: #00ffcc; font-weight: bold;">Score: 0</div>
                            <div class="gba-screen">
                                <div id="snake-game-container"></div>
                            </div>
                            <div class="gba-controls">
                                <div class="controls-wrapper">
                                <div class="dpad">
                                    <button class="dpad-btn up" id="snake-up">↑</button>
                                    <div class="dpad-horizontal">
                                    <button class="dpad-btn left" id="snake-left">←</button>
                                    <button class="dpad-btn down" id="snake-down">↓</button>
                                    <button class="dpad-btn right" id="snake-right">→</button>
                                    </div>
                                </div>

                                <div class="ab-buttons">
                                    <button class="ab-btn" id="snake-btn-b">B</button>
                                    <button class="ab-btn" id="snake-btn-a">A</button>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>
    </div>
</div>