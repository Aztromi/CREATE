
<div class="modal" id="modal-game-snake" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-body mx-auto">
                <div class="row">
                    <div class="col-12">
                        <!-- Overlay -->
                        <div id="overlay" class="overlay">
                            <div class="overlay-content">
                                <h1 id="status-text">Snake Game</h1>
                                <p id="score-display">Score: 0</p>
                                <!-- <label for="color-picker">Choose Snake Color:</label>
                                <input type="color" id="color-picker" value="#4CAF50"> -->
                                <br><br>
                                <button id="start-btn">Play</button>
                                <button id="close-btn">Exit</button>
                            </div>
                        </div>

                        <!-- GBA Wrapper -->
                        <div class="gba-wrapper">
                            <div class="gba-frame">
                            <div class="close-container">
                                <a href="" id="close-snake" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-circle-xmark fa-xl" style="color:rgb(161, 3, 3);"></i></a>
                            </div>
                            <div class="gba-top-label">SNAKE GAME</div>
                            <div id="live-score" style="color: #00ffcc; font-weight: bold;">Score: 0</div>
                            <div class="gba-screen">
                                <div id="game-container"></div>
                            </div>
                            <div class="gba-controls">
                                <div class="controls-wrapper">
                                <!-- D-Pad -->
                                <div class="dpad">
                                    <button class="dpad-btn up" id="up">↑</button>
                                    <div class="dpad-horizontal">
                                    <button class="dpad-btn left" id="left">←</button>
                                    <button class="dpad-btn down" id="down">↓</button>
                                    <button class="dpad-btn right" id="right">→</button>
                                    </div>
                                </div>

                                <!-- A/B Buttons -->
                                <div class="ab-buttons">
                                    <button class="ab-btn" id="btn-b">B</button>
                                    <button class="ab-btn" id="btn-a">A</button>
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