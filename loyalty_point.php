<?php
include '../../php/db.php';


session_start();

$user_id = $_SESSION['user_id'] ?? null;

if ($user_id) {

    $sql = "SELECT points
            FROM loyalty_points
            WHERE user_id='$user_id'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);
        $points = $row['points'];

    } else {

        $points = 0;

    }

} else {

    $points = 0;

}

$sql = "SELECT points
        FROM loyalty_points
        WHERE user_id='$user_id'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_assoc($result);

    $points = $row['points'];

} else {

    $points = 0;

}

if ($points < 300) {

    $level = "Bronze";
    $next = 300;

} elseif ($points < 500) {

    $level = "Gold";
    $next = 500;

} else {

    $level = "Platinum";
    $next = 1000;

}

$progress = ($points / $next) * 100;

if ($progress > 100) {
    $progress = 100;
}

$remaining = $next - $points;

if ($remaining < 0) {
    $remaining = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LUVIA | Loyalty</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="../style.css">

</head>

<body class="loyalty-page">

    <div class="container py-5">

        <div class="text-center mb-5">
            <h2 class="fw-bold">Loyalty Rewards</h2>
            <p class="text-muted">Earn points and redeem exciting rewards.</p>
        </div>

        <!-- Points Card -->

        <div class="points-card mb-5">

            <div class="row align-items-center">

                <div class="col-md-7">

                    <h4>Your Points</h4>

                    <h1><?php echo $points; ?></h1>

                    <p>Keep shopping and earn more points!</p>

                </div>

                <div class="col-md-5 text-center">

                    <i class="fa-solid fa-crown crown"></i>

                </div>

            </div>

        </div>

        <div class="row g-4">

            <!-- Earn Points -->
            <div class="col-lg-4 d-flex">

                <div class="card w-100 shadow-sm border-0 rounded-4">

                    <div class="card-body">

                        <h4 class="fw-bold mb-4">
                            Current Level
                        </h4>

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <span class="badge bg-warning text-dark px-3 py-2">
                                <?php echo $level; ?> Member
                            </span>

                            <span class="fw-semibold">
                                <?php echo $points; ?> / <?php echo $next; ?> Points
                            </span>

                        </div>

                        <div class="progress mb-3" style="height:10px;">

                            <div class="progress-bar" style="width:<?php echo $progress; ?>%; background:#5B3DF5;">
                            </div>

                        </div>

                        <small class="text-muted">
                            Earn <?php echo $remaining; ?> more points to reach the next level.
                        </small>

                    </div>

                </div>

            </div>

            <!-- Recent Activity -->
            <div class="col-lg-4 d-flex">
                <div class="card w-100 shadow-sm border-0 rounded-4">

                    <div class="card-body">

                        <h4 class="fw-bold mb-3">Recent Activity</h4>

                        <ul class="list-group list-group-flush">

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Shopping Rewards</span>
                                <span class="text-success">
                                    +<?php echo $points; ?> pts
                                </span>
                            </li>

                        </ul>

                    </div>

                </div>
            </div>


            <!-- Loyalty Benefits -->
            <div class="col-lg-4 d-flex">

                <div class="card w-100 shadow-sm border-0 rounded-4">

                    <div class="card-body">

                        <h4 class="fw-bold mb-4">
                            Loyalty Benefits
                        </h4>

                        <table class="table">

                            <tbody>

                                <tr>
                                    <td>Earn Points</td>
                                    <td class="text-end">
                                        Every Order
                                    </td>
                                </tr>

                                <tr>
                                    <td>Membership</td>
                                    <td class="text-end">
                                        Bronze - Gold - Platinum
                                    </td>
                                </tr>

                                <tr>
                                    <td>Track Progress</td>
                                    <td class="text-end">
                                        Anytime
                                    </td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- FOOTER -->

    <footer class="footer mt-6">

        <h3>LUVIA</h3>

        <p>Customize your fashion with AI powered shopping</p>

    </footer>

</body>

</html>