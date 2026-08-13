<?php

session_start();

include '../../php/db.php';


if (!isset($_SESSION['admin_id'])) {

    header("Location: admin_login.php");
    exit();

}


// Get users

$query = mysqli_query(
    $conn,

    "SELECT *
FROM users
ORDER BY user_id DESC"

);


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>LUVIA | Manage Users</title>


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

                        <a href="manage_orders.php" class="nav-link">

                            <i class="fa fa-box"></i>
                            Orders

                        </a>

                    </li>



                    <li class="nav-item">

                        <a href="manage_users.php" class="nav-link active">

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

                        Manage Users

                    </h3>


                    <div class="admin-profile">

                        <i class="fa fa-user-circle"></i>

                        Admin

                    </div>


                </div>




                <div class="table-card mt-4">


                    <h4 class="mb-4">

                        User List

                    </h4>



                    <div class="table-responsive">


                        <table class="table table-hover align-middle">


                            <thead>

                                <tr>

                                    <th>ID</th>

                                    <th>Name</th>

                                    <th>Email</th>

                                    <th>Phone</th>

                                    <th>Address</th>

                                    <th>Role</th>

                                    <th>Date</th>

                                    <th>Action</th>

                                </tr>


                            </thead>


                            <tbody>


                                <?php while ($row = mysqli_fetch_assoc($query)) { ?>


                                    <tr>


                                        <td>

                                            <?= $row['user_id']; ?>

                                        </td>


                                        <td>

                                            <?= $row['full_name']; ?>

                                        </td>


                                        <td>

                                            <?= $row['email']; ?>

                                        </td>


                                        <td>

                                            <?= $row['phone']; ?>

                                        </td>


                                        <td>

                                            <?= $row['address']; ?>

                                        </td>


                                        <td>


                                            <?php if ($row['role'] == "admin") { ?>

                                                <span class="badge bg-danger">

                                                    Admin

                                                </span>


                                            <?php } else { ?>


                                                <span class="badge bg-primary">

                                                    User

                                                </span>


                                            <?php } ?>


                                        </td>



                                        <td>

                                            <?= $row['created_at']; ?>

                                        </td>



                                        <td>


                                            <a href="delete_user.php?id=<?= $row['user_id']; ?>"
                                                onclick="return confirm('Delete this user?');"
                                                class="btn btn-danger btn-sm">


                                                <i class="fa fa-trash"></i>

                                                Delete


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