// Canvas Pong

//Getting Mouse Position 
function getMousePos(canvas, event) {
    var rect = canvas.getBoundingClientRect();
    return {
        x: event.clientX - rect.left,
        y: event.clientY - rect.top
    };
}

//Checks is Pointer is inside the Button Region
function isInside(pos, rect){
    return pos.x > rect.x && pos.x < rect.x+rect.w && pos.y < rect.y+rect.h && pos.y > rect.y
}

//the4 7-10-22

var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
let Pig_Button = {
  x:700,
  y:711,
  w:100,
  h:14,
}

let Horse_Button = {
  x:700,
  y:652,
  w:100,
  h:14,
}


// Key Codes
// var W = 87;
// var S = 83;
// var UP = 38;
// var DOWN = 40;

// Keep track of pressed keys
var keys = {
  W: false,
  S: false,
  UP: false,
  DOWN: false
};

// Create a rectangle object - for paddles, ball, etc
function makeRect(x, y, width, height, speed, color) {
  if (!color) color = '#000000';
  return {
    x: x,
    y: y,
    w: width,
    h: height,
    s: speed,
    c: color,
    draw: function() {
      context.fillStyle = this.c;
      context.fillRect(this.x, this.y, this.w, this.h);
    }
  };
}

// Create the paddles
var paddleWidth = 25;
var paddleHeight = 100;
var leftPaddle = makeRect(25, canvas.height / 2 - paddleHeight / 2, paddleWidth, paddleHeight, 5, '#BC0000');
var rightPaddle = makeRect(canvas.width - paddleWidth - 25, canvas.height / 2 - paddleHeight / 2, paddleWidth, paddleHeight, 5, '#0000BC');

// Keep track of the score
var leftScore = 0;
var rightScore = 0;

// Create the ball
var ballLength = 15;
var ballSpeed = 2;
var ball = makeRect(0, 0, ballLength, ballLength, ballSpeed, '#000000');

// Modify the ball object to have two speed properties, one for X and one for Y
ball.sX = ballSpeed;
ball.sY = ballSpeed / 2;

//Gamemode 
let gamemode = 0;

// Randomize initial direction
if (Math.random() > 0.5) {
  ball.sX *= -1;
}
// Randomize initial direction
if (Math.random() > 0.5) {
  ball.sY *= -1;
}

// Reset the ball's position and speed after scoring
function resetBall() {
  ball.x = canvas.width / 2 - ball.w / 2;
  ball.y = canvas.height / 2 - ball.w / 2;
  ball.sX = ballSpeed;
  ball.sY = ballSpeed / 2;

  paddleWidth_Resize();
}

// Bounce the ball off of a paddle
function bounceBall() {
	// Increase and reverse the X speed
	if (ball.sX > 0) {
  	ball.sX += 1;
    // Add some "spin"
    if (keys.UP) {
      ball.sY -= 1;
    } else if (keys.DOWN) {
      ball.sY += 1;
    }
  } else {
  	ball.sX -= 1;
    // Add some "spin"
    if (keys.W) {
      ball.sY -= 1;
    } else if (keys.S) {
      ball.sY += 1
    }
  }
  ball.sX *= -1;
  
  paddleWidth_Resize();
}

// Listen for keydown events
document.addEventListener('keydown', function(event) {
  if(event.key === 'W' || event.key === 'w') {
    keys.W = true;
  }
  if(event.key == 'S' || event.key == 's') {
    keys.S = true;
  }
  if(event.key === 'ArrowUp'){
    keys.UP = true;
  }
  if(event.key === 'ArrowDown'){
    keys.DOWN = true;
  }
});

// canvas.addEventListener('keydown', function(e) {
//   if (e.keyCode === W) {
//     keys.W = true;
//   }
//   if (e.keyCode === S) {
//     keys.S = true;
//   }
//   if (e.keyCode === UP) {
//     keys.UP = true;
//   }
//   if (e.keyCode === DOWN) {
//     keys.DOWN = true;
//   }
// });

// Listen for keyup events

document.addEventListener('keyup', function(event) {
  if(event.key === 'W' || event.key === 'w') {
    keys.W = false;
  }
  if(event.key === 'S' || event.key === 's') {
    keys.S = false;
  }
  if(event.key === 'ArrowUp'){
    keys.UP = false;
  }
  if(event.key === 'ArrowDown'){
    keys.DOWN = false;
  }
});
function GameModes_Button(event){
  let gamemode_selected = false;
  let mousePos = getMousePos(canvas, event);

    if(isInside(mousePos, Horse_Button)){
      gamemode = 1;
      gamemode_selected = true;
      document.getElementById('ballspeed').innerHTML = `Gamemode 1: Horse`;
    }
    if(isInside(mousePos, Pig_Button)){
      gamemode = 2;
      gamemode_selected = true;
      document.getElementById('ballspeed').innerHTML = `Gamemode 2: Pig`;
    }

    if (gamemode_selected){
      //Remove Buttons
      context.clearRect(Pig_Button.x, Pig_Button.y, Pig_Button.w, Pig_Button.h);
      context.clearRect(Horse_Button.x, Horse_Button.y, Horse_Button.w, Horse_Button.h);
      //Start the game
      startGame();
    }
    else {
      context.fillStyle = 'red';
      context.textAlign = 'center';
      context.fillText('Select Game Mode', canvas.width / 2, canvas.height / 2);
    }
}
// canvas.addEventListener('keyup', function(e) {
//   if (e.keyCode === W) {
//     keys.W = false;
//   }
//   if (e.keyCode === S) {
//     keys.S = false;
//   }
//   if (e.keyCode === UP) {
//     keys.UP = false;
//   }
//   if (e.keyCode === DOWN) {
//     keys.DOWN = false;
//   }
// });

// Show the menu
function menu() {
  erase();

  context.rect(Pig_Button.x, Pig_Button.y, Pig_Button.w, Pig_Button.h);
  context.rect(Horse_Button.x, Horse_Button.y, Horse_Button.w, Horse_Button.h);
  context.fill();

  // Show the menu
  context.fillStyle = '#000000';
  context.font = '24px Arial';
  context.textAlign = 'center';
  context.fillText('PONG', canvas.width / 2, canvas.height / 4);
  context.font = '18px Arial';
  context.fillText('Click to Start', canvas.width / 2, canvas.height / 3);
  context.font = '14px Arial';
  context.textAlign = 'left';
  context.fillText('Player 1: W (up) and S (down)', 5, (canvas.height / 3) * 2);
  context.textAlign = 'right';
  context.fillText('Player 2: UP (up) and DOWN (down)', canvas.width - 5, (canvas.height / 3) * 2);
  // GameModes 
  context.font = '14px Arial';
  context.textAlign = 'left';
  context.fillText('Game Modes:', 5, (canvas.height / 3) * 2.5);
  context.textAlign = 'right';
  context.fillText('1: Horse', canvas.width - 2, (canvas.height / 3) * 2.5);
  context.fillText('2: Pig', canvas.width - 2, (canvas.height / 3) * 2.7);

  // Start the game on a click
  canvas.addEventListener('click', GameModes_Button);
}

// Start the game
function startGame() {
	// Don't accept any more clicks
  canvas.removeEventListener('click', GameModes_Button);
  // Put the ball in place
  resetBall();
  // Kick off the game loop
  draw();
  
}

// Show the end game screen
function endGame() {
	erase();
  context.fillStyle = '#000000';
  context.font = '24px Arial';
  context.textAlign = 'center';
  var winner = 1;
  if (gamemode == 1) {
    if (rightScore === 5) winner = 2;
  }
  else if (gamemode == 2) {
    if (rightScore === 3) winner = 2;
  }
  context.fillText('Player ' + winner + ' wins!', canvas.width/2, canvas.height/2);
  // Reset to Menu
  canvas.addEventListener('click', () =>{
    leftScore = 0;
    rightScore = 0;
    ballSpeed = 2;
    menu();
  });
  
  context.fillText('Click to return to menu', canvas.width/2, canvas.height/2 + 30);
}

// Clear the canvas
function erase() {
  context.fillStyle = '#FFFFFF';
  context.fillRect(0, 0, canvas.width, canvas.height);
}

// Main draw loop
function draw() {
  erase();
  // Move the paddles
  if (keys.W) {
    leftPaddle.y -= leftPaddle.s;
  }
  if (keys.S) {
    leftPaddle.y += leftPaddle.s;
  }
  if (keys.UP) {
    rightPaddle.y -= rightPaddle.s;
  }
  if (keys.DOWN) {
    rightPaddle.y += rightPaddle.s;
  }
  // Move the ball
  ball.x += ball.sX;
  ball.y += ball.sY;
  // Bounce the ball off the top/bottom
  if (ball.y < 0 || ball.y + ball.h > canvas.height) {
    ball.sY *= -1;
  }
  // Don't let the paddles go off screen
  [leftPaddle, rightPaddle].forEach(function(paddle) {
    if (paddle.y < 0) {
      paddle.y = 0;
    } 
    if (paddle.y + paddle.h > canvas.height) {
      paddle.y = canvas.height - paddle.h;
    }
  });
  // Bounce the ball off the paddles
  if (ball.y + ball.h/2 >= leftPaddle.y && ball.y + ball.h/2 <= leftPaddle.y + leftPaddle.h) {
    if (ball.x <= leftPaddle.x + leftPaddle.w) {
      bounceBall();
    }
  } 
  if (ball.y + ball.h/2 >= rightPaddle.y && ball.y + ball.h/2 <= rightPaddle.y + rightPaddle.h) {
    if (ball.x + ball.w >= rightPaddle.x) {
      bounceBall();
    }
  }
  // Score if the ball goes past a paddle
  if (ball.x < leftPaddle.x) {
    rightScore++;
    resetBall();
    ball.sX *= -1;
  } else if (ball.x + ball.w > rightPaddle.x + rightPaddle.w) {
    leftScore++;
    resetBall();
    ball.sX *= -1;
  }
  // Draw the paddles and ball
  leftPaddle.draw();
  rightPaddle.draw();
  ball.draw();
  // Draw the scores
  context.fillStyle = '#000000';
  context.font = '24px Arial';
  context.textAlign = 'left';
  //the4 7-10-22
  if(gamemode === 1){ 
    switch (rightScore) {
      case 0:
        context.fillText('_ _ _ _ _', 5 , 24);
        break;
      case 1:
        context.fillText('H _ _ _ _', 5 , 24);
        break;
      case 2:
        context.fillText('H O _ _ _', 5 , 24);
        break;
      case 3:
        context.fillText('H O R _ _', 5 , 24);
        break;
      case 4:
        context.fillText('H O R S _', 5 , 24);
        break;
      case 5:
        context.fillText('H O R S E', 5 , 24);
        break;
    }
    context.textAlign = 'right';
    switch (leftScore) {
      case 0:
        context.fillText('_ _ _ _ _', canvas.width - 5 , 24);
        break;
      case 1:
        context.fillText('H _ _ _ _', canvas.width - 5 , 24);
        break;
      case 2:
        context.fillText('H O _ _ _', canvas.width - 5 , 24);
        break;
      case 3:
        context.fillText('H O R _ _', canvas.width - 5 , 24);
        break;
      case 4:
        context.fillText('H O R S _', canvas.width - 5 , 24);
        break;
      case 5:
        context.fillText('H O R S E', canvas.width - 5 , 24);
        break;
    }
    // context.fillText('Score: ' + leftScore, 5, 24);
    // context.textAlign = 'right';
    // context.fillText('Score: ' + rightScore, canvas.width - 5, 24);
    // End the game or keep going
    if (leftScore === 5 || rightScore === 5) {
      endGame();
    } else {
      window.requestAnimationFrame(draw);
    }
  }

    if(gamemode === 2){
      switch (rightScore) {
        case 0:
          context.fillText('_ _ _', 5 , 24);
          break;
        case 1:
          context.fillText('P _ _', 5 , 24);
          break;
        case 2:
          context.fillText('P I _', 5 , 24);
          break;
        case 3:
          context.fillText('P I G', 5 , 24);
          break;
      }
      context.textAlign = 'right';
      switch (leftScore) {
        case 0:
          context.fillText('_ _ _', canvas.width - 5 , 24);
          break;
        case 1:
          context.fillText('P _ _', canvas.width - 5 , 24);
          break;
        case 2:
          context.fillText('P I _', canvas.width - 5 , 24);
          break;
        case 3:
          context.fillText('P I G', canvas.width - 5 , 24);
          break;
      }
      // End the game or keep going
      if (leftScore === 3 || rightScore === 3) {
        endGame();
      }
      else {
        window.requestAnimationFrame(draw);
      }
  }
  }

// Reduce the size of the paddels when ball Speed > 3  
//the4 7-10-22
const paddleWidth_Resize = () => {
  if(Math.abs(ball.sX) >= 4){
    // leftPaddle.w = leftPaddle.w - 1;
    leftPaddle.h = leftPaddle.h - 7.5;
    // rightPaddle.w = rightPaddle.w - 1;
    rightPaddle.h = rightPaddle.h - 7.5;
  }
  // Reset the paddles to their original size
  if(Math.abs(ball.sX )< 4){
    // leftPaddle.w = canvas.width / 20;
    leftPaddle.h = 100;
    // rightPaddle.w = canvas.width / 20;
    rightPaddle.h = 100;
  }
} 

  menu();
  canvas.focus();