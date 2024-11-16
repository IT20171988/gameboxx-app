<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameBoxx</title>
    <?php include './components/head_link.php' ?>
    <link rel="stylesheet" href="./css/game.css" />
</head>

<body class="bg-img-dashboard">
    <?php include './components/nav.php' ?>
    <div class="container" style="padding-top:5%;">
        <canvas id="canvas">
            Aww, your browser doesn't support HTML5!
        </canvas>

        <div id="mainMenu">

            <p class="info">
                use
                <span class="key left">←</span>
                <span class="key right">→</span>
                to move and space to (re) start...
            </p>
            <a class="button" href="javascript:init()">Play</a>
        </div>

        <div id="gameOverMenu">
            <h1>Game Over!</h1>
            <h3 id="go_score" class="mt-2 text-center" style="font-size: 20px;">You Scored 0 Points</h3>
            <a class="button" href="javascript:reset()">Restart</a>
        </div>

        <img id="sprite" src="https://i.imgur.com/2WEhF.png" />

        <div id="scoreBoard">
            <p id="score">Your Score : 0</p>
        </div>

    </div>
    <?php include './components/bottom_link.php' ?>
    <script src="./js/game.js"></script>
</body>

</html>