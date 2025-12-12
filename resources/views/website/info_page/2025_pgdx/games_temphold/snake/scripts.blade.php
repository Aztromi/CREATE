<script>
(function() { // Start of IIFE for Snake Game
    const container = $('#snake-game-container');
    const gridSize = 20;
    let snake, food, dx, dy, interval;
    let snakeColor = 'rgb(74,175,80)';
    let score = 0;
    let speed = 150;
    let directionQueue = [];
    let isSnakeGameActive = false; // New flag to control keydown listener

    function getRotationAngle(dx, dy) {
      if (dx === 1) return 90;
      if (dx === -1) return -90;
      if (dy === 1) return 180;
      return 0;
    }

    function updateScore() {
      $('#snake-score-display').text('Score: ' + score);
      $('#snake-live-score').text('Score: ' + score);
    }

    function draw() {
      container.empty();
      snake.forEach((part, index) => {
        const segment = $('<div class="snake"></div>')
          .css('grid-column-start', part.x)
          .css('grid-row-start', part.y)
          .css('background-color', snakeColor);

        if (index === 0) {
          segment.addClass('head');
          const headContent = $('<div class="head-content"></div>');
          const eyes = $('<div class="eyes"><div class="eye"></div><div class="eye"></div></div>');
          const tongue = $('<div class="tongue"></div>');

          const angle = getRotationAngle(dx, dy);
          eyes.css('transform', `rotate(${angle}deg)`);

          if (dx === 1) tongue.css({ top: '50%', left: '100%', transform: 'translateY(-50%) rotate(90deg)' });
          else if (dx === -1) tongue.css({ top: '50%', left: '-10%', transform: 'translateY(-50%) rotate(-90deg)' });
          else if (dy === 1) tongue.css({ top: '100%', left: '50%', transform: 'translateX(-50%) rotate(180deg)' });
          else tongue.css({ top: '-10%', left: '50%', transform: 'translateX(-50%) rotate(0deg)' });

          headContent.append(eyes, tongue);
          segment.append(headContent);
        }

        container.append(segment);
      });

      $('<div class="food"></div>')
        .css('grid-column-start', food.x)
        .css('grid-row-start', food.y)
        .appendTo(container);
    }

    function generateFood() {
      food = {
        x: Math.floor(Math.random() * gridSize) + 1,
        y: Math.floor(Math.random() * gridSize) + 1
      };
    }

    function initGame() {
      snake = [{ x: 10, y: 10 }];
      dx = 1; // Start moving right
      dy = 0;
      score = 0;
      speed = 150;
      directionQueue = [];
      generateFood();
      updateScore();
      draw();
    }

    function move() {
      if (directionQueue.length) {
        const nextDir = directionQueue.shift();
        dx = nextDir.dx;
        dy = nextDir.dy;
      }
      const head = { x: snake[0].x + dx, y: snake[0].y + dy };

      // Check for collisions with walls or self
      if (
        head.x < 1 || head.x > gridSize ||
        head.y < 1 || head.y > gridSize ||
        snake.some(part => part.x === head.x && part.y === head.y)
      ) {
        gameOver();
        return;
      }

      snake.unshift(head); // Add new head

      if (head.x === food.x && head.y === food.y) {
        score += 10;
        speed = Math.max(50, speed - 5); // Increase speed, min 50ms
        updateScore();
        generateFood();
        clearInterval(interval);
        interval = setInterval(move, speed);
      } else {
        snake.pop(); // Remove tail if no food eaten
      }

      draw();
    }

    function gameOver() {
      clearInterval(interval);
      $('#snake-overlay').show();
      $('#snake-status-text').text('Game Over!');
      $('#snake-start-btn').text('Play Again');
      isSnakeGameActive = false; // Deactivate key listener
    }

    function startGame() {
      initGame();
      $('#snake-overlay').hide();
      clearInterval(interval);
      interval = setInterval(move, speed);
      isSnakeGameActive = true; // Activate key listener
    }

    function queueDirection(newDx, newDy) {
      const lastDir = directionQueue.length ? directionQueue[directionQueue.length - 1] : { dx, dy };
      if ((newDx !== -lastDir.dx || newDy !== -lastDir.dy) && (newDx !== lastDir.dx || newDy !== lastDir.dy)) {
        directionQueue.push({ dx: newDx, dy: newDy });
      }
    }

    // Attach keydown listener to the modal when it's shown, and remove when hidden
    $('#modal-game-snake').on('shown.bs.modal', function () {
        $(document).on('keydown.snakeGame', function (e) { // Use namespaced event
            if (!isSnakeGameActive) return; // Only respond if game is active
            const key = e.key;
            if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'].includes(key)) {
                e.preventDefault();
                switch (key) {
                    case 'ArrowUp': queueDirection(0, -1); break;
                    case 'ArrowDown': queueDirection(0, 1); break;
                    case 'ArrowLeft': queueDirection(-1, 0); break;
                    case 'ArrowRight': queueDirection(1, 0); break;
                }
            }
        });
    });

    $('#modal-game-snake').on('hidden.bs.modal', function () {
        $(document).off('keydown.snakeGame'); // Remove namespaced event
        clearInterval(interval); // Stop the game interval when modal is closed
        isSnakeGameActive = false;
        // Optionally reset game state or show initial overlay state
        $('#snake-overlay').show();
        $('#snake-status-text').text('Snake Game');
        $('#snake-score-display').text('Score: 0');
        $('#snake-start-btn').text('Play');
    });

    // Control buttons for mobile/on-screen
    $('#snake-up').on('click', () => queueDirection(0, -1));
    $('#snake-down').on('click', () => queueDirection(0, 1));
    $('#snake-left').on('click', () => queueDirection(-1, 0));
    $('#snake-right').on('click', () => queueDirection(1, 0));
    $('#snake-btn-a').on('click', startGame); // Assuming 'A' button starts the game
    $('#snake-btn-b').on('click', function() { /* Optional: Add 'B' button functionality if needed */ });

    $('#snake-start-btn').on('click', startGame);
    $('#snake-close-btn, #snake-close-game').on('click', function(e){
        e.preventDefault();
        $('#modal-game-snake').modal('hide');
    });
    // $('#snake-color-picker').on('change', e => snakeColor = e.target.value);

    // Initial setup
    initGame();
})(); // End of IIFE for Snake Game
</script>