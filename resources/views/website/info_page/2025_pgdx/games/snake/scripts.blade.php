<script>
    const container = $('#game-container');
    const gridSize = 20;
    let snake, food, dx, dy, interval;
    let snakeColor = 'rgb(74,175,80)';
    let score = 0;
    let speed = 150;
    let directionQueue = [];
    let play_id = '';
    let scoreSubmitted = false;

    function getRotationAngle(dx, dy) {
      if (dx === 1) return 90;
      if (dx === -1) return -90;
      if (dy === 1) return 180;
      return 0;
    }

    function updateScore() {
      $('#score-display').text('Score: ' + score);
      $('#live-score').text('Score: ' + score);
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

    async function move() {
      // Process one direction from the queue per tick
      if (directionQueue.length) {
        const nextDir = directionQueue.shift();
        dx = nextDir.dx;
        dy = nextDir.dy;
      }

      const head = { x: snake[0].x + dx, y: snake[0].y + dy };

      if (
        head.x < 1 || head.x > gridSize ||
        head.y < 1 || head.y > gridSize ||
        snake.some(part => part.x === head.x && part.y === head.y)
      ) {

        if(!scoreSubmitted){

            scoreSubmitted = true;

            
        
            clearInterval(interval);
            $('#status-text').text('Game Over!');
            $('#start-btn').text('Play Again');
            $('#overlay').fadeIn();

            $result = await saveScore('snake', play_id, score);

            if($result) {
                $('#modal-game-form #game-score').text(score);
                {{-- $('#modal-game-form #play-id').text(play_id); --}}
                $('#modal-game-form #game-play-id').val(play_id);
                $('#modal-game-form #game-type').val('snake');
                $('#modal-game-form').modal('show');
            }
            
        }

        return;
        
        
      }

      snake.unshift(head);

      if (head.x === food.x && head.y === food.y) {
        score++;
        updateScore();

        // Increase speed
        speed = Math.max(50, speed - 5);
        clearInterval(interval);
        interval = setInterval(move, speed);

        food = generateFood();
        // food = {
        //   x: Math.floor(Math.random() * gridSize) + 1,
        //   y: Math.floor(Math.random() * gridSize) + 1,
        // };
      } else {
        snake.pop();
      }

      draw();
    }

    function generateFood() {
        let newFood;
        do {
            newFood = {
            x: Math.floor(Math.random() * gridSize) + 1,
            y: Math.floor(Math.random() * gridSize) + 1,
            };
        } while (snake.some(part => part.x === newFood.x && part.y === newFood.y));
        return newFood;
    }

    function initSnakeGame() {
      snake = [{ x: 10, y: 10 }];
      food = { x: 15, y: 15 };
      dx = 1;
      dy = 0;
      directionQueue = [];
      score = 0;
      speed = 150;
      scoreSubmitted = false;
      updateScore();
      draw();
    }

    async function startGame() {
    //   snakeColor = $('#color-picker').val();
    
        play_id = await generateID('snake');

        initSnakeGame();
        $('#overlay').hide();
        clearInterval(interval);
        interval = setInterval(move, speed);
    }

    function queueDirection(newDx, newDy) {
      const lastDir = directionQueue.length ? directionQueue[directionQueue.length - 1] : { dx, dy };
      if ((newDx !== -lastDir.dx || newDy !== -lastDir.dy) && (newDx !== lastDir.dx || newDy !== lastDir.dy)) {
        directionQueue.push({ dx: newDx, dy: newDy });
      }
    }

    $(document).on('keydown', function (e) {
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

    $('#start-btn').on('click', startGame);
    $('#close-btn, #close-snake').on('click', function(e){
        e.preventDefault();
        // $('#modal-game-snake').modal('hide');
        window.location.href = "{{ route('play.leaderboard') }}";
    });
    // $('#color-picker').on('change', e => snakeColor = e.target.value);

    $('#up').on('click', () => queueDirection(0, -1));
    $('#down').on('click', () => queueDirection(0, 1));
    $('#left').on('click', () => queueDirection(-1, 0));
    $('#right').on('click', () => queueDirection(1, 0));
  </script>