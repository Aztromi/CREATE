<style>
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

    /* Main Game Area */
    #game-container {
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
    .overlay {
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

    .overlay h1 {
    font-size: 2.5rem;
    color: #00ffcc;
    text-shadow: 0 0 10px #00ffcc;
    margin-bottom: 20px;
    }

    .overlay button {
    padding: 12px 30px;
    font-size: 1.1rem;
    background-color: #00bcd4;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
    }

    .overlay #close-btn {
        background-color: #c21f39 !important;
    }

    .overlay button:hover {
    background-color: #0097a7;
    }

    .overlay input[type="color"] {
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
    padding: 0.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    }

    .gba-top-label {
    font-size: 0.8rem;
    font-weight: bold;
    color: white;
    text-shadow: 1px 1px 2px black;
    font-family: 'Arial Black', sans-serif;
    }

    .gba-screen {
    width: 100%;
    max-width: 100%;
    aspect-ratio: 1 / 1;
    background: #000;
    border: 6px solid #333;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px;
    }

    .gba-controls {
    display: flex;
    justify-content: center;
    padding: 1rem 0.5rem;
    width: 100%;
    }

    .controls-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 3rem;
    flex-wrap: wrap;
    }

    /* D-Pad Styling */
    .dpad {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    }

    .dpad-btn {
    background-color: #2b2b2b;
    color: white;
    border: none;
    width: 50px;
    height: 50px;
    font-size: 1.4rem;
    border-radius: 8px;
    box-shadow: inset -2px -2px 4px #000, inset 2px 2px 4px #555;
    }

    .dpad-horizontal {
    display: flex;
    gap: 0.5rem;
    }

    /* A/B Buttons */
    .ab-buttons {
    display: flex;
    flex-direction: column;
    gap: 1.2rem;
    align-items: center;
    }

    .ab-btn {
    background-color: #c21f39;
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

        #game-container {
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
        padding: 0.25rem;
    }

    .gba-controls {
        padding: 0.5rem 0;
    }

    .gba-screen {
        width: 100%;
        height: auto;
        aspect-ratio: 1 / 1;
    }

    .dpad-btn, .ab-btn {
        width: 60px;
        height: 60px;
        font-size: 1rem;
    }

    .ab-buttons {
        gap: 10px;
    }
    }

    @media (min-height: 700px) and (min-width: 1000px) {
    body {
        justify-content: center;
        padding: 0;
        overflow-y: hidden;
    }
    }

</style>