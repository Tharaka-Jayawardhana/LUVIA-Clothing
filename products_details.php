<?php

include '../../php/db.php';


if (isset($_GET['id'])) {


    $product_id = $_GET['id'];


    $query = mysqli_query(
        $conn,

        "SELECT * FROM products 
    WHERE product_id='$product_id'"

    );


    $product = mysqli_fetch_assoc($query);



    if (!$product) {

        die("Product Not Found");

    }


} else {

    die("No Product ID");

}


?>


<!DOCTYPE html>
<html>

<head>

    <title><?= $product['product_name']; ?></title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {

            background: #F5F5FF;

        }


        .product-img {

            width: 100%;
            height: 600px;
            object-fit: contain;
            background: white;
            padding: 20px;
            border-radius: 20px;

        }



        .color-btn {

            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: 2px solid #ddd;
            cursor: pointer;

        }

        .btn-primary {
            border: 2px solid #5B3DF5;
            background: #5B3DF5;
            font-weight: 600;
            border-radius: 10px;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background: #5B3DF5;
    
        }
    </style>


</head>



<body>


    <div class="container mt-5">


        <div class="row">


            <!-- Image -->

            <div class="col-md-6">


                <img id="productImage" src="../../images/<?= $product['image']; ?>" class="product-img">


            </div>



            <!-- Details -->

            <div class="col-md-6">


                <h1>

                    <?= $product['product_name']; ?>

                </h1>


                <h3 class="text-primary">

                    Rs. <?= $product['price']; ?>

                </h3>



                <hr>


                <form action="../../php/add_to_cart.php" method="POST">

    <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">


    <h5>Choose Color</h5>

    <div class="d-flex gap-3">

        <label>
            <input type="radio" name="color" value="White" required>
            White
        </label>


        <label>
            <input type="radio" name="color" value="Black">
            Black
        </label>


        <label>
            <input type="radio" name="color" value="Red">
            Red
        </label>

    </div>


    <br>


    <h5>Select Size</h5>

    <select name="size" class="form-select w-50" required>

        <option value="">Select Size</option>

        <option value="S">S</option>

        <option value="M">M</option>

        <option value="L">L</option>

        <option value="XL">XL</option>

    </select>


    <br>

<form action="../../php/add_to_cart.php" method="POST">

    <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">

    <button type="submit" name="add_cart" class="btn btn-primary px-5">

        Add To Cart

    </button>


</form>

        </div>


    </div>



    <script>


        function changeColor(color) {

            let image = document.getElementById("productImage");


            if (color == "black") {

                image.src = "../../image/blackshirt.png";

            }

            else if (color == "red") {

                image.src = "../../image/redshirt.png";

            }

            else {

                image.src = "../../images/<?= $product['image']; ?>";

            }

        }


    </script>



</body>

</html>