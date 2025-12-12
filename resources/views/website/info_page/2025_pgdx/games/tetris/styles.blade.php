<style>
    body, html {
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: 'Arial Black', 'Arial', sans-serif;
    overflow-x: hidden;
    }

    :root {
    --blue: #7ee6fd;
    --lime: #c6e045;
    --orange: #ff9c3e;
    --purple: #7c5ac2;
    --pink: #f7b6d2;
    --yellow: #ffe066;
    --black: #000000;
    --white: #fff;
    --gray: #675c5c61;
    }

    /* Desktop Layout Styles */
    .tetris-bg {
    min-height: 100vh;
    min-width: 100vw;
    background: #e9e9e9;
    display: flex;
    align-items: center;
    justify-content: center;
    }

    .tetris-container {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    gap: 32px;
    padding: 40px 0;
    }

    .side-panel {
    display: flex;
    flex-direction: column;
    gap: 24px;
    min-width: 140px;
    }

    .left-panel {
    align-items: flex-end;
    }
    .right-panel {
    align-items: flex-start;
    }

    .panel {
    background: linear-gradient(145deg, #f4f4f4 60%, #bcbcbc 100%);
    border: 4px solid #888;
    border-radius: 18px;
    box-shadow: 0 2px 8px #bbb, 0 0 0 4px #fff inset;
    padding: 16px 12px;
    min-width: 120px;
    min-height: 60px;
    display: flex;
    flex-direction: column;
    align-items: center;
    }

    .hold-panel.panel { background: var(--lime); }
    .next-panel.panel { background: var(--orange); }
    .score-panel.panel { background: var(--purple); color: var(--black); }
    .controls-panel.panel { background: var(--pink); }

    .panel-label {
    color: #222;
    font-size: 1.1em;
    font-weight: bold;
    letter-spacing: 2px;
    text-shadow: 0 1px 0 #fff;
    margin-bottom: 6px;
    }

    .panel-value {
    color: #222;
    font-size: 1.5em;
    font-weight: bold;
    text-shadow: 0 1px 0 #fff;
    }

    .logo {
    font-family: 'Arial Black', 'Arial', sans-serif;
    font-size: 2.5em;
    color: var(--black);
    letter-spacing: 6px;
    text-shadow: none;
    margin-bottom: 32px;
    margin-top: 8px;
    padding: 0 8px;
    background: var(--gray);
    border: 4px solid var(--black);
    border-radius: 12px;
    }

    .main-game-area {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    }

    .game-border {
    background: #222;
    border: 8px solid #bcbcbc;
    border-radius: 32px;
    box-shadow: 0 4px 24px #888, 0 0 0 8px #fff inset;
    padding: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    }

    .game-border.light-on {
    box-shadow: 0 0 60px 20px var(--blue), 0 0 120px 40px var(--white);
    border-color: var(--white);
    transition: box-shadow 0.2s, border-color 0.2s;
    }

    .screen {
    position: relative;
    background: #111;
    border-radius: 12px;
    box-shadow: 0 0 0 4px #888 inset;
    }

    canvas#game {
    min-width: 0;
    min-height: 0;
    margin: 0 auto;
    display: block;
    background-size: var(--block-size, 30px) var(--block-size, 30px) !important;
    box-sizing: border-box;
    }

    canvas#next, canvas#hold {
    background: var(--white);
    border-radius: 8px;
    border: 2px solid var(--black);
    margin-top: 4px;
    }

    /* Grid overlay for playfield */
    canvas#game.grid {
    background-image: linear-gradient(to right, #444 1px, transparent 1px),
        linear-gradient(to bottom, #444 1px, transparent 1px);
    background-size: var(--block-size, 30px) var(--block-size, 30px);
    }

    #container-game-tetris button {
    margin-top: 8px;
    padding: 10px 20px;
    border: 2px solid #888;
    border-radius: 8px;
    background: linear-gradient(145deg, #ffe066 60%, #ffb347 100%);
    color: #222;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 2px 4px #bbb;
    transition: all 0.2s ease;
    font-size: 1em;
    }
    
    #container-game-tetris button:hover {
    background: linear-gradient(145deg, #ffb347 60%, #ffe066 100%);
    color: #fff;
    }

    .game-over-overlay {
    display: none;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 40px;
    font-weight: bold;
    color: var(--black);
    text-shadow: none;
    z-index: 10;
    letter-spacing: 4px;
    animation: none;
    filter: none;
    padding: 40px 60px;
    border-radius: 20px;
    background: var(--yellow);
    border: 4px solid var(--black);
    box-shadow: none;
    }

    /* Mobile Layout Styles with Bootstrap Integration */
    .mobile-tetris-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 10px 0;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    }

    .mobile-score-display {
    background: linear-gradient(145deg, #007bff 0%, #0056b3 100%) !important;
    border: 3px solid #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    margin: 0 10px;
    }

    .mobile-game-area {
    padding: 10px 0;
    min-height: 50vh;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    }

    .mobile-game-container {
    background: #222;
    border: 6px solid #bcbcbc;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.3), 0 0 0 4px #fff inset;
    padding: 12px;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    margin: 0 auto;
    width: 100%;
    max-width: 98vw;
    }

    .mobile-game-container canvas {
    display: block;
    background: #111;
    border-radius: 8px;
    box-shadow: 0 0 0 2px #888 inset;
    margin: 0 auto;
    }

    .mobile-game-container canvas.grid {
    background-image: linear-gradient(to right, #444 1px, transparent 1px),
        linear-gradient(to bottom, #444 1px, transparent 1px);
    background-size: var(--block-size, 20px) var(--block-size, 20px);
    }

    .mobile-swipe-overlay {
    background: transparent;
    z-index: 5;
    cursor: pointer;
    }

    .mobile-controls-top, .mobile-controls-bottom {
    padding: 5px 0;
    }

    .mobile-controls-top .btn, .mobile-controls-bottom .btn {
    min-width: 60px;
    min-height: 60px;
    font-size: 1.2em;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: all 0.2s ease;
    border: 3px solid #fff;
    }

    .mobile-controls-top .btn:active, .mobile-controls-bottom .btn:active {
    transform: scale(0.95);
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    /* Bootstrap Button Enhancements */
    .btn-lg {
    font-size: 1.1rem !important;
    padding: 0.75rem 1.5rem !important;
    border-radius: 0.5rem !important;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
    .mobile-controls-top .btn, .mobile-controls-bottom .btn {
        min-width: 50px;
        min-height: 50px;
        font-size: 1em;
    }
    
    .mobile-score-display {
        margin: 0 5px;
        padding: 0.5rem !important;
    }
    
    .mobile-score, .mobile-level {
        font-size: 0.9rem !important;
    }
    }

    @media (max-width: 768px) {
    .mobile-tetris-container {
        padding: 5px 0;
    }
    
    .mobile-game-area {
        min-height: 40vh;
    }
    }

    @media (min-width: 769px) and (max-width: 991px) {
    .mobile-controls-top .btn, .mobile-controls-bottom .btn {
        min-width: 70px;
        min-height: 70px;
        font-size: 1.3em;
    }
    }

    /* Animation Effects */
    @keyframes shake {
    0% { transform: translate(0, 0); }
    20% { transform: translate(-10px, 2px); }
    40% { transform: translate(10px, -2px); }
    60% { transform: translate(-8px, 4px); }
    80% { transform: translate(8px, -4px); }
    100% { transform: translate(0, 0); }
    }

    .shake {
    animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
    }

    @keyframes explode {
    0% { box-shadow: 0 0 0 0 var(--white); }
    80% { box-shadow: 0 0 60px 30px var(--blue), 0 0 120px 60px var(--white); }
    100% { box-shadow: 0 0 0 0 var(--white); }
    }

    .explode {
    animation: explode 0.6s cubic-bezier(.36,.07,.19,.97) 1;
    }

    /* Bootstrap Overrides for better mobile experience */
    @media (max-width: 991px) {
    .container-fluid {
        padding-left: 10px;
        padding-right: 10px;
    }
    
    .row {
        margin-left: -5px;
        margin-right: -5px;
    }
    
    .col-12 {
        padding-left: 5px;
        padding-right: 5px;
    }
    }

    /* Ensure proper touch targets on mobile */
    @media (max-width: 576px) {
    .btn {
        min-height: 44px; /* Apple's recommended minimum touch target */
    }
    }

    /* Prevent text selection on mobile controls */
    .mobile-controls-top, .mobile-controls-bottom {
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    }

    /* Smooth scrolling for mobile */
    .mobile-tetris-container {
    -webkit-overflow-scrolling: touch;
    scroll-behavior: smooth;
    }

    /* High contrast mode support */
    @media (prefers-contrast: high) {
    .mobile-score-display {
        background: #000 !important;
        color: #fff !important;
        border-color: #fff !important;
    }
    
    .btn {
        border-width: 2px !important;
    }
    }

    /* Reduced motion support */
    @media (prefers-reduced-motion: reduce) {
    .shake, .explode {
        animation: none;
    }
    
    .btn {
        transition: none;
    }
    }

    .mobile-tetris-container button,
    .mobile-tetris-container .btn {
    z-index: 10 !important;
    pointer-events: auto !important;
    }
    .mobile-swipe-overlay {
    pointer-events: none !important;
    }

    .mobile-controls-row {
    width: 100%;
    min-height: 220px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 80px;
    padding: 0 24px;
    }
    .dpad-container {
    width: 160px;
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    margin: 0;
    }
    .dpad-cross {
    display: grid;
    grid-template-columns: 48px 48px 48px;
    grid-template-rows: 48px 48px 48px;
    gap: 8px;
    width: max-content;
    height: max-content;
    justify-items: center;
    align-items: center;
    background: none;
    position: static;
    }
    .dpad-btn {
    background: #222;
    border: 3px solid #444;
    border-radius: 12px;
    width: 44px;
    height: 44px;
    opacity: 0.95;
    box-shadow: 0 2px 6px #2224;
    z-index: 1;
    font-size: 1.7em;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    transition: background 0.2s;
    grid-column: 2;
    grid-row: 2;
    }
    .dpad-up    { grid-column: 2; grid-row: 1; }
    .dpad-down  { grid-column: 2; grid-row: 3; }
    .dpad-left  { grid-column: 1; grid-row: 2; }
    .dpad-right { grid-column: 3; grid-row: 2; }
    .dpad-center {
    grid-column: 2;
    grid-row: 2;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #333;
    border: 3px solid #666;
    z-index: 2;
    pointer-events: none;
    }
    .ab-container {
    min-width: 100px;
    min-height: 160px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 48px;
    margin: 0;
    }
    .ab-btn {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    font-size: 2em;
    font-family: 'Arial Black', 'Arial', sans-serif;
    font-weight: bold;
    background: #222;
    color: #fff;
    border: 3px solid #444;
    box-shadow: 0 2px 8px #2224;
    margin-bottom: 0;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    letter-spacing: 2px;
    transition: background 0.2s;
    }
    .ab-btn:active {
    background: #444;
    }
    .start-btn {
    min-width: 120px;
    font-size: 1.2em;
    border-radius: 20px;
    background: #2ec4d6;
    color: #fff;
    border: 3px solid #222;
    box-shadow: 0 2px 8px #2224;
    }
    .play-again-btn {
    display: block;
    margin: 32px auto 0 auto;
    min-width: 160px;
    font-size: 1.3em;
    border-radius: 16px;
    padding: 16px 0;
    font-weight: bold;
    letter-spacing: 1px;
    }

    .game-over-modal {
    position: fixed;
    top: 0; left: 0; width: 100vw; height: 100vh;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    }
    .game-over-content {
    background: #fff;
    border-radius: 20px;
    padding: 40px 32px 32px 32px;
    text-align: center;
    box-shadow: 0 4px 32px #0008;
    min-width: 260px;
    }
    .game-over-title {
    font-size: 2.2em;
    font-weight: bold;
    color: #222;
    margin-bottom: 24px;
    }

    .mobile-hold-floating {
    position: absolute;
    top: 12px;
    left: 12px;
    width: 64px;
    height: 64px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 14px;
    box-shadow: 0 2px 12px 2px rgba(0,0,0,0.18);
    z-index: 10;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    pointer-events: none;
    }
    .mobile-hold-label {
    position: absolute;
    top: -18px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 0.95em;
    color: #fff;
    font-weight: bold;
    letter-spacing: 2px;
    text-shadow: 0 1px 4px #000, 0 0 2px #222;
    pointer-events: none;
    user-select: none;
    }
    .mobile-hold-floating canvas {
    display: block;
    background: transparent;
    }
    @media (min-width: 992px) {
    .mobile-hold-floating { display: none !important; }
    }
</style>