<?php

session_start();

include '../../php/db.php';


// Admin check

if (!isset($_SESSION['admin_id'])) {

    header("Location: admin_login.php");
    exit();

}



// Get orders

$query = mysqli_query(
    $conn,

    "SELECT 
orders.order_id,
orders.order_date,
orders.total_amount,
orders.order_status,

users.full_name,
users.email

FROM orders

JOIN users
ON orders.user_id = users.user_id

ORDER BY orders.order_id DESC"

);


?>


<!DOCTYPE html>
<html>

<head>

    <title>LUVIA | Manage Orders</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    <link rel="stylesheet" href="../style.css">


</head>


<body>


    <div class="container-fluid">


        <div class="row">


            <!-- SIDEBAR -->

            <div class="col-lg-2 sidebar">


                <div class="logo">

                    <h2>LUVIA</h2>

                    <p>Admin Panel</p>

                </div>


                <ul class="nav flex-column mt-4">


                    <li class="nav-item">

                        <a href="dashboard.php" class="nav-link">

                            <i class="fa fa-home"></i>
                            Dashboard

                        </a>

                    </li>


                    <li class="nav-item">

                        <a href="manage_product.php" class="nav-link">

                            <i class="fa fa-shirt"></i>
                            Products

                        </a>

                    </li>


                    <li class="nav-item">

                        <a href="manage_orders.php" class="nav-link active">

                            <i class="fa fa-box"></i>
                            Orders

                        </a>

                    </li>


                    <li class="nav-item">

                        <a href="manage_user.php" class="nav-link">

                            <i class="fa fa-users"></i>
                            Users

                        </a>

                    </li>

                    <li class="nav-item">

                        <a href="custom_designs.php" class="nav-link">

                            <i class="fa fa-users"></i>
                            Custom Designs

                        </a>

                    </li>

                    <li class="nav-item mt-3">

                        <a href="admin_login.php" class="nav-link text-danger">

                            <i class="fa fa-right-from-bracket"></i>
                            Logout

                        </a>

                    </li>


                </ul>


            </div>





            <!-- MAIN -->


            <div class="col-lg-10 main-content">



                <div class="top-bar">


                    <h3>
                        Manage Orders
                    </h3>


                    <div class="admin-profile">

                        <i class="fa fa-user-circle"></i>

                        Admin

                    </div>


                </div>





                <div class="table-card mt-4">


                    <h4 class="mb-4">

                        Order List

                    </h4>



                    <div class="table-responsive">


                        <table class="table table-hover">


                            <thead>


                                <tr>

                                    <th>Order ID</th>

                                    <th>Customer</th>

                                    <th>Email</th>

                                    <th>Date</th>

                                    <th>Total</th>

                                    <th>Status</th>

                                    <th>Action</th>


                                </tr>


                            </thead>



                            <tbody>


                                <?php while ($row = mysqli_fetch_assoc($query)) { ?>


                                    <tr>


                                        <td>

                                            #<?= $row['order_id']; ?>

                                        </td>


                                        <td>

                                            <?= $row['full_name']; ?>

                                        </td>


                                        <td>

                                            <?= $row['email']; ?>

                                        </td>


                                        <td>

                                            <?= $row['order_date']; ?>

                                        </td>


                                        <td>

                                            Rs. <?= $row['total_amount']; ?>

                                        </td>



                                        <td>


                                            <?php

                                            $status = $row['order_status'];


                                            if ($status == "Delivered") {

                                                echo '<span class="badge bg-success">Delivered</span>';

                                            } elseif ($status == "Cancelled") {

                                                echo '<span class="badge bg-danger">Cancelled</span>';

                                            } else {

                                                echo '<span class="badge bg-warning text-dark">' . $status . '</span>';

                                            }


                                            ?>


                                        </td>



                                        <td>


                                            <a href="view_order.php?id=<?= $row['order_id']; ?>"
                                                class="btn btn-primary btn-sm">


                                                <i class="fa fa-eye"></i>

                                                View


                                            </a>



                                        </td>



                                    </tr>


                                <?php } ?>


                            </tbody>


                        </table>


                    </div>


                </div>



            </div>



        </div>


    </div>


</body>

</html>