<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameBoxx</title>
    <?php include './components/head_link.php' ?>
</head>

<body class="bg-img-dashboard">
    <?php include './components/nav.php' ?>
    <div style="padding:5% 4% 3% 4%;">
        <div class="bg-white border rounded" style="margin-top: 5%; padding-bottom:4%;">
            <div class="text-center pt-5 pb-4">
                <h1>GameBoxx</h1>
                <hr />
            </div>
            <div class="container">
                <div class="pb-1">
                    <h6>Available games.</h6>
                </div>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    <div class="col">
                        <div class="card">
                            <img src="./img/jump-game.PNG" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Jumping Bug</h5>
                                <p>An exciting platformer where players control a jumping bug, navigating obstacles and collecting rewards while avoiding dangerous traps.</p>
                            </div>
                            <div class="card-footer m-0 p-0">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-dark btn-block" onclick="bugJumpAction()" style="border-radius: 0px;">Let's Play<i class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="./img/maths-puzzel.webp" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Banana Game</h5>
                                <p>A fun math puzzle game that challenges players to solve equations and reach the ultimate goal in a playful setting.</p>
                            </div>
                            <div class="card-footer m-0 p-0">
                                <div class="d-grid gap-2 ">
                                    <button class="btn btn-dark btn-block" onclick="bananaGameAction()" style="border-radius: 0px;">Let's Play<i class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function bananaGameAction() {
            window.location.href = 'bananagame.php';
        }

        function bugJumpAction() {
            window.location.href = 'bugjump.php';
        }
    </script>
</body>

</html>