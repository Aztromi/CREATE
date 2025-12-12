<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script>
(function() { // Start of IIFE for Tetris Game
    const canvas = document.getElementById("tetris-game");
    const mobileCanvas = document.getElementById("tetris-mobileGame");
    const nextCanvas = document.getElementById("tetris-next");
    const holdCanvas = document.getElementById("tetris-hold");
    const ctx = canvas.getContext("2d");
    const mobileCtx = mobileCanvas.getContext("2d");
    const nextCtx = nextCanvas.getContext("2d");
    const holdCtx = holdCanvas.getContext("2d");

    const ROWS = 20, COLS = 10, BLOCK_SIZE = 30; // BLOCK_SIZE will be dynamically set by resizeGameCanvas
    const colors = ["#000", "#00f0f0", "#0000f0", "#f0a000", "#f0f000", "#00f000", "#a000f0", "#f00000"];

    // Ensure audio elements exist or create them
    const sounds = {
        move: document.getElementById("tetris-moveSound") || new Audio(),
        rotate: document.getElementById("tetris-rotateSound") || new Audio(),
        drop: document.getElementById("tetris-dropSound") || new Audio(),
        clear: document.getElementById("tetris-lineClearSound") || new Audio(),
        gameover: document.getElementById("tetris-gameOverSound") || new Audio()
    };

    let board, current, nextPiece, holdPiece = null, hasHeld = false, score = 0, level = 1, interval;
    let isMobile = window.innerWidth < 992; // Bootstrap lg breakpoint
    let isTetrisGameActive = false; // New flag to control keydown listener

    const pieces = [
      [[1,1,1,1]],
      [[2,0,0],[2,2,2]],
      [[0,0,3],[3,3,3]],
      [[4,4],[4,4]],
      [[0,5,5],[5,5,0]],
      [[0,6,0],[6,6,6]],
      [[7,7,0],[0,7,7]]
    ];

    const getRandomPiece = () => {
      const shape = pieces[Math.floor(Math.random() * pieces.length)];
      return { shape, x: 3, y: 0 };
    };

    // Add grid overlay to canvas
    canvas.classList.add("grid");
    mobileCanvas.classList.add("grid");

    function initGame() {
      board = Array.from({length: ROWS}, () => Array(COLS).fill(0));
      current = getRandomPiece();
      nextPiece = getRandomPiece();
      holdPiece = null; // Reset hold piece
      hasHeld = false;
      score = 0;
      level = 1;
      document.getElementById("tetris-score").textContent = score;
      document.getElementById("tetris-mobileScore").textContent = score;
      document.getElementById("tetris-mobileLevel").textContent = level;
      document.getElementById("tetris-restartBtn").style.display = "none";
      document.getElementById("tetris-mobileRestartBtn").style.display = "none";
      document.getElementById("tetris-gameOver").style.display = "none";
      document.getElementById("tetris-mobileGameOverModal").style.display = "none"; // Hide mobile game over modal

      clearInterval(interval);
      interval = setInterval(() => {
        drop();
        drawBoard();
        drawNext();
        drawHold();
      }, Math.max(150, 500 - (level - 1) * 30));
      drawBoard();
      drawNext();
      drawHold();
      isTetrisGameActive = true; // Activate key listener
    }

    function drawBlock(x, y, color, context, sizeOverride = null) {
      const size = sizeOverride || window.BLOCK_SIZE;
      context.fillStyle = color;
      context.fillRect(x * size, y * size, size, size);
      context.strokeStyle = "#111"; // Block border
      context.strokeRect(x * size, y * size, size, size);
    }

    function drawBoard() {
      try {
        const activeCtx = isMobile ? mobileCtx : ctx;
        const activeCanvas = isMobile ? mobileCanvas : canvas;
        
        // Clear the canvas first
        activeCtx.clearRect(0, 0, activeCanvas.width, activeCanvas.height);
        
        // Draw the board
        for (let y = 0; y < ROWS; y++) {
          for (let x = 0; x < COLS; x++) {
            if (board[y] && board[y][x]) {
              drawBlock(x, y, colors[board[y][x]], activeCtx);
            }
          }
        }
        
        // Draw ghost piece
        drawGhost(activeCtx);
        
        // Draw current piece
        if (current && current.shape) {
          current.shape.forEach((row, dy) => {
            row.forEach((val, dx) => {
              if (val) {
                drawBlock(current.x + dx, current.y + dy, colors[val], activeCtx);
              }
            });
          });
        }
      } catch (error) {
        console.error("Error in drawBoard:", error);
      }
    }

    function drawGhost(ctxRef = ctx) {
      if (!current || !current.shape) return;
      
      let ghostY = current.y;
      const size = window.BLOCK_SIZE || BLOCK_SIZE;
      while (!collidesAt(current.shape, current.x, ghostY + 1)) ghostY++;
      current.shape.forEach((row, dy) => {
        row.forEach((val, dx) => {
          if (val) {
            ctxRef.fillStyle = colors[val] + "55"; // Semi-transparent
            ctxRef.fillRect((current.x + dx) * size, (ghostY + dy) * size, size, size);
            ctxRef.strokeStyle = "#444";
            ctxRef.strokeRect((current.x + dx) * size, (ghostY + dy) * size, size, size);
          }
        });
      });
    }

    function collidesAt(shape, offsetX, offsetY) {
      return shape.some((row, dy) =>
        row.some((val, dx) => {
          let x = offsetX + dx;
          let y = offsetY + dy;
          return val && (x < 0 || x >= COLS || y >= ROWS || (board[y] && board[y][x]));
        })
      );
    }

    function drawNext() {
      nextCtx.clearRect(0, 0, 80, 80);
      if (nextPiece && nextPiece.shape) {
        // Center the piece for display
        let pieceWidth = nextPiece.shape[0].length;
        let pieceHeight = nextPiece.shape.length;
        let startX = (80 / 20 - pieceWidth) / 2; // Assuming 20px block size for next/hold
        let startY = (80 / 20 - pieceHeight) / 2;
        nextPiece.shape.forEach((row, y) => {
          row.forEach((val, x) => {
            if (val) drawBlock(startX + x, startY + y, colors[val], nextCtx, 20);
          });
        });
      }
    }

    function drawHold() {
      holdCtx.clearRect(0, 0, 80, 80);
      if (!holdPiece) return;
      if (holdPiece.shape) {
        let pieceWidth = holdPiece.shape[0].length;
        let pieceHeight = holdPiece.shape.length;
        let startX = (80 / 20 - pieceWidth) / 2;
        let startY = (80 / 20 - pieceHeight) / 2;
        holdPiece.shape.forEach((row, y) => {
          row.forEach((val, x) => {
            if (val) drawBlock(startX + x, startY + y, colors[val], holdCtx, 20);
          });
        });
      }
      // Draw on mobile floating hold canvas
      if (window.innerWidth < 992) {
        const mobileHoldCanvas = document.getElementById('tetris-mobileHoldCanvas');
        const mobileHoldCtx = mobileHoldCanvas.getContext('2d');
        mobileHoldCtx.clearRect(0, 0, 64, 64);
        if (holdPiece && holdPiece.shape) {
            let pieceWidth = holdPiece.shape[0].length;
            let pieceHeight = holdPiece.shape.length;
            let startX = (64 / 16 - pieceWidth) / 2; // Assuming 16px block size for mobile hold
            let startY = (64 / 16 - pieceHeight) / 2;
            holdPiece.shape.forEach((row, y) => {
                row.forEach((val, x) => {
                    if (val) drawBlock(startX + x, startY + y, colors[val], mobileHoldCtx, 16);
                });
            });
        }
      }
    }

    function move(dx, dy) {
      if (!current) return false;
      current.x += dx;
      current.y += dy;
      if (collides()) {
        current.x -= dx;
        current.y -= dy;
        return false;
      }
      if (sounds.move) sounds.move.play().catch(() => {});
      return true;
    }

    function rotate(direction) {
        if (!current || !current.shape) return;

        const oldShape = current.shape;
        let newShape;

        if (direction === 'clockwise') {
            newShape = current.shape[0].map((_, i) => current.shape.map(row => row[i]).reverse());
        } else if (direction === 'counter-clockwise') {
            newShape = current.shape[0].map((_, i) => current.shape.map(row => row[row.length - 1 - i]));
        } else if (direction === '180') {
            newShape = current.shape.map(row => [...row].reverse()).reverse();
        } else {
            return; // Invalid direction
        }

        current.shape = newShape;

        // Kick table for wall/block collisions during rotation
        // Simplified for now, a full SRS (Super Rotation System) would be more complex
        const kickTests = [
            [0, 0], [-1, 0], [1, 0], [0, -1], [-1, -1], [1, -1], [-2, 0], [2, 0], [0, -2], [-1, -2], [1, -2]
        ];

        for (let [dx, dy] of kickTests) {
            current.x += dx;
            current.y += dy;
            if (!collides()) {
                if (sounds.rotate) sounds.rotate.play().catch(() => {});
                return;
            }
            current.x -= dx;
            current.y -= dy;
        }

        current.shape = oldShape; // Revert if all kicks fail
    }

    function rotateClockwise() { rotate('clockwise'); }
    function rotateCounterClockwise() { rotate('counter-clockwise'); }
    function rotate180() { rotate('180'); }


    function collides() {
      if (!current || !current.shape) return true;
      return collidesAt(current.shape, current.x, current.y);
    }

    function drop() {
      if (!current || !move(0, 1)) {
        merge();
        clearLines();
        current = nextPiece;
        nextPiece = getRandomPiece();
        hasHeld = false; // Reset hasHeld when new piece drops
        if (collides()) { // Game Over condition
          clearInterval(interval);
          if (sounds.gameover) sounds.gameover.play().catch(() => {});
          document.getElementById("tetris-restartBtn").style.display = "inline-block";
          document.getElementById("tetris-gameOver").style.display = "flex";
          if (isMobile) {
            document.getElementById('tetris-mobileGameOverModal').style.display = 'flex';
            document.getElementById('tetris-mobileRestartBtn').style.display = 'block';
          }
          const gameCanvas = isMobile ? mobileCanvas : canvas;
          const screen = gameCanvas.parentElement;
          const border = screen.parentElement;
          gameCanvas.classList.add("explode"); // Animation class
          screen.classList.add("shake"); // Animation class
          border.classList.add("light-on"); // Animation class
        }
      }
    }

    function merge() {
      if (!current || !current.shape) return;
      current.shape.forEach((row, dy) => {
        row.forEach((val, dx) => {
          if (val) {
            board[current.y + dy][current.x + dx] = val;
          }
        });
      });
      if (sounds.drop) sounds.drop.play().catch(() => {});
    }

    function clearLines() {
      let linesCleared = 0;
      for (let y = ROWS - 1; y >= 0; y--) {
        if (board[y].every(val => val !== 0)) {
          board.splice(y, 1);
          board.unshift(Array(COLS).fill(0));
          linesCleared++;
          y++; // Check the new line at the same row index
        }
      }
      if (linesCleared > 0) {
        score += linesCleared * 100 * level; // Simple scoring
        document.getElementById("tetris-score").textContent = score;
        document.getElementById("tetris-mobileScore").textContent = score;
        if (sounds.clear) sounds.clear.play().catch(() => {});

        // Level up logic
        const linesToLevelUp = 10; // Clear 10 lines to level up
        if (score >= level * linesToLevelUp * 100) { // Check if score is enough for next level
            level++;
            document.getElementById("tetris-mobileLevel").textContent = level;
            clearInterval(interval);
            interval = setInterval(() => {
                drop();
                drawBoard();
                drawNext();
                drawHold();
            }, Math.max(150, 500 - (level - 1) * 30)); // Speed up
        }
      }
    }

    function holdPiece() {
        if (hasHeld) return; // Can only hold once per piece

        if (holdPiece) {
            // Swap current and held piece
            [current, holdPiece] = [holdPiece, current];
            current.x = 3; // Reset position
            current.y = 0;
        } else {
            // Hold current piece and get a new one
            holdPiece = current;
            current = nextPiece;
            nextPiece = getRandomPiece();
        }
        hasHeld = true; // Mark as held
        drawHold();
        drawBoard();
        drawNext();
    }

    function handleKeydown(e) {
      if (!isTetrisGameActive) return; // Only respond if game is active
      const gameCanvas = isMobile ? mobileCanvas : canvas;
      const screen = gameCanvas.parentElement;
      const border = screen.parentElement;

      // Remove shake/light-on effect on first keydown after game over
      if (gameCanvas.classList.contains("explode")) {
          gameCanvas.classList.remove("explode");
          screen.classList.remove("shake");
          border.classList.remove("light-on");
      }

      switch (e.key) {
        case "ArrowLeft": move(-1, 0); break;
        case "ArrowRight": move(1, 0); break;
        case "ArrowDown": move(0, 1); break; // Soft drop
        case "ArrowUp": rotateClockwise(); break;
        case "z": rotateCounterClockwise(); break; // Counter-clockwise rotation
        case "x": rotateClockwise(); break; // Clockwise rotation
        case "c": holdPiece(); break; // Hold piece
        case " ": hardDrop(); e.preventDefault(); break; // Hard drop, prevent page scroll
      }
      drawBoard();
    }

    function hardDrop() {
        if (sounds.drop) sounds.drop.play().catch(() => {});
        while (move(0, 1)); // Move down until collision
        drop(); // Merge and get new piece
    }

    // Mobile controls setup
    function setupMobileControls() {
        document.getElementById('tetris-dpad-left').addEventListener('click', () => { move(-1, 0); drawBoard(); });
        document.getElementById('tetris-dpad-right').addEventListener('click', () => { move(1, 0); drawBoard(); });
        document.getElementById('tetris-dpad-down').addEventListener('click', () => { move(0, 1); drawBoard(); });
        document.getElementById('tetris-btn-rotate-ccw').addEventListener('click', () => { rotateCounterClockwise(); drawBoard(); });
        document.getElementById('tetris-btn-rotate-cw').addEventListener('click', () => { rotateClockwise(); drawBoard(); });
        document.getElementById('tetris-btn-hold').addEventListener('click', () => { holdPiece(); drawBoard(); });
        document.getElementById('tetris-btn-a').addEventListener('click', hardDrop); // A button for hard drop
        document.getElementById('tetris-btn-b').addEventListener('click', rotateClockwise); // B button for rotation

        document.getElementById('tetris-mobileStartBtn').addEventListener('click', initGame);
        document.getElementById('tetris-mobileRestartBtn').addEventListener('click', initGame);

        // Swipe controls (simplified)
        let startY, endY;
        const swipeArea = mobileCanvas; // Or a larger div if preferred
        swipeArea.addEventListener('touchstart', (e) => {
            startY = e.touches[0].clientY;
        });
        swipeArea.addEventListener('touchmove', (e) => {
            e.preventDefault(); // Prevent scrolling
        });
        swipeArea.addEventListener('touchend', (e) => {
            endY = e.changedTouches[0].clientY;
            if (startY - endY > 50) { // Swipe up for hard drop
                hardDrop();
            } else if (endY - startY > 50) { // Swipe down for soft drop
                move(0,1); // Just one step
            }
        });
    }

    // Responsive Canvas Resizing
    function resizeGameCanvas() {
      isMobile = window.innerWidth < 992;
      if (isMobile) {
        // Mobile specific sizing
        let vh = Math.min(window.innerHeight, 900); // Cap max height
        let vw = Math.min(window.innerWidth, 500); // Cap max width
        let gameHeight = vh * 0.5; // Use 50% of viewport height for game
        let block = Math.floor(gameHeight / ROWS);
        if (block < 12) block = 12; // Minimum block size for readability

        const width = COLS * block;
        const height = ROWS * block;
        mobileCanvas.width = Math.round(width);
        mobileCanvas.height = Math.round(height);
        mobileCanvas.style.width = width + 'px';
        mobileCanvas.style.height = height + 'px';
        window.BLOCK_SIZE = width / COLS;
        // Set CSS variable for responsive grid
        mobileCanvas.style.setProperty('--block-size', `${window.BLOCK_SIZE}px`);
      } else {
        // Desktop
        let vw = Math.min(window.innerWidth, 600); // Max game area width
        let block = Math.floor((vw * 0.98) / COLS);
        if (block > 30) block = 30; // Max block size
        if (block < 16) block = 16; // Min block size
        const width = COLS * block;
        const height = ROWS * block;
        canvas.width = width;
        canvas.height = height;
        canvas.style.width = width + 'px';
        canvas.style.height = height + 'px';
        window.BLOCK_SIZE = block;
        canvas.style.setProperty('--block-size', `${window.BLOCK_SIZE}px`);
      }
      drawBoard();
      drawNext();
      drawHold();
    }

    // --- INIT ---
    // Attach event listeners to the Tetris game container when it's shown
    $('#tetris-container-game').on('shown.bs.modal', function () {
        // If not using Bootstrap modal, then attach to a general element or window load
        resizeGameCanvas();
        setupMobileControls();
        initGame(); // Start game when modal is shown

        $(document).on('keydown.tetrisGame', handleKeydown); // Namespaced event listener
        // Show mobile hold floating box if mobile
        if (window.innerWidth < 992) {
            document.getElementById('tetris-mobileHoldFloating').style.display = 'block';
        }
    });

    $('#tetris-container-game').on('hidden.bs.modal', function () {
        $(document).off('keydown.tetrisGame'); // Remove namespaced event listener
        clearInterval(interval); // Stop the game when modal is closed
        isTetrisGameActive = false; // Deactivate key listener
        // Optionally reset game state or hide elements
        document.getElementById('tetris-mobileHoldFloating').style.display = 'none';
    });

    document.getElementById('tetris-startBtn').addEventListener('click', initGame);
    document.getElementById('tetris-restartBtn').addEventListener('click', initGame);

    // Initial resize on load (if game is immediately visible or for initial setup)
    document.addEventListener('DOMContentLoaded', function() {
      // If your Tetris game is initially hidden and shown via a modal,
      // the resize and initGame calls should ideally be triggered when the modal opens (as above).
      // This is a fallback/initial setup if the game is displayed immediately.
      // resizeGameCanvas();
      // setupMobileControls();
      // if (window.innerWidth < 992) {
      //   document.getElementById('tetris-mobileHoldFloating').style.display = 'block';
      // }
    });

    window.addEventListener('resize', resizeGameCanvas); // Still listen for general resize
})(); // End of IIFE for Tetris Game
</script>