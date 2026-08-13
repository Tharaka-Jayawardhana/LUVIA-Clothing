<?php

session_start();

include '../../php/db.php';


if (!isset($_SESSION['admin_id'])) {

    header("Location: admin_login.php");
    exit();

}


// Delete Product

if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    mysqli_query(
        $conn,
        "DELETE FROM products WHERE product_id='$id'"
    );

    header("Location: manage_product.php");

    exit();

}



// Get Products

$product_query = mysqli_query(
    $conn,

    "SELECT 
products.*,
categories.category_name

FROM products

LEFT JOIN categories

ON products.category_id = categories.category_id

ORDER BY product_id DESC"

);


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LUVIA | Manage Products</title>

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

                        <a href="dashboard.php" class="nav-link">

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

                <div class="top-bar">

                    <h3>

                        Manage Products

                    </h3>

                    <div class="admin-profile">

                        <i class="fa-solid fa-user-circle"></i>

                        <span>
                            <?= $_SESSION['admin_name']; ?>
                        </span>

                    </div>

                </div>

                <!-- SEARCH & ADD -->

                <div class="row mt-4 mb-4">

                    <div class="col-md-6">

                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="fa-solid fa-magnifying-glass"></i>

                            </span>

                            <input type="text" class="form-control" placeholder="Search products...">

                        </div>

                    </div>

                    <div class="col-md-6 text-md-end mt-3 mt-md-0">

                        <a href="add_product.php" class="btn btn-primary add-btn">

                            <i class="fa-solid fa-plus"></i>

                            Add Product

                        </a>

                    </div>

                </div>

                <!-- ================= PRODUCTS TABLE ================= -->

                <div class="table-card">

                    <h4 class="mb-4">Product List</h4>

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead>

                                <tr>

                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Actions</th>

                                </tr>

                            </thead>

                            <tbody>

                            <tbody>

                                <?php while ($row = mysqli_fetch_assoc($product_query)) { ?>

                                    <tr>

                                        <td>
                                            <?= $row['product_id']; ?>
                                        </td>


                                        <td>
                                            <img src="/LUVIA/Images/<?= $row['image']; ?>" class="product-img">
                                        </td>

                                        <td>
                                            <?= $row['product_name']; ?>
                                        </td>


                                        <td>
                                            <?= $row['category_name']; ?>
                                        </td>


                                        <td>
                                            Rs. <?= $row['price']; ?>
                                        </td>


                                        <td>
                                            <?= $row['stock']; ?>
                                        </td>


                                        <td>

                                            <?php if ($row['stock'] > 0) { ?>

                                                <span class="badge bg-success">
                                                    Available
                                                </span>

                                            <?php } else { ?>

                                                <span class="badge bg-danger">
                                                    Out Of Stock
                                                </span>

                                            <?php } ?>

                                        </td>


                                        <td>

                                            <a href="edit_product.php?id=<?= $row['product_id']; ?>"
                                                class="btn btn-warning btn-sm">

                                                <i class="fa-solid fa-pen"></i>

                                                Edit

                                            </a>


                                            <a href="delete_product.php?id=<?= $row['product_id']; ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this product?');">

                                                <i class="fa-solid fa-trash"></i>

                                                Delete

                                            </a>


                                        </td>


                                    </tr>


                                <?php } ?>


                            </tbody>

                            </tbody>

                        </table>

                    </div>

                </div>

                <!-- Footer -->

                <footer class="text-center mt-5 mb-3 text-muted">

                    © 2026 LUVIA Admin Panel

                </footer>

            </div>

        </div>

    </div>

</body>

</html>