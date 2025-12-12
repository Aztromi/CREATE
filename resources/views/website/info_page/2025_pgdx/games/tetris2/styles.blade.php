<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Arial', sans-serif;
        overflow-x: hidden;
        overflow-y: auto; /* Allow scrolling on small screens */
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: flex-start; /* Align to top for mobile */
        padding: 10px;
    }

    .game-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        position: relative;
        width: 100%;
        max-width: 1200px; /* Limit overall game width on very large screens */
    }

    /* DESKTOP LAYOUT STYLES (GLOBAL) */
    .game-container {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        justify-content: center;
        gap: 30px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    .game-board {
        position: relative;
        border: 3px solid #fff;
        border-radius: 10px;
        box-shadow: 0 0 30px rgba(255, 255, 255, 0.3);
    }

    canvas {
        display: block;
        background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
        border-radius: 7px;
        width: 100%;
    }

    .side-panel {
        display: flex;
        flex-direction: column;
        gap: 15px; /* Reduced gap for a tighter fit */
        min-width: 200px; /* Adjusted min-width */
        max-width: 220px; /* Set max-width for desktop side panel */
        align-items: center; /* Center items within the side panel */
    }

    .game-info {
        color: white;
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .score-section h3 {
        margin-bottom: 5px;
        font-size: 1.3em; /* Ensure desktop score text is readable */
    }
    .score-section p {
        font-size: 1em;
        margin: 2px 0;
    }


    .meter-box,
    .next-piece,
    .hold-piece {
        background: rgba(255, 255, 255, 0.13);
        border-radius: 15px;
        padding: 12px; /* Slightly reduced padding */
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        text-align: center;
        width: 100%;
    }

    .meter-box h2,
    .next-piece h3,
    .hold-piece h3 {
        font-size: 1.2em; /* Slightly smaller for desktop to fit */
        margin-bottom: 8px; /* Adjusted margin */
        color: #ffd700;
        text-shadow: 0 0 10px #ffd70044;
    }

    .explosion-meter-bar {
        width: 90%;
        height: 20px; /* Slightly reduced height */
        background: #333;
        border: 2px solid #666;
        border-radius: 10px; /* Adjusted border radius */
        overflow: hidden;
        margin: 8px auto 0 auto; /* Adjusted margin */
    }

    .explosion-meter-fill {
        height: 100%;
        background: linear-gradient(90deg, #ff6b35, #f7931e, #ffd700, #ff6b35);
        background-size: 200% 100%;
        animation: explosion-glow 2s ease-in-out infinite;
        width: 0%;
        transition: width 0.3s ease;
        border-radius: 8px; /* Adjusted border radius */
    }

    .explosion-meter-value {
        margin-top: 6px; /* Adjusted margin */
        font-size: 1em; /* Slightly smaller for desktop */
        color: #fff;
    }

    .score-display { /* This targets the score text below the board */
        color: white;
        font-size: 1.4em; /* Default desktop size */
        margin-top: 15px;
        text-align: center;
        width: 100%;
    }


    .mobile-controls {
        display: none;
        width: 100%;
        max-width: 400px;
        padding: 10px 15px 0 15px;
        justify-content: space-between;
        align-items: center;
        user-select: none;
    }

    .control-btn {
        background-color: rgba(0, 0, 0, 0.4);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        font-size: 24px;
        font-weight: bold;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .control-btn:active {
        background-color: rgba(255, 255, 255, 0.3);
    }

    .d-pad {
        position: relative;
        width: 150px;
        height: 150px;
    }

    .d-pad .control-btn {
        position: absolute;
        width: 50px;
        height: 50px;
    }

    .d-pad .up { top: 0; left: 50px; }
    .d-pad .down { bottom: 0; left: 50px; }
    .d-pad .left { top: 50px; left: 0; }
    .d-pad .right { top: 50px; right: 0; }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .action-buttons .control-btn {
        width: 70px;
        height: 70px;
        border-radius: 25px;
        font-size: 16px;
    }

    /* === MOBILE LAYOUT FIXES === */
    @media (max-width: 768px) {
        body {
            height: auto;
            min-height: 100vh;
            align-items: flex-start !important;
            padding: 5px !important;
        }

        .game-wrapper {
            gap: 5px !important;
            max-width: 100% !important; /* Allow full width on mobile */
        }
        
        .game-container {
            flex-direction: row !important;
            align-items: flex-start !important;
            justify-content: center !important;
            gap: 5px !important;
            padding: 5px !important;
            background: none !important;
            backdrop-filter: none !important;
            box-shadow: none !important;
        }
        
        #gameCanvas {
            width: 180px !important;
            height: 360px !important;
            min-width: 180px !important;
        }
        
        .game-board {
            order: 1 !important;
            border: 2px solid #fff !important;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.2) !important;
        }

        .side-panel {
            order: 2 !important;
            min-width: 100px !important;
            max-width: 120px !important;
            gap: 5px !important;
            padding-top: 5px !important;
            margin-top: 0 !important;
        }

        .game-info {
            display: flex !important;
            flex-direction: column !important;
            flex-wrap: nowrap !important;
            justify-content: flex-start !important;
            align-items: center !important;
            gap: 5px !important;
            width: 100% !important;
        }
        
        /* Specific adjustments for score section on mobile */
        .score-section {
            order: 5 !important;
            width: 100% !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            align-items: center !important;
            padding: 5px !important;
            background: rgba(255, 255, 255, 0.13) !important; /* Add background for consistency */
            border-radius: 10px !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08) !important;
        }
        .score-section h3 {
            font-size: 0.9em !important; /* Smaller font for score title */
            margin-bottom: 3px !important;
        }
        .score-section p {
            font-size: 0.7em !important; /* Smaller font for score values */
            margin: 1px 0 !important;
        }


        .meter-box, .next-piece, .hold-piece {
            padding: 8px !important;
            border-radius: 10px !important;
            font-size: 0.9em !important;
            width: 100% !important;
            text-align: center !important;
        }
        .next-piece { order: 1 !important; }
        .hold-piece { order: 2 !important; }
        .meter-box { order: 3 !important; }

        .meter-box h2, .next-piece h3, .hold-piece h3 {
            font-size: 0.9em !important; /* Smaller titles for mobile side panel */
            margin-bottom: 5px !important;
        }
        
        .explosion-meter-bar {
            width: 80% !important;
            height: 15px !important; /* Even smaller bar height */
            margin: 5px auto 0 auto !important;
            border-radius: 8px !important;
        }
        .explosion-meter-fill {
            border-radius: 6px !important;
        }

        .explosion-meter-value {
            font-size: 0.8em !important; /* Smaller font for meter value */
            margin-top: 5px !important;
        }

        /* --- SCORE DISPLAY BELOW BOARD (WHITE TEXT) --- */
        .score-display {
            order: 3 !important;
            font-size: 0.9em !important; /* Significantly smaller for mobile */
            margin-top: 10px !important;
            text-align: center !important;
            width: 100% !important;
            padding: 0 5px !important; /* Add some horizontal padding */
        }


        .controls-overlay {
            display: none !important;
        }

        .mobile-controls {
            display: flex !important;
            order: 4 !important;
            max-width: 350px !important;
            padding: 10px 0 0 0 !important;
        }
        .d-pad {
            width: 120px !important;
            height: 120px !important;
        }
        .d-pad .control-btn {
            width: 40px !important;
            height: 40px !important;
            font-size: 20px !important;
        }
        .d-pad .up { top: 0; left: 40px; }
        .d-pad .down { bottom: 0; left: 40px; }
        .d-pad .left { top: 40px; left: 0; }
        .d-pad .right { top: 40px; right: 0; }

        .action-buttons {
            gap: 10px !important;
        }
        .action-buttons .control-btn {
            width: 60px !important;
            height: 60px !important;
            border-radius: 20px !important;
            font-size: 14px !important;
        }
    }

    /* -- Original styles below -- */
    @keyframes explosion-glow {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    .explosion-mode-indicator {
        background: linear-gradient(45deg, #ff6b35, #f7931e, #ffd700, #ff6b35);
        background-size: 400% 400%; animation: explosion-pulse 0.5s ease-in-out infinite;
        color: white; text-align: center; padding: 10px; border-radius: 5px; font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8); display: none; margin: 10px 0;
    }
    @keyframes explosion-pulse {
        0%, 100% { background-position: 0% 50%; transform: scale(1); }
        50% { background-position: 100% 50%; transform: scale(1.05); }
    }
    .screen-shake { animation: screenShake 0.5s ease-in-out; }
    @keyframes screenShake {
        0%, 100% { transform: translate(0, 0); } 10%, 30% { transform: translate(-2px, 2px); }
        20%, 40% { transform: translate(2px, -2px); } 50%, 70% { transform: translate(-1px, 1px); }
        60%, 80% { transform: translate(1px, -1px); } 90% { transform: translate(0, 0); }
    }
    .border-glow { animation: borderGlow 0.8s ease-in-out; }
    @keyframes borderGlow {
        0%, 100% { box-shadow: 0 0 30px rgba(255, 255, 255, 0.3); border-color: #fff; }
        50% { box-shadow: 0 0 50px rgba(255, 255, 255, 0.8), 0 0 80px rgba(255, 255, 255, 0.6); border-color: #ffd700; }
    }
    .controls-overlay {
        position: fixed; right: 30px; bottom: 30px; background: rgba(255, 255, 255, 0.13);
        border-radius: 15px; padding: 18px 28px 14px 28px; box-shadow: 0 2px 12px rgba(0, 0, 0, 0.12);
        text-align: center; min-width: 200px; color: #fff; z-index: 1000; font-size: 1.1em;
        backdrop-filter: blur(6px); border: 1.5px solid #fff3; pointer-events: none; user-select: none;
    }
    .controls-overlay h3 {
        margin-bottom: 6px; color: #ffd700; text-shadow: 0 0 8px #ffd70044; font-size: 1.2em;
    }
    .controls-overlay p { margin: 2px 0; letter-spacing: 1px; }
    #modal-tetris-1 .modal-body {
        background-color: #667eea; min-width: 300px; border-radius: 30px;
    }
    #modal-tetris-1 .score-container .col {
        font-weight: normal; font-size: 25px; text-align: center;
    }
    #modal-tetris-1 .button-container { margin-top: 20px; }
    #modal-tetris-1 .button-container .col { text-align: center; }
    #modal-tetris-1 .button-container button { width: 100%; }
    #modal-tetris-1 .button-container .col #btn-start {
        background-color: #2048fbff; color: #FFFFFF; padding: 10px 15px; border: 2px solid #2048fbff;
        border-radius: 25px; font-weight: bold; font-size: 20px; letter-spacing: 1.2px;
    }
    #modal-tetris-1 .button-container .col #btn-exit {
        background-color: #af1515ff; color: #FFFFFF; padding: 10px 15px; border: 2px solid #af1515ff;
        border-radius: 25px; font-weight: bold; font-size: 20px; letter-spacing: 1.2px; margin-top: 10px;
    }
    #modal-tetris-1 .button-container .col #btn-start:hover {
        background-color: #FFFFFF; color: #2048fbff;
    }
    #modal-tetris-1 .button-container .col #btn-exit:hover {
        background-color: #FFFFFF; color: #af1515ff;
    }
</style>