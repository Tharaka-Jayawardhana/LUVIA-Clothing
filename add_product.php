<?php

session_start();

include '../../php/db.php';


// Admin check

if (!isset($_SESSION['admin_id'])) {

    header("Location: admin_login.php");
    exit();

}



$message = "";


// Insert Product

if (isset($_POST['add_product'])) {


    $name = $_POST['product_name'];

    $category = $_POST['category_id'];

    $description = $_POST['description'];

    $price = $_POST['price'];

    $stock = $_POST['stock'];



    // Image upload

    $image = $_FILES['image']['name'];

    $tmp_name = $_FILES['image']['tmp_name'];


    $upload_path = "../../Images/" . $image;



    if (move_uploaded_file($tmp_name, $upload_path)) {


        $sql = "INSERT INTO products
        (
        category_id,
        product_name,
        description,
        price,
        stock,
        image
        )
        VALUES
        (
        '$category',
        '$name',
        '$description',
        '$price',
        '$stock',
        '$image'
        )";


        if (mysqli_query($conn, $sql)) {


            $message = "Product Added Successfully";


        } else {

            $message = "Database Error";

        }


    } else {

        $message = "Image Upload Failed";

    }


}



?>


<!DOCTYPE html>
<html>

<head>

    <title>Add Product | LUVIA</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="../style.css">


</head>


<body>


    <div class="container mt-5">


        <div class="card shadow p-4 rounded-4">


            <h2 class="mb-4">
                Add New Product
            </h2>


            <?php if ($message != "") { ?>

                <div class="alert alert-info">

                    <?= $message ?>

                </div>

            <?php } ?>



            <form method="POST" enctype="multipart/form-data">


                <div class="mb-3">

                    <label class="form-label">
                        Product Name
                    </label>

                    <input type="text" name="product_name" class="form-control" required>

                </div>




                <div class="mb-3">

                    <label class="form-label">
                        Category
                    </label>


                    <select name="category_id" class="form-control" required>


                        <option value="">
                            Select Category
                        </option>


                        <?php


                        $cat = mysqli_query(
                            $conn,
                            "SELECT * FROM categories"
                        );


                        while ($row = mysqli_fetch_assoc($cat)) {


                            ?>

                            <option value="<?= $row['category_id']; ?>">

                                <?= $row['category_name']; ?>

                            </option>


                        <?php } ?>


                    </select>


                </div>




                <div class="mb-3">


                    <label>
                        Description
                    </label>


                    <textarea name="description" class="form-control" rows="3"></textarea>


                </div>





                <div class="mb-3">


                    <label>
                        Price
                    </label>


                    <input type="number" name="price" class="form-control" required>


                </div>




                <div class="mb-3">


                    <label>
                        Stock
                    </label>


                    <input type="number" name="stock" class="form-control" required>


                </div>




                <div class="mb-3">


                    <label>
                        Product Image
                    </label>


                    <input type="file" name="image" class="form-control" required>


                </div>



                <button type="submit" name="add_product" class="btn btn-primary px-5">

                    Add Product

                </button>


                <a href="manage_product.php" class="btn btn-secondary">

                    Back

                </a>


            </form>



        </div>


    </div>


</body>

</html>