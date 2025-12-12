<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>

  <script>
    const canvas = document.getElementById("game");
    const mobileCanvas = document.getElementById("mobileGame");
    const nextCanvas = document.getElementById("next");
    const holdCanvas = document.getElementById("hold");
    const ctx = canvas.getContext("2d");
    const mobileCtx = mobileCanvas.getContext("2d");
    const nextCtx = nextCanvas.getContext("2d");
    const holdCtx = holdCanvas.getContext("2d");

    const ROWS = 20, COLS = 10, BLOCK_SIZE = 30;
    const colors = ["#000", "#00f0f0", "#0000f0", "#f0a000", "#f0f000", "#00f000", "#a000f0", "#f00000"];

    const sounds = {
      move: document.getElementById("moveSound"),
      rotate: document.getElementById("rotateSound"),
      drop: document.getElementById("dropSound"),
      clear: document.getElementById("lineClearSound"),
      gameover: document.getElementById("gameOverSound")
    };

    let board, current, nextPiece, holdPiece = null, hasHeld = false, score = 0, level = 1, interval;
    let isMobile = window.innerWidth < 992; // Bootstrap lg breakpoint

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
      score = 0;
      level = 1;
      hasHeld = false;
      document.getElementById("score").textContent = score;
      document.getElementById("mobileScore").textContent = score;
      document.getElementById("mobileLevel").textContent = level;
      document.getElementById("restartBtn").style.display = "none";
      document.getElementById("mobileRestartBtn").style.display = "none";
      document.getElementById("gameOver").style.display = "none";
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
            ctxRef.fillStyle = colors[val] + "55";
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
        nextPiece.shape.forEach((row, y) => {
          row.forEach((val, x) => {
            if (val) drawBlock(x, y, colors[val], nextCtx, 20);
          });
        });
      }
    }

    function drawHold() {
      holdCtx.clearRect(0, 0, 80, 80);
      if (!holdPiece) return;
      if (holdPiece.shape) {
        holdPiece.shape.forEach((row, y) => {
          row.forEach((val, x) => {
            if (val) drawBlock(x, y, colors[val], holdCtx, 20);
          });
        });
      }
      // Draw on mobile floating hold canvas
      if (window.innerWidth < 992) {
        const mobileHoldCanvas = document.getElementById('mobileHoldCanvas');
        const mobileHoldCtx = mobileHoldCanvas.getContext('2d');
        mobileHoldCtx.clearRect(0, 0, 64, 64);
        if (holdPiece && holdPiece.shape) {
          holdPiece.shape.forEach((row, y) => {
            row.forEach((val, x) => {
              if (val) drawBlock(x, y, colors[val], mobileHoldCtx, 16);
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

    function rotateClockwise() {
      if (!current || !current.shape) return;
      
      const newShape = current.shape[0].map((_, i) => current.shape.map(row => row[i]).reverse());
      const oldShape = current.shape;
      current.shape = newShape;
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
      current.shape = oldShape;
    }

    function rotateCounterClockwise() {
      if (!current || !current.shape) return;
      
      const newShape = current.shape[0].map((_, i) => current.shape.map(row => row[row.length - 1 - i]));
      const oldShape = current.shape;
      current.shape = newShape;
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
      current.shape = oldShape;
    }

    function rotate180() {
      if (!current || !current.shape) return;
      
      const newShape = current.shape.map(row => [...row].reverse()).reverse();
      const oldShape = current.shape;
      current.shape = newShape;
      const kickTests = [
        [0, 0], [-1, 0], [1, 0], [0, -1], [-1, -1], [1, -1], [0, -2], [-1, -2], [1, -2]
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
      current.shape = oldShape;
    }

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
        hasHeld = false;
        if (collides()) {
          clearInterval(interval);
          if (sounds.gameover) sounds.gameover.play().catch(() => {});
          document.getElementById("restartBtn").style.display = "inline-block";
          document.getElementById("gameOver").style.display = "flex";
          if (isMobile) {
            document.getElementById('mobileGameOverModal').style.display = 'flex';
            document.getElementById('mobileRestartBtn').style.display = 'block';
          }
          const gameCanvas = isMobile ? mobileCanvas : canvas;
          const screen = gameCanvas.parentElement;
          const border = screen.parentElement;
          gameCanvas.classList.add("explode");
          screen.classList.add("shake");
          border.classList.add("light-on");
          setTimeout(() => {
            gameCanvas.classList.remove("explode");
            screen.classList.remove("shake");
            border.classList.remove("light-on");
          }, 800);
        }
        if (sounds.drop) sounds.drop.play().catch(() => {});
      }
    }

    function hardDrop() {
      if (!current) return;
      while (move(0, 1));
      drop();
    }

    function merge() {
      if (!current || !current.shape) return;
      
      current.shape.forEach((row, dy) => {
        row.forEach((val, dx) => {
          if (val && board[current.y + dy]) {
            board[current.y + dy][current.x + dx] = val;
          }
        });
      });
    }

    function clearLines() {
      let cleared = 0;
      board = board.filter(row => {
        if (row.every(x => x)) {
          cleared++;
          return false;
        }
        return true;
      });
      while (board.length < ROWS) board.unshift(Array(COLS).fill(0));
      if (cleared) {
        const scoreValues = [0, 100, 300, 500, 800];
        score += scoreValues[cleared] * level;
        const newLevel = Math.floor(score / 1000) + 1;
        if (newLevel > level) {
          level = newLevel;
          clearInterval(interval);
          interval = setInterval(() => {
            drop();
            drawBoard();
            drawNext();
            drawHold();
          }, Math.max(150, 500 - (level - 1) * 30));
        }
        document.getElementById("score").textContent = score;
        document.getElementById("mobileScore").textContent = score;
        document.getElementById("mobileLevel").textContent = level;
        const gameCanvas = isMobile ? mobileCanvas : canvas;
        const screen = gameCanvas.parentElement;
        const border = screen.parentElement;
        gameCanvas.classList.add("explode");
        screen.classList.add("shake");
        border.classList.add("light-on");
        setTimeout(() => {
          gameCanvas.classList.remove("explode");
          screen.classList.remove("shake");
          border.classList.remove("light-on");
        }, 800);
        if (sounds.clear) sounds.clear.play().catch(() => {});
      }
    }

    function hold() {
      if (hasHeld || !current) return;
      if (!holdPiece) {
        holdPiece = current;
        current = nextPiece;
        nextPiece = getRandomPiece();
      } else {
        [holdPiece, current] = [current, holdPiece];
        current.x = 3;
        current.y = 0;
      }
      hasHeld = true;
      drawHold();
      drawNext();
    }

    function glossyBlock(x, y, color, ctxRef, size = BLOCK_SIZE) {
      ctxRef.fillStyle = color;
      ctxRef.fillRect(x * size, y * size, size, size);
      ctxRef.save();
      ctxRef.globalAlpha = 0.35;
      ctxRef.fillStyle = "#fff";
      ctxRef.beginPath();
      ctxRef.moveTo(x * size + 2, y * size + 2);
      ctxRef.lineTo(x * size + size - 2, y * size + 2);
      ctxRef.lineTo(x * size + size - 6, y * size + size / 2);
      ctxRef.lineTo(x * size + 6, y * size + size / 2);
      ctxRef.closePath();
      ctxRef.fill();
      ctxRef.restore();
      ctxRef.strokeStyle = "#fff";
      ctxRef.lineWidth = 1.5;
      ctxRef.strokeRect(x * size + 0.5, y * size + 0.5, size - 1, size - 1);
      ctxRef.strokeStyle = "#222";
      ctxRef.lineWidth = 1;
      ctxRef.strokeRect(x * size + 1, y * size + 1, size - 2, size - 2);
    }

    function drawBlock(x, y, color, ctxRef, size = window.BLOCK_SIZE || BLOCK_SIZE) {
      glossyBlock(x, y, color, ctxRef, size);
    }

    function setupMobileControls() {
      // Remove previous event listeners if any
      const controlIds = [
        'dpad-up', 'dpad-left', 'dpad-right', 'dpad-down', 'dpad-center',
        'btn-a', 'btn-b', 'mobileStartBtn', 'mobileRestartBtn'
      ];
      controlIds.forEach(id => {
        const btn = document.getElementById(id);
        if (btn) {
          const newBtn = btn.cloneNode(true);
          btn.parentNode.replaceChild(newBtn, btn);
        }
      });

      // D-pad
      document.getElementById('dpad-up').addEventListener('touchstart', (e) => {
        e.preventDefault();
        rotateClockwise();
        drawBoard();
      });
      document.getElementById('dpad-left').addEventListener('touchstart', (e) => {
        e.preventDefault();
        move(-1, 0);
        drawBoard();
      });
      document.getElementById('dpad-right').addEventListener('touchstart', (e) => {
        e.preventDefault();
        move(1, 0);
        drawBoard();
      });
      document.getElementById('dpad-down').addEventListener('touchstart', (e) => {
        e.preventDefault();
        move(0, 1);
        drawBoard();
      });
      // Center does nothing

      // A = Hold
      document.getElementById('btn-a').addEventListener('touchstart', (e) => {
        e.preventDefault();
        hold();
        drawBoard();
      });

      // B = Hard Drop
      document.getElementById('btn-b').addEventListener('touchstart', (e) => {
        e.preventDefault();
        hardDrop();
        drawBoard();
      });

      // Start
      document.getElementById('mobileStartBtn').addEventListener('touchstart', (e) => {
        e.preventDefault();
        initGame();
      });

      // Play Again
      document.getElementById('mobileRestartBtn').addEventListener('touchstart', (e) => {
        e.preventDefault();
        document.getElementById('mobileGameOverModal').style.display = 'none';
        initGame();
      });
    }

    // --- KEYBOARD CONTROLS (Desktop) ---
    document.addEventListener("keydown", e => {
      if (isMobile) return;
      const key = e.key.toLowerCase();
      if (["arrowleft","arrowright","arrowdown","arrowup"," ","a","d","s","w","j","z","q","l","c","shift"].includes(key)) {
        e.preventDefault();
      }
      switch (key) {
        case "arrowleft": case "a": move(-1, 0); break;
        case "arrowright": case "d": move(1, 0); break;
        case "arrowdown": case "s": move(0, 1); break;
        case " ": hardDrop(); break;
        case "arrowup": case "w": rotateClockwise(); break;
        case "j": case "z": case "q": rotateCounterClockwise(); break;
        case "l": rotate180(); break;
        case "c": case "shift": hold(); break;
      }
      drawBoard();
    });

    // --- GAME CONTROL BUTTONS ---
    document.getElementById("startBtn").addEventListener("click", initGame);
    document.getElementById("mobileStartBtn").addEventListener("click", initGame);
    document.getElementById("restartBtn").addEventListener("click", initGame);
    document.getElementById("mobileRestartBtn").addEventListener("click", initGame);

    // --- RESPONSIVE CANVAS RESIZING ---
    function resizeGameCanvas() {
      isMobile = window.innerWidth < 992;
      if (isMobile) {
        // Mobile: fit canvas to container width, keep aspect ratio
        const container = document.querySelector('.mobile-game-container');
        const controls = document.querySelector('.mobile-tetris-container .w-100.pb-2');
        let availableHeight = window.innerHeight;
        if (controls) availableHeight -= controls.offsetHeight;
        // Score display height
        const scoreRow = document.querySelector('.mobile-tetris-container .w-100.text-center');
        if (scoreRow) availableHeight -= scoreRow.offsetHeight;
        // Reduce padding fudge factor for more space
        availableHeight -= 8;
        // Set width to 100vw, but not more than availableHeight * aspect ratio
        let width = Math.min(window.innerWidth, (availableHeight * COLS) / ROWS);
        let height = (width * ROWS) / COLS;
        mobileCanvas.width = Math.round(width);
        mobileCanvas.height = Math.round(height);
        mobileCanvas.style.width = width + 'px';
        mobileCanvas.style.height = height + 'px';
        window.BLOCK_SIZE = width / COLS;
        // Set CSS variable for responsive grid
        mobileCanvas.style.setProperty('--block-size', `${window.BLOCK_SIZE}px`);
      } else {
        // Desktop
        let vw = Math.min(window.innerWidth, 600);
        let block = Math.floor((vw * 0.98) / COLS);
        if (block > 30) block = 30;
        if (block < 16) block = 16;
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
    window.addEventListener('resize', resizeGameCanvas);
    document.addEventListener('DOMContentLoaded', function() {
      resizeGameCanvas();
      setupMobileControls();
      // Show mobile hold floating box if mobile
      if (window.innerWidth < 992) {
        document.getElementById('mobileHoldFloating').style.display = 'block';
      }
    });
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
      resizeGameCanvas();
      setupMobileControls();
    }
  </script>