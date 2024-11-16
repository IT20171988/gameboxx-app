<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameBoxx</title>
    <?php include './components/head_link.php' ?>
</head>

<body class="bg-img">
    <!-- <?php include './components/nav.php' ?> -->
    <div class="container-fluid">
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="card" style="width: 24rem;">
                <div class="card-body">
                    <!-- <div class="text-center">
                        <img src="./img/icon.webp" class="card-img-top" alt="..." style="width: 42%;">
                        <h5 class="card-title text-danger fw-bold pt-1">ChessMate</h5>
                    </div> -->
                    <div class="pt-2">
                        <h4 class="card-title text-dark fw-bold pt-1 text-uppercase text-center">Login</h4>
                        <div class="pt-3">
                            <label>User Name</label>
                            <input class="form-control" type="email" id="email" name="email" />
                        </div>
                        <div class="pt-3">
                            <label>Password</label>
                            <input class="form-control" type="password" id="password" name="password" />
                        </div>
                        <div class="pt-4">
                            <div class="d-grid gap-2">
                                <button class="btn btn-dark btn-block" id="loginBtn">SIGN IN <i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>
                        <div class="pt-2 text-center">
                            <label class="text-center txt-xsm">Already have not an account? <a href="registration.php">Registration</a></label>
                            <label class="text-center txt-xsm">Forgot Password? <a href="forgot_password.php">Reset Password</a></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php include './components/bottom_link.php' ?>
    
    <script>
        $(document).ready(function() {
            $('#loginBtn').click(function(e) {
                e.preventDefault();
                var formData = {
                    "action": "login",
                    email: $('#email').val(),
                    password: $('#password').val()
                };

                $.ajax({
                    url: '../backend/controller/userController.php',
                    type: 'POST',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                       
                        if (response.status === true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Login Successful!',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    console.log(JSON.stringify(response.description));
                                    localStorage.setItem('user', JSON.stringify(response.description));
                                    window.location.href = 'gamedashboard.php';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Failed!',
                                text: response.message,
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Something went wrong. Please try again later.',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>