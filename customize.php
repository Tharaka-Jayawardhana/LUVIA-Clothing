<?php
include '../../php/db.php';

$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 13;

$sql = "SELECT * FROM products WHERE product_id='$product_id'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Product Not Found");
}

$product = mysqli_fetch_assoc($result);

$count_query = mysqli_query(
    $conn,
    "SELECT SUM(quantity) AS total
 FROM cart
 WHERE user_id=1"
);

$count = mysqli_fetch_assoc($count_query);
$total_cart = $count['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LUVIA | Customize</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="../style.css">

</head>

<body class="customize-page">

    <div class="container py-5">

        <h2 class="text-center fw-bold mb-2">
            Customize Your T-Shirt
        </h2>

        <p class="text-center text-muted mb-5">
            Design your own style with colors, text and images.
        </p>

        <div class="row g-4">

            <!-- LEFT SIDE -->
            <div class="col-lg-8">

                <div class="preview-card">

                    <canvas id="tshirtCanvas" width="550" height="650">
                    </canvas>

                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="col-lg-4">

                <div class="custom-panel">

                    <h3 class="mb-3">
                        <?= $product['product_name']; ?>
                    </h3>

                    <h4 class="text-primary mb-4">
                        Rs. <?= $product['price']; ?>
                    </h4>

                    <button class="btn save-btn w-100 mb-4" id="saveBtn">

                        Save Design

                    </button>

                    <h5>Choose Color</h5>

                    <div class="colors mb-4">

                        <span class="color blue" onclick="changeColor('#2196F3')"></span>

                        <span class="color pink" onclick="changeColor('#E91E63')"></span>

                        <span class="color purple" onclick="changeColor('#9C27B0')"></span>

                        <span class="color royal" onclick="changeColor('#304FFE')"></span>

                        <span class="color orange" onclick="changeColor('#FF9800')"></span>

                        <span class="color navy" onclick="changeColor('#001f5c')"></span>

                        <span class="color black" onclick="changeColor('#000000')"></span>

                        <span class="color yellow" onclick="changeColor('#FFD54F')"></span>

                        <span class="color red" onclick="changeColor('#f21515')"></span>
                    </div>

                    <h5>Add Text</h5>

                    <input type="text" id="textInput" class="form-control mb-3" placeholder="Enter Text">

                    <button id="addText" class="btn btn-primary w-100 mb-3">

                        Add Text

                    </button>

                    <h5>Font Size</h5>

                    <input type="range" id="fontSize" min="15" max="80" value="30" class="form-range">

                    <h5 class="mt-4">Font Family</h5>

                    <select id="fontFamily" class="form-select mb-3">
                        <option value="Arial">Arial</option>
                        <option value="Poppins">Poppins</option>
                        <option value="Roboto">Roboto</option>
                        <option value="Times New Roman">Times New Roman</option>
                        <option value="Courier New">Courier New</option>
                    </select>

                    <h5>Text Style</h5>

                    <div class="text-tools">

                        <button id="boldBtn" class="tool-btn">
                            <b>B</b>
                        </button>

                        <button id="italicBtn" class="tool-btn">
                            <i>I</i>
                        </button>

                    </div>

                    <h5 class="mt-3">Text Color</h5>

                    <input type="color" id="textColor" class="form-control form-control-color" value="#000000">

                    <h5 class="mt-4">Select Size</h5>

                    <select id="size" class="form-select mb-3">

                        <option value="S">Small (S)</option>

                        <option value="M" selected>Medium (M)</option>

                        <option value="L">Large (L)</option>

                        <option value="XL">Extra Large (XL)</option>

                    </select>


                    <h5 class="mt-4">
                        Upload Your Logo Or Sticker
                    </h5>

                    <input type="file" id="uploadDesign" accept="image/*">
                    <hr>
                    <button id="deleteObject" class="btn btn-danger w-100 mb-3">

                        Delete Selected

                    </button>

                    <form action="../../php/add_to_cart.php" method="POST">

                        <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">

                        <input type="hidden" name="color" id="selectedColor" value="white">


                        <button type="submit" name="add_cart" class="btn btn-dark w-100">

                            Add To Cart

                        </button>

                    </form>
                </div>

            </div>

        </div>
    </div>

    <!-- ================= FOOTER ================= -->

    <footer class="footer mt-5">

        <h3>LUVIA</h3>

        <p>Customize your fashion with AI powered shopping</p>

    </footer>

    <!-- Hidden Product Details -->

    <input type="hidden" id="product_id" value="<?= $product['product_id']; ?>">

    <input type="hidden" id="size" value="M">

    <!-- Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Fabric JS -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>

    <!-- Customize JS -->

    <script src="customize.js"></script>

</body>

</html>