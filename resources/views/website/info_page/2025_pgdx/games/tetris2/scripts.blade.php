<script>
    let play_id = '';
    let gameInstance = null;

    async function gameStart() {
        play_id = await generateID('tetris');
        if (gameInstance) {
            gameInstance.reset();
        } else {
            gameInstance = new TetrisGame();
        }
        $('#modal-tetris-1').modal('hide');
    }

    function setGameModal(state, score) {
        switch (state) {
            case 'start':
                $('#modal-tetris-1 .game-over-container').hide();
                $('#modal-tetris-1 .score-container').hide();
                $('#modal-tetris-1 .button-container #btn-start').text('START GAME');
                break;
            case 'end':
                $('#modal-tetris-1 .game-over-container').show();
                $('#modal-tetris-1 .score-container').show();
                $('#modal-tetris-1 .score-container .score-actual').text(score);
                $('#modal-tetris-1 .button-container #btn-start').text('RESTART GAME');
                break;
            default:
                $('#modal-tetris-1 .game-over-container').hide();
                $('#modal-tetris-1 .score-container').hide();
                $('#modal-tetris-1 .button-container #btn-start').text('START GAME');
                break;
        }
        $("#modal-tetris-1").modal('show');
    }

    class Particle {
        constructor(x, y, color) {
            this.x = x;
            this.y = y;
            this.vx = (Math.random() - 0.5) * 8;
            this.vy = (Math.random() - 0.5) * 8;
            this.color = color;
            this.life = 1;
            this.decay = 0.02;
            this.size = Math.random() * 4 + 2;
        }
        update() {
            this.x += this.vx;
            this.y += this.vy;
            this.vy += 0.2;
            this.life -= this.decay;
            this.size *= 0.98;
        }
        draw(ctx) {
            ctx.save();
            ctx.globalAlpha = this.life;
            ctx.fillStyle = this.color;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();
            ctx.restore();
        }
    }
    class TetrisGame {
        constructor() {
            this.canvas = document.getElementById('gameCanvas');
            this.ctx = this.canvas.getContext('2d');
            this.nextCanvas = document.getElementById('nextCanvas');
            this.nextCtx = this.nextCanvas.getContext('2d');
            this.blockSize = 30;
            this.cols = 10;
            this.rows = 20;
            this.reset();
            this.bindEvents();
            this.gameLoop();
        }
        reset() {
            this.board = Array(this.rows).fill().map(() => Array(this.cols).fill(0));
            this.score = 0;
            this.level = 1;
            this.lines = 0;
            this.dropTime = 0;
            this.dropInterval = 1000;
            this.lastTime = 0;
            this.gameOver = false;
            this.paused = false;
            this.particles = [];
            this.currentPiece = null;
            this.nextPiece = null;
            this.holdPiece = null;
            this.canHold = true;
            this.combo = 0;
            this.maxCombo = 0;
            this.explosionMeter = 0;
            this.explosionMode = false;
            this.pieces = {
                I: {
                    shape: [
                        [1, 1, 1, 1]
                    ],
                    color: '#00f5ff',
                    glow: '#00aaff'
                },
                O: {
                    shape: [
                        [1, 1],
                        [1, 1]
                    ],
                    color: '#ffff00',
                    glow: '#ffaa00'
                },
                T: {
                    shape: [
                        [0, 1, 0],
                        [1, 1, 1]
                    ],
                    color: '#a000f0',
                    glow: '#8000c0'
                },
                S: {
                    shape: [
                        [0, 1, 1],
                        [1, 1, 0]
                    ],
                    color: '#00ff00',
                    glow: '#00aa00'
                },
                Z: {
                    shape: [
                        [1, 1, 0],
                        [0, 1, 1]
                    ],
                    color: '#ff0000',
                    glow: '#aa0000'
                },
                J: {
                    shape: [
                        [1, 0, 0],
                        [1, 1, 1]
                    ],
                    color: '#0000ff',
                    glow: '#0000aa'
                },
                L: {
                    shape: [
                        [0, 0, 1],
                        [1, 1, 1]
                    ],
                    color: '#ff8000',
                    glow: '#aa5500'
                }
            };
            this.specialPieces = {
                BOMB: {
                    shape: [
                        [1]
                    ],
                    color: '#ff1493',
                    glow: '#ff69b4',
                    type: 'bomb'
                },
                CLEAR: {
                    shape: [
                        [1, 1],
                        [1, 1]
                    ],
                    color: '#00ffff',
                    glow: '#87ceeb',
                    type: 'clear'
                }
            };
            this.pieceTypes = Object.keys(this.pieces);
            this.currentPiece = this.createPiece();
            this.nextPiece = this.createPiece();
            this.updateUI();
            document.getElementById('explosionModeIndicator').style.display = 'none';
        }
        createPiece() {
            const type = this.pieceTypes[Math.floor(Math.random() * this.pieceTypes.length)];
            const piece = this.pieces[type];
            return {
                shape: piece.shape,
                color: piece.color,
                glow: piece.glow,
                x: Math.floor(this.cols / 2) - Math.floor(piece.shape[0].length / 2),
                y: 0,
                type: 'normal'
            };
        }
        createSpecialPiece() {
            const specialTypes = Object.keys(this.specialPieces);
            const type = specialTypes[Math.floor(Math.random() * specialTypes.length)];
            const piece = this.specialPieces[type];
            return {
                shape: piece.shape,
                color: piece.color,
                glow: piece.glow,
                x: Math.floor(this.cols / 2) - Math.floor(piece.shape[0].length / 2),
                y: 0,
                type: piece.type
            };
        }
        holdCurrentPiece() {
            if (!this.canHold) return;
            if (this.holdPiece) {
                const temp = this.currentPiece;
                this.currentPiece = this.holdPiece;
                this.holdPiece = temp;
                this.currentPiece.x = Math.floor(this.cols / 2) - Math.floor(this.currentPiece.shape[0].length / 2);
                this.currentPiece.y = 0;
            } else {
                this.holdPiece = this.currentPiece;
                this.currentPiece = this.nextPiece;
                this.nextPiece = this.createPiece();
            }
            this.canHold = false;
        }
        handleSpecialPiece(piece) {
            if (piece.type === 'bomb') {
                this.triggerBombEffect(piece);
            } else if (piece.type === 'clear') {
                this.triggerClearEffect(piece);
            }
        }
        triggerBombEffect(piece) {
            const centerX = piece.x;
            const centerY = piece.y;
            for (let i = 0; i < 20; i++) {
                const x = centerX * this.blockSize + this.blockSize / 2;
                const y = centerY * this.blockSize + this.blockSize / 2;
                this.particles.push(new Particle(x, y, '#ff1493'));
            }
            for (let y = Math.max(0, centerY - 1); y <= Math.min(this.rows - 1, centerY + 1); y++) {
                for (let x = Math.max(0, centerX - 1); x <= Math.min(this.cols - 1, centerX + 1); x++) {
                    if (this.board[y][x]) {
                        this.board[y][x] = 0;
                    }
                }
            }
            this.triggerClearEffects(1);
        }
        triggerClearEffect(piece) {
            const targetColor = piece.color;
            let clearedCount = 0;
            for (let y = 0; y < this.rows; y++) {
                for (let x = 0; x < this.cols; x++) {
                    if (this.board[y][x] && this.board[y][x].color === targetColor) {
                        this.board[y][x] = 0;
                        clearedCount++;
                        const pixelX = x * this.blockSize + this.blockSize / 2;
                        const pixelY = y * this.blockSize + this.blockSize / 2;
                        this.particles.push(new Particle(pixelX, pixelY, targetColor));
                    }
                }
            }
            if (clearedCount > 0) {
                this.triggerClearEffects(clearedCount);
            }
        }
        drawBlock(x, y, color, glow = null) {
            const pixelX = x * this.blockSize;
            const pixelY = y * this.blockSize;
            if (glow) {
                this.ctx.shadowColor = glow;
                this.ctx.shadowBlur = 15;
            }
            const gradient = this.ctx.createLinearGradient(
                pixelX, pixelY,
                pixelX + this.blockSize, pixelY + this.blockSize
            );
            gradient.addColorStop(0, color);
            gradient.addColorStop(1, this.darkenColor(color, 0.3));
            this.ctx.fillStyle = gradient;
            this.ctx.fillRect(pixelX + 2, pixelY + 2, this.blockSize - 4, this.blockSize - 4);
            this.ctx.fillStyle = this.lightenColor(color, 0.3);
            this.ctx.fillRect(pixelX + 4, pixelY + 4, this.blockSize - 8, 4);
            this.ctx.shadowBlur = 0;
        }
        darkenColor(color, amount) {
            const num = parseInt(color.replace("#", ""), 16);
            const amt = Math.round(2.55 * amount * 100);
            const R = (num >> 16) - amt;
            const G = (num >> 8 & 0x00FF) - amt;
            const B = (num & 0x0000FF) - amt;
            return "#" + (0x1000000 + (R < 255 ? R < 1 ? 0 : R : 255) * 0x10000 +
                (G < 255 ? G < 1 ? 0 : G : 255) * 0x100 +
                (B < 255 ? B < 1 ? 0 : B : 255)).toString(16).slice(1);
        }
        lightenColor(color, amount) {
            const num = parseInt(color.replace("#", ""), 16);
            const amt = Math.round(2.55 * amount * 100);
            const R = (num >> 16) + amt;
            const G = (num >> 8 & 0x00FF) + amt;
            const B = (num & 0x0000FF) + amt;
            return "#" + (0x1000000 + (R > 255 ? 255 : R) * 0x10000 +
                (G > 255 ? 255 : G) * 0x100 +
                (B > 255 ? 255 : B)).toString(16).slice(1);
        }
        drawBoard() {
            this.ctx.fillStyle = 'rgba(0, 0, 0, 0.1)';
            this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
            this.ctx.strokeStyle = 'rgba(255, 255, 255, 0.1)';
            this.ctx.lineWidth = 1;
            for (let x = 0; x <= this.cols; x++) {
                this.ctx.beginPath();
                this.ctx.moveTo(x * this.blockSize, 0);
                this.ctx.lineTo(x * this.blockSize, this.canvas.height);
                this.ctx.stroke();
            }
            for (let y = 0; y <= this.rows; y++) {
                this.ctx.beginPath();
                this.ctx.moveTo(0, y * this.blockSize);
                this.ctx.lineTo(this.canvas.width, y * this.blockSize);
                this.ctx.stroke();
            }
            for (let y = 0; y < this.rows; y++) {
                for (let x = 0; x < this.cols; x++) {
                    if (this.board[y][x]) {
                        this.drawBlock(x, y, this.board[y][x].color, this.board[y][x].glow);
                    }
                }
            }
        }
        drawPiece(piece, offsetX = 0, offsetY = 0) {
            piece.shape.forEach((row, y) => {
                row.forEach((value, x) => {
                    if (value) {
                        this.drawBlock(
                            piece.x + x + offsetX,
                            piece.y + y + offsetY,
                            piece.color,
                            piece.glow
                        );
                    }
                });
            });
        }
        drawNextPiece() {
            const canvas = document.getElementById('nextCanvas');
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            if (!this.nextPiece) return;
            const blockSize = 20;
            const offsetX = (canvas.width - this.nextPiece.shape[0].length * blockSize) / 2;
            const offsetY = (canvas.height - this.nextPiece.shape.length * blockSize) / 2;
            for (let y = 0; y < this.nextPiece.shape.length; y++) {
                for (let x = 0; x < this.nextPiece.shape[y].length; x++) {
                    if (this.nextPiece.shape[y][x]) {
                        const drawX = offsetX + x * blockSize;
                        const drawY = offsetY + y * blockSize;
                        ctx.shadowColor = this.nextPiece.glow;
                        ctx.shadowBlur = 10;
                        ctx.fillStyle = this.nextPiece.color;
                        ctx.fillRect(drawX, drawY, blockSize - 1, blockSize - 1);
                        ctx.shadowBlur = 0;
                        ctx.fillStyle = 'rgba(255, 255, 255, 0.3)';
                        ctx.fillRect(drawX, drawY, blockSize - 1, 2);
                        ctx.fillRect(drawX, drawY, 2, blockSize - 1);
                    }
                }
            }
        }
        drawHoldPiece() {
            const canvas = document.getElementById('holdCanvas');
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            if (!this.holdPiece) return;
            const blockSize = 20;
            const offsetX = (canvas.width - this.holdPiece.shape[0].length * blockSize) / 2;
            const offsetY = (canvas.height - this.holdPiece.shape.length * blockSize) / 2;
            if (!this.canHold) ctx.globalAlpha = 0.5;
            for (let y = 0; y < this.holdPiece.shape.length; y++) {
                for (let x = 0; x < this.holdPiece.shape[y].length; x++) {
                    if (this.holdPiece.shape[y][x]) {
                        const drawX = offsetX + x * blockSize;
                        const drawY = offsetY + y * blockSize;
                        ctx.shadowColor = this.holdPiece.glow;
                        ctx.shadowBlur = 10;
                        ctx.fillStyle = this.holdPiece.color;
                        ctx.fillRect(drawX, drawY, blockSize - 1, blockSize - 1);
                        ctx.shadowBlur = 0;
                        ctx.fillStyle = 'rgba(255, 255, 255, 0.3)';
                        ctx.fillRect(drawX, drawY, blockSize - 1, 2);
                        ctx.fillRect(drawX, drawY, 2, blockSize - 1);
                    }
                }
            }
            ctx.globalAlpha = 1;
        }
        isValidMove(piece, offsetX = 0, offsetY = 0) {
            return piece.shape.every((row, y) => {
                return row.every((value, x) => {
                    const newX = piece.x + x + offsetX;
                    const newY = piece.y + y + offsetY;
                    return (
                        value === 0 ||
                        (newX >= 0 && newX < this.cols &&
                            newY >= 0 && newY < this.rows &&
                            !this.board[newY][newX])
                    );
                });
            });
        }
        async placePiece() {
            if (!this.currentPiece) return;
            if (this.currentPiece.type !== 'normal') {
                this.handleSpecialPiece(this.currentPiece);
            } else {
                for (let y = 0; y < this.currentPiece.shape.length; y++) {
                    for (let x = 0; x < this.currentPiece.shape[y].length; x++) {
                        if (this.currentPiece.shape[y][x]) {
                            const boardX = this.currentPiece.x + x;
                            const boardY = this.currentPiece.y + y;
                            if (boardY >= 0) {
                                this.board[boardY][boardX] = {
                                    color: this.currentPiece.color,
                                    glow: this.currentPiece.glow
                                };
                            }
                        }
                    }
                }
            }
            this.canHold = true;
            const linesCleared = this.clearLines();
            if (linesCleared > 0) {
                this.combo++;
                this.maxCombo = Math.max(this.maxCombo, this.combo);
            } else {
                this.combo = 0;
            }
            this.currentPiece = this.nextPiece;
            this.nextPiece = Math.random() < 0.1 ? this.createSpecialPiece() : this.createPiece();
            if (this.isCollision(this.currentPiece, 0, 0)) {
                this.gameOver = true;

                let result = await saveScore('tetris', play_id, this.score);

                if (result) {
                    $('#modal-game-form #game-score').text(this.score);
                    {{-- $('#modal-game-form #play-id').text(play_id); --}}
                    $('#modal-game-form #game-play-id').val(play_id);
                    $('#modal-game-form #game-type').val('tetris');
                    $('#modal-game-form').modal('show');
                } else {
                    setGameModal('end', this.score);
                }

            }
            this.updateUI();
        }
        clearLines() {
            let linesCleared = 0;
            for (let y = this.rows - 1; y >= 0; y--) {
                if (this.board[y].every(cell => cell !== 0)) {
                    this.board.splice(y, 1);
                    this.board.unshift(Array(this.cols).fill(0));
                    linesCleared++;
                    y++;
                }
            }
            if (linesCleared > 0) {
                const baseScore = linesCleared * 100 * this.level;
                const comboBonus = this.combo > 1 ? this.combo * 50 : 0;
                this.score += baseScore + comboBonus;
                this.explosionMeter += linesCleared;
                if (this.explosionMeter >= 5) {
                    this.triggerMegaExplosion();
                }
                this.lines += linesCleared;
                this.level = Math.floor(this.lines / 10) + 1;
                this.dropInterval = Math.max(50, 1000 - (this.level - 1) * 100);
                for (let i = 0; i < linesCleared; i++) {
                    for (let j = 0; j < this.cols; j++) {
                        const x = j * this.blockSize + this.blockSize / 2;
                        const y = (this.rows - 1 - i) * this.blockSize + this.blockSize / 2;
                        this.particles.push(new Particle(x, y, '#ffffff'));
                    }
                }
                this.triggerClearEffects(linesCleared);
            }
            return linesCleared;
        }
        isCollision(piece, offsetX = 0, offsetY = 0) {
            return piece.shape.some((row, y) => {
                return row.some((value, x) => {
                    if (!value) return false;
                    const newX = piece.x + x + offsetX;
                    const newY = piece.y + y + offsetY;
                    return (
                        newX < 0 ||
                        newX >= this.cols ||
                        newY >= this.rows ||
                        (newY >= 0 && this.board[newY][newX])
                    );
                });
            });
        }
        hardDrop() {
            const ghost = this.getGhostPosition();
            this.currentPiece.y = ghost.y;
            this.placePiece();
        }
        triggerClearEffects(linesCleared) {
            const gameBoard = document.querySelector('.game-board');
            const gameContainer = document.querySelector('.game-container');
            gameContainer.classList.add('screen-shake');
            setTimeout(() => {
                gameContainer.classList.remove('screen-shake');
            }, 500);
            gameBoard.classList.add('border-glow');
            setTimeout(() => {
                gameBoard.classList.remove('border-glow');
            }, 800);
            for (let i = 0; i < linesCleared * 5; i++) {
                const x = Math.random() * this.canvas.width;
                const y = Math.random() * this.canvas.height;
                const colors = ['#ffd700', '#ff6b6b', '#00ff88', '#00f5ff', '#a000f0'];
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                this.particles.push(new Particle(x, y, randomColor));
            }
        }
        rotatePiece() {
            const rotated = this.currentPiece.shape[0].map((_, i) =>
                this.currentPiece.shape.map(row => row[i]).reverse()
            );
            const originalShape = this.currentPiece.shape;
            this.currentPiece.shape = rotated;
            if (!this.isValidMove(this.currentPiece)) {
                this.currentPiece.shape = originalShape;
            }
        }
        updateParticles() {
            this.particles = this.particles.filter(particle => {
                particle.update();
                return particle.life > 0;
            });
        }
        drawParticles() {
            this.particles.forEach(particle => particle.draw(this.ctx));
        }
        updateUI() {
            document.getElementById('score').textContent = this.score;
            document.getElementById('lines').textContent = this.lines;
            document.getElementById('combo').textContent = this.combo;
            document.getElementById('maxCombo').textContent = this.maxCombo;
            document.getElementById('explosionMeter').textContent = this.explosionMeter;
            document.getElementById('explosionMeterFill').style.width = (this.explosionMeter / 5 * 100) + '%';
        }
        {{--
        bindEvents() {
            // Keyboard Events
            document.addEventListener('keydown', (e) => {
                if (this.gameOver || this.paused) return;
                const key = e.code;
                if (key === 'ArrowLeft' || key === 'KeyA') {
                    if (!this.isCollision(this.currentPiece, -1, 0)) this.currentPiece.x--;
                } else if (key === 'ArrowRight' || key === 'KeyD') {
                    if (!this.isCollision(this.currentPiece, 1, 0)) this.currentPiece.x++;
                } else if (key === 'ArrowDown' || key === 'KeyS') {
                    if (!this.isCollision(this.currentPiece, 0, 1)) {
                        this.currentPiece.y++;
                        this.score += 1;
                    }
                } else if (key === 'ArrowUp' || key === 'KeyW') {
                    this.rotatePiece();
                } else if (key === 'Space') {
                    this.hardDrop();
                } else if (key === 'KeyC') {
                    this.holdCurrentPiece();
                } else if (key === 'KeyP') {
                    this.paused = !this.paused;
                }
                this.updateUI();
                e.preventDefault();
            });

            // Mobile Control Events
            document.getElementById('btn-left').addEventListener('click', () => {
                if (this.gameOver || this.paused) return;
                if (!this.isCollision(this.currentPiece, -1, 0)) this.currentPiece.x--;
            });
            document.getElementById('btn-right').addEventListener('click', () => {
                if (this.gameOver || this.paused) return;
                if (!this.isCollision(this.currentPiece, 1, 0)) this.currentPiece.x++;
            });
            document.getElementById('btn-down').addEventListener('click', () => {
                if (this.gameOver || this.paused) return;
                if (!this.isCollision(this.currentPiece, 0, 1)) {
                    this.currentPiece.y++;
                    this.score += 1;
                }
            });
            document.getElementById('btn-up').addEventListener('click', () => {
                if (this.gameOver || this.paused) return;
                this.rotatePiece();
            });
            document.getElementById('btn-drop').addEventListener('click', () => {
                if (this.gameOver || this.paused) return;
                this.hardDrop();
            });
            document.getElementById('btn-hold').addEventListener('click', () => {
                if (this.gameOver || this.paused) return;
                this.holdCurrentPiece();
            });
        }
        --}}
        bindEvents() {
            // Keyboard Events
            document.addEventListener('keydown', (e) => {
                // STEP 1: Handle the pause key toggle FIRST. This must be outside the main guard clause.
                if (e.key.toLowerCase() === 'p') {
                    this.paused = !this.paused;
                    e.preventDefault(); // Prevent default browser action for the 'p' key
                    return; // Exit after toggling pause
                }

                // STEP 2: Now, if the game is paused or over, ignore ALL OTHER keys.
                if (this.gameOver || this.paused) {
                    return;
                }

                // STEP 3: If we get here, the game is running and the key was not 'p'. Process game controls.
                if (e.code === 'ArrowLeft' || e.code === 'KeyA') {
                    if (!this.isCollision(this.currentPiece, -1, 0)) this.currentPiece.x--;
                } else if (e.code === 'ArrowRight' || e.code === 'KeyD') {
                    if (!this.isCollision(this.currentPiece, 1, 0)) this.currentPiece.x++;
                } else if (e.code === 'ArrowDown' || e.code === 'KeyS') {
                    if (!this.isCollision(this.currentPiece, 0, 1)) {
                        this.currentPiece.y++;
                        this.score += 1;
                    }
                } else if (e.code === 'ArrowUp' || e.code === 'KeyW') {
                    this.rotatePiece();
                } else if (e.code === 'Space') {
                    this.hardDrop();
                } else if (e.code === 'KeyC') {
                    this.holdCurrentPiece();
                }
                
                this.updateUI();
                e.preventDefault();
            });

            // Mobile Control Events (no changes needed here)
            document.getElementById('btn-left').addEventListener('click', () => {
                if (this.gameOver || this.paused) return;
                if (!this.isCollision(this.currentPiece, -1, 0)) this.currentPiece.x--;
            });
            document.getElementById('btn-right').addEventListener('click', () => {
                if (this.gameOver || this.paused) return;
                if (!this.isCollision(this.currentPiece, 1, 0)) this.currentPiece.x++;
            });
            document.getElementById('btn-down').addEventListener('click', () => {
                if (this.gameOver || this.paused) return;
                if (!this.isCollision(this.currentPiece, 0, 1)) {
                    this.currentPiece.y++;
                    this.score += 1;
                }
            });
            document.getElementById('btn-up').addEventListener('click', () => {
                if (this.gameOver || this.paused) return;
                this.rotatePiece();
            });
            document.getElementById('btn-drop').addEventListener('click', () => {
                if (this.gameOver || this.paused) return;
                this.hardDrop();
            });
            document.getElementById('btn-hold').addEventListener('click', () => {
                if (this.gameOver || this.paused) return;
                this.holdCurrentPiece();
            });
        }
        gameLoop(currentTime = 0) {
            const deltaTime = currentTime - this.lastTime;
            this.lastTime = currentTime;
            if (!this.gameOver && !this.paused) {
                this.dropTime += deltaTime;
                if (this.dropTime > this.dropInterval) {
                    if (this.isValidMove(this.currentPiece, 0, 1)) {
                        this.currentPiece.y++;
                    } else {
                        this.placePiece();
                    }
                    this.dropTime = 0;
                }
            }
            this.updateParticles();
            this.drawBoard();
            this.drawGhost();
            this.drawPiece(this.currentPiece);
            this.drawParticles();
            this.drawNextPiece();
            this.drawHoldPiece();
            requestAnimationFrame((time) => this.gameLoop(time));
        }
        getGhostPosition() {
            const ghost = {
                shape: this.currentPiece.shape,
                x: this.currentPiece.x,
                y: this.currentPiece.y
            };
            while (this.isValidMove(ghost, 0, 1)) {
                ghost.y++;
            }
            return ghost;
        }
        drawGhost() {
            const ghost = this.getGhostPosition();
            this.ctx.save();
            this.ctx.globalAlpha = 0.3;
            ghost.shape.forEach((row, y) => {
                row.forEach((value, x) => {
                    if (value) {
                        const pixelX = (ghost.x + x) * this.blockSize;
                        const pixelY = (ghost.y + y) * this.blockSize;
                        this.ctx.strokeStyle = this.currentPiece.color;
                        this.ctx.lineWidth = 2;
                        this.ctx.strokeRect(pixelX + 2, pixelY + 2, this.blockSize - 4, this.blockSize - 4);
                        this.ctx.fillStyle = this.currentPiece.color;
                        this.ctx.globalAlpha = 0.1;
                        this.ctx.fillRect(pixelX + 2, pixelY + 2, this.blockSize - 4, this.blockSize - 4);
                    }
                });
            });
            this.ctx.restore();
        }
        triggerMegaExplosion() {
            this.score += 10000;
            this.explosionMeter = 0;
            this.dropInterval = Math.max(50, this.dropInterval - 100);
            const indicator = document.getElementById('explosionModeIndicator');
            indicator.style.display = 'block';
            setTimeout(() => {
                indicator.style.display = 'none';
            }, 3000);
            for (let i = 0; i < 100; i++) {
                const x = Math.random() * this.canvas.width;
                const y = Math.random() * this.canvas.height;
                const colors = ['#ff6b35', '#f7931e', '#ffd700', '#ff4500', '#ff6347'];
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                this.particles.push(new Particle(x, y, randomColor));
            }
            for (let y = 0; y < this.rows; y++) {
                for (let x = 0; x < this.cols; x++) {
                    if (this.board[y][x]) {
                        const pixelX = x * this.blockSize + this.blockSize / 2;
                        const pixelY = y * this.blockSize + this.blockSize / 2;
                        const colors = ['#ff6b35', '#f7931e', '#ffd700', '#ff4500', '#ff6347'];
                        const randomColor = colors[Math.floor(Math.random() * colors.length)];
                        this.particles.push(new Particle(pixelX, pixelY, randomColor));
                        this.board[y][x] = 0;
                    }
                }
            }
            const gameContainer = document.querySelector('.game-container');
            gameContainer.classList.add('screen-shake');
            setTimeout(() => {
                gameContainer.classList.remove('screen-shake');
            }, 1000);
            const gameBoard = document.querySelector('.game-board');
            gameBoard.classList.add('border-glow');
            setTimeout(() => {
                gameBoard.classList.remove('border-glow');
            }, 1500);
        }
    }

    function restartGame() {
        if (gameInstance) {
            gameInstance.reset();
        }
        $('#modal-tetris-1').modal('hide');
    }
</script>