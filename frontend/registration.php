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
                        <h4 class="card-title text-dark fw-bold pt-1 text-uppercase text-center">REGISTRATION</h4>
                        <form id="registrationForm">
                            <div class="pt-3">
                                <label>Full Name</label>
                                <input class="form-control" type="text" id="fullname" name="fullname" required />
                            </div>
                            <div class="pt-3">
                                <label>Email (User Name)</label>
                                <input class="form-control" type="email" id="email" name="email" required placeholder="example@example.com" oninput="validateEmail()" />
                                <small id="emailHelp" class="form-text text-muted">Please enter a valid email address.</small>
                            </div>

                            <div class="pt-3">
                                <label>Telephone Number</label>
                                <input class="form-control" type="tel" id="telephone" name="telephone" required oninput="validatePhoneNumber()" />
                                <small id="phoneHelp" class="form-text text-muted">Please enter a valid telephone number (e.g., +1234567890).</small>
                            </div>
                            <div class="pt-3">
                                <label>Password</label>
                                <input class="form-control" type="password" id="password" name="password" required oninput="validatePassword()" />
                                <small id="passwordHelp" class="form-text text-muted">Password must contain at least 8 characters, including a number and a special character.</small>
                            </div>

                            <div class="pt-4">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-dark btn-block">SIGN UP <i class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="pt-2 text-center">
                            <label class="text-center txt-xsm">Already have an account? <a href="index.php">Login</a></label>
                            <label class="text-center txt-xsm">Forgot Password? <a href="forgot_password.php">Reset Password</a></label>
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
            $('#registrationForm').on('submit', function(e) {
                e.preventDefault();
                var formData = {
                    "action": "register",
                    full_name: $('#fullname').val(),
                    email: $('#email').val(),
                    telephone: $('#telephone').val(),
                    password: $('#password').val()
                };
                console.log(formData);

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
                                title: 'Success!',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'index.php';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message,
                                confirmButtonText: 'Try Again'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again later.',
                            confirmButtonText: 'OK'
                        });
                    }
                });

            });
        });
    </script>
</body>