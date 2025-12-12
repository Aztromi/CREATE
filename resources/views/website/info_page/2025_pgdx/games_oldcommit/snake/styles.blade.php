<style>
    /* REMOVED: body styles that conflicted with main site layout.
       These should be in your main CSS file (e.g., app.css, site.css)
    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background-color: #0f0f0f;
        color: #f5f5f5;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        min-height: 100vh;
        overflow-y: auto;
        padding: 2rem 1rem;
    }
    */

    /* Main Game Area */
    #snake-game-container {
        width: 100%;
        max-width: 800px;
        height: auto;
        aspect-ratio: 1 / 1;
        /* background-image: url('https://img.freepik.com/free-vector/seamless-green-grass-pattern_1284-52275.jpg?semt=ais_hybrid&w=740'); */
        background-color: #000000;
        background-size: 40px 40px;
        background-repeat: repeat;
        background-position: center;
        display: grid;
        grid-template-columns: repeat(20, 1fr);
        grid-template-rows: repeat(20, 1fr);
        border-radius: 12px;
        box-shadow: 0 0 25px rgba(0, 255, 0, 0.3);
        position: relative;
    }

    .snake {
        background-color: #66ff66;
        border-radius: 30%;
        box-shadow: 0 0 6px #00ff00;
    }

    .snake.head {
        border-radius: 50%;
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #00cc00;
    }

    .head-content {
        position: absolute;
        width: 100%;
        height: 100%;
    }

    .eyes {
        position: absolute;
        top: 20%;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        justify-content: space-between;
        width: 60%;
    }

    .eye {
        width: 20%;
        height: 20%;
        background: white;
        border-radius: 50%;
    }

    .tongue {
        position: absolute;
        bottom: -6px;
        width: 4px;
        height: 12px;
        background: red;
        border-radius: 2px;
        animation: flick 0.4s infinite;
    }

    @keyframes flick {
        0%, 100% { height: 10px; }
        50% { height: 16px; }
    }

    /* Food Styling */
    .food {
        background: #e53935;
        border-radius: 50%;
        box-shadow: 0 0 10px #ff5252;
        width: 100%;
        height: 100%;
    }

    /* Overlay UI */
    #snake-overlay { /* Updated ID */
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(15, 15, 15, 0.95);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 10;
        text-align: center;
        border-radius: 12px;
    }

    #snake-overlay h1 { /* Updated ID */
        font-size: 2.5rem;
        color: #00ffcc;
        text-shadow: 0 0 10px #00ffcc;
        margin-bottom: 20px;
    }

    #snake-overlay button { /* Updated ID */
        padding: 12px 30px;
        font-size: 1.1rem;
        background-color: #00bcd4;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s;
    }

    #snake-overlay #snake-close-btn { /* Updated ID */
        background-color: #c21f39 !important;
    }

    #snake-overlay button:hover { /* Updated ID */
        background-color: #0097a7;
    }

    #snake-overlay input[type="color"] { /* Updated ID */
        margin-top: 10px;
        width: 60px;
        height: 40px;
        border: none;
        cursor: pointer;
    }

    /* Mobile Controls */
    .mobile-controls {
        margin-top: 10px;
        display: none;
        flex-direction: column;
        align-items: center;
    }

    .mobile-controls button {
        background: #00bcd4;
        color: white;
        border: none;
        margin: 5px;
        font-size: 1.5rem;
        border-radius: 10px;
        padding: 10px 20px;
        transition: transform 0.1s ease;
    }

    .mobile-controls button:active {
        transform: scale(0.95);
    }

    /* Game Boy Frame */
    .gba-frame {
        position: relative;
        width: 100%;
        max-width: 380px;
        background: linear-gradient(to bottom right, #6b6b6b, #4a4a4a);
        border-radius: 30px;
        padding: 20px;
        box-shadow: 0 0 0 8px #333, 0 0 0 12px #222;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .gba-top-label {
        font-family: 'Press Start 2P', cursive;
        font-size: 1.2rem;
        color: #00ffcc;
        text-shadow: 0 0 8px #00ffcc;
        margin-bottom: 10px;
        text-align: center;
        width: 100%;
    }

    .gba-screen {
        background-color: #0f0f0f;
        width: 100%;
        padding-bottom: 100%; /* Aspect ratio 1:1 */
        position: relative;
        border-radius: 8px;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5), 0 0 5px rgba(0, 255, 0, 0.3);
        margin-bottom: 20px;
        display: flex; /* Ensure flex for centering game container */
        align-items: center;
        justify-content: center;
    }

    .gba-screen #snake-game-container { /* Ensure it fills the screen area */
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        max-width: none; /* Override max-width from general #game-container */
    }

    .gba-controls {
        display: flex;
        justify-content: center;
        width: 100%;
        margin-top: 20px;
    }

    .controls-wrapper {
        display: flex;
        align-items: center;
        gap: 3rem;
    }

    .dpad {
        display: grid;
        grid-template-areas:
            ". up ."
            "left center right"
            ". down .";
        gap: 5px;
        width: 120px;
        height: 120px;
        position: relative;
    }

    .dpad-btn {
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.1s;
        box-shadow: inset 0 2px 5px rgba(0,0,0,0.5), inset 0 -2px 5px rgba(255,255,255,0.2);
    }

    .dpad-btn:active {
        background-color: #555;
        transform: scale(0.98);
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.5), inset 0 -1px 3px rgba(255,255,255,0.2);
    }

    .dpad-btn.up { grid-area: up; }
    .dpad-btn.down { grid-area: down; }
    .dpad-btn.left { grid-area: left; }
    .dpad-btn.right { grid-area: right; }

    .dpad-horizontal {
        display: flex;
        justify-content: space-between;
        grid-area: left / center / right / right;
    }

    .ab-buttons {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .ab-btn {
        background-color: #ff3366;
        color: white;
        font-weight: bold;
        border: none;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        font-size: 1.2rem;
        box-shadow: inset -2px -2px 5px #80001f, inset 2px 2px 5px #ff4c6d;
        transition: transform 0.1s;
    }

    .ab-btn:active {
        transform: scale(0.95);
    }

    .close-btn {
        background-color: #c21f39 !important;
    }

    .close-container {
        display: flex;
        justify-content: flex-end;
        width: 100%;
        padding-right: 10px;
    }

    /* Responsive Fixes */
    @media (max-width: 768px) {
        .mobile-controls {
            display: flex;
        }

        #snake-game-container { /* Updated ID */
            width: 90vmin;
            height: auto;
            aspect-ratio: 1 / 1;
        }
    }

    @media (max-width: 600px) {
        .controls-wrapper {
            gap: 2rem;
        }

        .ab-buttons {
            flex-direction: row;
            gap: 1rem;
        }
    }

    @media (max-width: 480px) {
        .gba-frame {
            width: 95vw;
            padding: 15px;
        }

        .gba-top-label {
            font-size: 1rem;
        }

        .dpad {
            width: 100px;
            height: 100px;
        }

        .ab-btn {
            width: 50px;
            height: 50px;
            font-size: 1rem;
        }
    }
</style>