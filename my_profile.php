<?php
include '../../php/db.php';

session_start();

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();

}

$user_id = $_SESSION['user_id'];

$user_query = mysqli_query($conn,"
SELECT *
FROM users
WHERE user_id='$user_id'
");

$user = mysqli_fetch_assoc($user_query);

if(!$user){
    die("User Not Found");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | LUVIA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="../style.css">
</head>

<body>

<div class="container py-5">

    <div class="profile-card">

        <div class="text-center">

            <img src="../../images/user.png" class="profile-img">

            <h2 class="mt-3">
                <?php echo $user['full_name']; ?>
            </h2>

            <p class="text-muted">
                Member Since
                <?php echo date("d M Y",strtotime($user['created_at'])); ?>
            </p>

        </div>

        <hr>

        <div class="profile-info">

            <div class="info-row">
                <i class="fa-solid fa-envelope"></i>
                <span><?php echo $user['email']; ?></span>
            </div>

            <div class="info-row">
                <i class="fa-solid fa-phone"></i>
                <span><?php echo $user['phone']; ?></span>
            </div>

            <div class="info-row">
                <i class="fa-solid fa-location-dot"></i>
                <span><?php echo $user['address']; ?></span>
            </div>

        </div>

        <hr>

        <div class="d-grid gap-3">

            <a href="../tracking/order_tracking.php"
               class="btn profile-btn">
                <i class="fa-solid fa-box"></i>
                My Orders
            </a>

            <a href="../point/loyalty_point.php"
               class="btn btn-outline-primary">
                <i class="fa-solid fa-user-pen"></i>
                My POint
            </a>

            <a href="../../php/logout.php"
               class="btn btn-danger">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </a>

        </div>

    </div>

</div>

</body>
</html>