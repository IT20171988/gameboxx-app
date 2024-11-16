<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameBoxx</title>
    <?php include './components/head_link.php' ?>
</head>

<body class="bg-img">
    <div class="container-fluid">
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="card" style="width: 24rem;">
                <div class="card-body">
                    <div class="pt-2">
                        <h4 class="card-title text-dark fw-bold pt-1 text-uppercase text-center">Password Reset</h4>
                        <div class="pt-3">
                            <label>User Name (Email)</label>
                            <input class="form-control" type="email" id="email" name="email" required />
                        </div>
                        <div class="pt-3">
                            <label>Password</label>
                            <input class="form-control" type="password" id="password" name="password" required oninput="validatePassword()" />
                            <small id="passwordHelp" class="form-text text-muted">Password must contain at least 8 characters, including a number and a special character.</small>
                        </div>
                        <div class="pt-3">
                            <label>Confirm Password</label>
                            <input class="form-control" type="password" id="cpassword" name="cpassword" required oninput="validatePasswordMatch()" />
                            <small id="confirmPasswordHelp" class="form-text text-muted">Please confirm your password.</small>
                        </div>
                        <div class="pt-4">
                            <div class="d-grid gap-2">
                                <button class="btn btn-dark btn-block" id="resetPasswordBtn">PASSWORD RESET <i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>
                        <div class="pt-2 text-center">
                            <label class="text-center txt-xsm">Already have an account? <a href="index.php">Login</a></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include './components/bottom_link.php' ?>
    <script src="./js/validation.js"></script>
    <script>
        $(document).ready(function() {
            $('#resetPasswordBtn').click(function(e) {
                e.preventDefault();

                var email = $('#email').val();
                var password = $('#password').val();
                var cpassword = $('#cpassword').val();

                if (password !== cpassword) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Passwords do not match!',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                    return;
                }

                $.ajax({
                    url: '../backend/controller/userController.php',
                    method: 'POST',
                    data: JSON.stringify({
                        action: "forgotpassword",
                        email: email,
                        password: password
                    }),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(data) {

                        if (data.status) {
                            Swal.fire({
                                title: 'Success!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'Login'
                            }).then(function() {
                                window.location.href = 'index.php';
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'Try Again'
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX Request Failed:", textStatus, errorThrown);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong. Please try again later.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>