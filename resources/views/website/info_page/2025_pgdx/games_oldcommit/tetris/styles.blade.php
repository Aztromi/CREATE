<style>
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

    canvas#tetris-game { /* Updated ID */
        min-width: 0;
        min-height: 0;
        margin: 0 auto;
        display: block;
        background-size: var(--block-size, 30px) var(--block-size, 30px) !important;
        box-sizing: border-box;
    }

    canvas#tetris-next, canvas#tetris-hold { /* Updated IDs */
        background: var(--white);
        border-radius: 8px;
        border: 2px solid var(--black);
        margin-top: 4px;
    }

    /* Grid overlay for playfield */
    canvas#tetris-game.grid { /* Updated ID */
        background-image: linear-gradient(to right, #444 1px, transparent 1px),
            linear-gradient(to bottom, #444 1px, transparent 1px);
        background-size: var(--block-size, 30px) var(--block-size, 30px);
    }

    #tetris-container-game button { /* Updated ID */
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
    #tetris-container-game button:hover { /* Updated ID */
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
    #tetris-container-game .btn-lg { /* Updated ID */
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
        25% { transform: translate(-5px, 0); }
        50% { transform: translate(5px, 0); }
        75% { transform: translate(-5px, 0); }
        100% { transform: translate(0, 0); }
    }

    @keyframes explode {
        0% { filter: blur(0); opacity: 1; }
        100% { filter: blur(10px); opacity: 0; }
    }
</style>