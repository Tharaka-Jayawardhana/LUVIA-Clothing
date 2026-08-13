<?php

session_start();

include '../../php/db.php';

if (!isset($_SESSION['admin_id'])) {

    header("Location: admin_login.php");
    exit();

}


// Total Products

$product_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM products"
);

$product_count = mysqli_fetch_assoc($product_query)['total'];



// Total Orders

$order_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM orders"
);

$order_count = mysqli_fetch_assoc($order_query)['total'];



// Total Users

$user_query = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total 
FROM users 
WHERE role='user'"
);

$user_count = mysqli_fetch_assoc($user_query)['total'];



// Total Revenue

$revenue_query = mysqli_query(
    $conn,
    "SELECT SUM(total_amount) AS total 
FROM orders"
);

$revenue = mysqli_fetch_assoc($revenue_query)['total'];

if ($revenue == null) {

    $revenue = 0;

}



// Recent Orders

$recent_orders = mysqli_query(
    $conn,

    "SELECT 
orders.order_id,
users.full_name,
products.product_name,
orders.order_status,
orders.total_amount

FROM orders

JOIN users
ON orders.user_id = users.user_id

JOIN order_items
ON orders.order_id = order_items.order_id

JOIN products
ON order_items.product_id = products.product_id

ORDER BY orders.order_id DESC

LIMIT 5"

);


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LUVIA | Admin Dashboard</title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- CSS -->

    <link rel="stylesheet" href="../style.css">
</head>



<body>

    <div class="container-fluid">

        <div class="row">

            <!-- ================= SIDEBAR ================= -->

            <div class="col-lg-2 sidebar">

                <div class="logo">

                    <h2>LUVIA</h2>

                    <p>Admin Panel</p>

                </div>

                <ul class="nav flex-column mt-4">

                    <li class="nav-item">

                        <a href="#" class="nav-link active">

                            <i class="fa-solid fa-house"></i>

                            Dashboard

                        </a>

                    </li>

                    <li class="nav-item">

                        <a href="manage_product.php" class="nav-link">

                            <i class="fa-solid fa-shirt"></i>

                            Products

                        </a>

                    </li>

                    <li class="nav-item">

                        <a href="manage_orders.php" class="nav-link">

                            <i class="fa-solid fa-box"></i>

                            Orders

                        </a>

                    </li>

                    <li class="nav-item">

                        <a href="manage_user.php" class="nav-link">

                            <i class="fa-solid fa-users"></i>

                            Users

                        </a>

                    </li>

                    <li class="nav-item">

                        <a href="custom_designs.php" class="nav-link">

                            <i class="fa-solid fa-palette"></i>

                            Custom Designs

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link text-danger mt-3" href="../login/login.html" onclick="logout()">
                            <i class="fa fa-right-from-bracket"></i> Logout
                        </a>

                    </li>

                </ul>

            </div>

            <!-- ================= MAIN CONTENT ================= -->

            <div class="col-lg-10 main-content">

                <!-- TOP NAVBAR -->

                <div class="top-bar">

                    <h3>

                        Dashboard

                    </h3>

                    <div class="admin-profile">

                        <i class="fa-solid fa-user-circle"></i>

                       <span>Admin</span>

                    </div>

                </div>

                <!-- DASHBOARD CARDS -->

                <div class="row mt-4">

                    <div class="col-md-3">

                        <div class="dashboard-card">

                            <i class="fa-solid fa-shirt card-icon"></i>

                            <h5>Total Products</h5>

                            <h2><?= $product_count ?></h2>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="dashboard-card">

                            <i class="fa-solid fa-box card-icon"></i>

                            <h5>Total Orders</h5>

                            <h2><?= $order_count ?></h2>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="dashboard-card">

                            <i class="fa-solid fa-users card-icon"></i>

                            <h5>Total Users</h5>

                            <h2><?= $user_count ?></h2>

                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="dashboard-card">

                            <i class="fa-solid fa-dollar-sign card-icon"></i>

                            <h5>Total Revenue</h5>

                            <h2>
                                Rs. <?= number_format($revenue, 2) ?>
                            </h2>

                        </div>

                    </div>

                </div>

                <!-- ================= RECENT ORDERS ================= -->

                <div class="row mt-5">

                    <div class="col-lg-8">

                        <div class="table-card">

                            <h4 class="mb-4">

                                Recent Orders

                            </h4>

                            <table class="table table-hover align-middle">

                                <thead>

                                    <tr>

                                        <th>Order ID</th>

                                        <th>Customer</th>

                                        <th>Product</th>

                                        <th>Status</th>

                                        <th>Amount</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php while ($row = mysqli_fetch_assoc($recent_orders)) { ?>

                                        <tr>

                                            <td>
                                                #<?= $row['order_id']; ?>
                                            </td>

                                            <td>
                                                <?= $row['full_name']; ?>
                                            </td>

                                            <td>
                                                <?= $row['product_name']; ?>
                                            </td>

                                            <td>

                                                <span class="badge bg-warning">
                                                    <?= $row['order_status']; ?>
                                                </span>

                                            </td>

                                            <td>
                                                Rs. <?= $row['total_amount']; ?>
                                            </td>

                                        </tr>


                                    <?php } ?>


                                </tbody>

                            </table>

                        </div>

                    </div>

                    <!-- ================= RECENT ACTIVITY ================= -->

                    <div class="col-lg-4">

                        <div class="activity-card">

                            <h4 class="mb-4">

                                Recent Activity

                            </h4>

                            <div class="activity-item">

                                <i class="fa-solid fa-circle-check text-success"></i>

                                <span>

                                    New order received

                                </span>

                            </div>

                            <div class="activity-item">

                                <i class="fa-solid fa-user-plus text-primary"></i>

                                <span>

                                    New user registered

                                </span>

                            </div>

                            <div class="activity-item">

                                <i class="fa-solid fa-shirt text-warning"></i>

                                <span>

                                    Product updated

                                </span>

                            </div>

                            <div class="activity-item">

                                <i class="fa-solid fa-palette text-danger"></i>

                                <span>

                                    New custom design request

                                </span>

                            </div>

                            <div class="activity-item">

                                <i class="fa-solid fa-box text-info"></i>

                                <span>

                                    Order shipped

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- ================= FOOTER ================= -->

                <footer class="text-center mt-5 mb-3 text-muted">

                    © 2026 LUVIA Admin Panel

                </footer>

            </div>

        </div>

    </div>


</body>

</html>