<?php
session_start();
include '../../php/db.php';

$error = "";

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users
            WHERE email='$email'
            AND role='admin'
            LIMIT 1";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $admin = mysqli_fetch_assoc($result);

        if (password_verify($password, $admin['password'])) {

            $_SESSION['admin_id'] = $admin['user_id'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['admin_email'] = $admin['email'];

            header("Location: dashboard.php");
            exit();

        } else {

            $error = "Incorrect Password";

        }

    } else {

        $error = "Admin Not Found";

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LUVIA | Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="../style.css">
</head>

<body class="login-page">

    <div class="container py-5">

        <div class="login-card">

            <div class="row g-0">

                <!-- LEFT SIDE -->

                <div class="col-lg-5">

                    <div class="login-left">

                        <h2>Design Your Style.<br>
                            Wear Your Story.
                        </h2>

                        <p>
                            Custom apparel made just for you.
                        </p>

                    </div>

                </div>

                <!-- RIGHT SIDE -->

                <div class="col-lg-7">

                    <div class="login-right">

                        <div class="text-center mb-4">

                            <div class="nav-logo justify-content-center">
                                <img src="../../images/logo.png" class="img-fluid rounded-circle me-2" alt="Logo"
                                    style="width:70px; height:70px; object-fit:cover;">

                                <div>
                                    <h1 class="m-0">LUVIA</h1>

                                </div>
                            </div>

                        </div>

                        <!-- LOGIN / REGISTER TAB -->

                        <ul class="nav nav-tabs justify-content-center mb-4">

                            <li class="nav-item">

                                <a class="nav-link active" href="../login/login.html">

                                    Login

                                </a>

                            </li>

                        </ul>

                        <h2 class="fw-bold">

                            Welcome Back!

                        </h2>

                        <p class="text-muted mb-4">

                            Sign in to continue to your account.

                        </p>

                        <form action="" method="POST" id="loginForm">

                            <!-- EMAIL-->

                            <div class="mb-3">

                                <label class="form-label">

                                    Email

                                </label>

                                <input type="email" name="email" id="username" class="form-control"
                                    placeholder="Enter your email">

                            </div>

                            <!-- PASSWORD -->

                            <div class="mb-3">

                                <label class="form-label">

                                    Password

                                </label>

                                <div>

                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Enter your password">
                                    <span class="input-group-text">


                                    </span>

                                </div>

                            </div>

                            <!-- REMEMBER -->

                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <div class="form-check">

                                    <input class="form-check-input" type="checkbox">

                                    <label class="form-check-label">

                                        Remember me

                                    </label>

                                </div>

                                <a href="#" class="text-decoration-none">

                                    Forgot Password?

                                </a>

                            </div>

                            <!-- LOGIN BUTTON -->

                            <button type="submit" name="login" class="login-btn w-100">
                                Login

                            </button>

                            <div class="text-center my-4">

                                or continue with

                            </div>

                        </form>

                        <!-- SOCIAL LOGIN -->

                        <div class="row">

                            <div class="col-6">

                                <button class="btn btn-outline-danger w-100 social-btn">

                                    <i class="fa-brands fa-google"></i>

                                    Google

                                </button>

                            </div>

                            <div class="col-6">

                                <button class="btn btn-outline-primary w-100 social-btn">

                                    <i class="fa-brands fa-facebook-f"></i>

                                    Facebook

                                </button>

                            </div>

                        </div>

                        <div class="text-center mt-4">

                            Don't have an account?

                            <a href="../register/register.html" class="text-decoration-none fw-bold">

                                Register

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


</body>

</html>