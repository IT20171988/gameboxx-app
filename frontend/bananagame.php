<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameBoxx</title>
    <?php include './components/head_link.php' ?>
</head>

<body class="bg-img-dashboard">
    <?php include './components/nav.php' ?>
    <div class="container-fluid">
       
        <div class="row justify-content-center" style="padding-top: 5%; padding-bottom: 4%;">
            <div class="col-12 col-md-8">
                <div class="card border-0 h-100">
                    <div class="card-head" style="padding: 5% 0% 4% 0%;">
                        <h3 class="text-center text-danger">Let's Play the Game...</h3>
                        <hr style="background-color:#fceabb;" />
                    </div>
                    <div class="card-body">
                        <div class="text-center" id="img-container"></div>
                        <div style="padding: 2% 19% 5% 19%;">
                            <label style="font-weight: 600;">Your Answer ?</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control bg-light" placeholder="" aria-label="answer" aria-describedby="button-answer" id="given_answer" name="given_answer">
                                <button class="btn btn-success" type="button" id="button-answer" onclick="checkAnswer()">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 h-100">
                    <div class="card-head" style="padding: 5% 0% 4% 0%;">
                        <h3 class="text-center text-danger">Score Board</h3>
                    </div>
                    <div class="card-body">
                        <div style="padding: 5% 10% 4% 10%;" class="text-center">
                            <canvas id="resultPieChart"></canvas>
                        </div>
                        <div class="pt-5">
                            <ul>
                                <li><span id="lblTAttemps" class="fw-bold"></span> Total Attemps</li>
                                <li><span id="lblWins" class="fw-bold"></span> Total Wins</li>
                                <li><span id="lblFails" class="fw-bold"></span> Total Fails</li>
                                <li><span id="lblSkips" class="fw-bold"></span> Total Skips</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include './components/bottom_link.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var answer = "";
        var currentScore = "";
        var chartInstance = null;
        var user = localStorage.getItem('user');
        var failsAttemps = 0;

        $(document).ready(function() {
            loadQuestion();
            loadCurrentResult();

        });

        function checkAnswer() {
            var given_answer = document.getElementById("given_answer").value;
            if (given_answer == answer) {
                Swal.fire({
                    icon: 'success',
                    title: 'Correct!',
                    text: 'You have provided the correct answer.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        saveScore("1");
                        loadQuestion();
                    }
                });
            } else {
                failsAttemps = parseInt(failsAttemps) + 1;
                if (failsAttemps == 3) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'The answer is incorrect. Attemps are over',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        failsAttemps = 0;
                        saveScore("3");
                        loadQuestion();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'The answer is incorrect. Left Attemps : ' + (3 - parseInt(failsAttemps)),
                        showCancelButton: true,
                        confirmButtonText: 'Try Again',
                        cancelButtonText: 'Next Question',
                    }).then((result) => {
                        if (!result.isConfirmed) {
                            var img = $('<img>', {
                                src: "./img/emptyimg.webp",
                                alt: 'Question Image',
                                class: 'img-fluid',
                                css: {
                                    'border': '5px solid #fceabb',
                                    'padding': '10px',
                                    'border-radius': '8px'
                                }
                            });
                            $('#img-container').html(img);
                            loadQuestion();
                            saveScore("2");
                        }
                    });
                }
            }
        }

        function loadQuestion() {
            $.ajax({
                url: 'https://marcconrad.com/uob/banana/api.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && response.question) {
                        var img = $('<img>', {
                            src: response.question,
                            alt: 'Question Image',
                            class: 'img-fluid',
                            css: {
                                'border': '5px solid #fceabb',
                                'padding': '10px',
                                'border-radius': '8px'
                            }
                        });
                        $('#img-container').html(img);
                        answer = response.solution;
                        console.log(answer);
                    } else {
                        $('#img-container').html('<p>No image available.</p>');
                    }
                },
                error: function() {
                    $('#img-container').html('<p>Error loading image.</p>');
                }
            });
        }

        function saveScore(status) {
            const data = JSON.parse(user);
            const email = data.email;

            var formData = {};
            if (status == 1) {
                formData = {
                    action: "update_score",
                    user: email,
                    win: (parseInt(currentScore.win) + 1),
                    fail: currentScore.fail,
                    skip: currentScore.skip
                };
            } else if (status == 2) {
                formData = {
                    action: "update_score",
                    user: email,
                    win: currentScore.win,
                    fail: currentScore.fail,
                    skip: (parseInt(currentScore.skip) + 1),
                };
            } else if (status == 3) {
                formData = {
                    action: "update_score",
                    user: email,
                    win: currentScore.win,
                    fail: (parseInt(currentScore.fail) + 1),
                    skip: currentScore.skip
                };
            } else {}
            console.log(formData);

            $.ajax({
                url: '../backend/controller/scorecontroller.php',
                type: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                success: function(response) {
                    loadCurrentResult();
                    document.getElementById("given_answer").value = "";
                },
                error: function(error) {
                    console.error('Error saving score:', error);
                }
            });
        }

        function loadCurrentResult() {
            const data = JSON.parse(user);
            const email = data.email;

            $.ajax({
                url: '../backend/controller/scorecontroller.php',
                type: 'POST',
                data: JSON.stringify({
                    action: "get_score",
                    email: email
                }),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        currentScore = response.description;
                        document.getElementById("lblTAttemps").innerHTML = (currentScore.win + currentScore.fail + currentScore.skip);
                        document.getElementById("lblWins").innerHTML = currentScore.win;
                        document.getElementById("lblFails").innerHTML = currentScore.fail;
                        document.getElementById("lblSkips").innerHTML = currentScore.skip;
                        loadChart();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed:", error);
                }
            });
        }

        function loadChart() {
            if (chartInstance) {
                chartInstance.destroy();
            }

            const attempts = (currentScore.win + currentScore.fail + currentScore.skip);
            const wins = currentScore.win;
            const losses = (currentScore.fail);
            const skips = (currentScore.skip);

            const ctx = document.getElementById('resultPieChart').getContext('2d');

            chartInstance = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Wins', 'Losses', 'Skips'],
                    datasets: [{
                        data: [wins, losses, skips],
                        backgroundColor: [
                            'rgba(49, 101, 61)',
                            'rgba(102, 37, 37 )',
                            'rgba(14, 56, 81  )'
                        ],
                        borderColor: [
                            'rgba(21, 78, 34)',
                            'rgba(102, 37, 37 )',
                            'rgba(14, 56, 81  )'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const value = tooltipItem.raw;
                                    const total = wins + losses + skips;
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${tooltipItem.label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

        }
    </script>
</body>

</html>