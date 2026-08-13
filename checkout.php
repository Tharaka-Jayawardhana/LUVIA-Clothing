<?php
include '../../php/db.php';

session_start();

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();

}

$user_id = $_SESSION['user_id'];

$sql = "SELECT cart.quantity,
               products.product_id,
               products.product_name,
               products.price,
               products.image
        FROM cart
        JOIN products
        ON cart.product_id = products.product_id
        WHERE cart.user_id='$user_id'";

$result = mysqli_query($conn, $sql);

$total = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LUVIA | Checkout</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="../style.css">

</head>

<body class="checkout-page">

    <div class="container py-5">

        <h2 class="text-center fw-bold mb-5">
            Checkout
        </h2>

        <div class="row g-4 justify-content-center">

            <!-- SHIPPING ADDRESS -->

            <div class="col-lg-4">

                <div class="checkout-card">

                    <h4 class="mb-4">
                        Shipping Address
                    </h4>

                    <form>

                        <div class="mb-3">

                            <label class="form-label">
                                Full Name
                            </label>

                            <input type="text" class="form-control" placeholder="John Doe">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Phone Number
                            </label>

                            <input type="text" class="form-control" placeholder="+94 77 1234567">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Address Line 1
                            </label>

                            <input type="text" class="form-control" placeholder="Street Address">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Address Line 2
                            </label>

                            <input type="text" class="form-control" placeholder="Apartment (Optional)">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                City
                            </label>

                            <input type="text" class="form-control" placeholder="Colombo">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Province
                            </label>

                            <input type="text" class="form-control" placeholder="Western">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Postal Code
                            </label>

                            <input type="text" class="form-control" placeholder="10100">

                        </div>

                    </form>

                </div>

            </div>

            <!-- PAYMENT METHOD -->

            <div class="col-lg-4">

                <div class="checkout-card">

                    <h4 class="mb-4">
                        Payment Method
                    </h4>

                    <div class="form-check mb-3">

                        <input class="form-check-input" type="radio" name="payment" checked>

                        <label class="form-check-label fw-bold">
                            Credit / Debit Card
                        </label>

                    </div>

                    <div class="payment-icons mb-4">

                        <img src="../../images/visa.png" width="70">

                        <img src="../../images/mastercard.png" width="70">

                        <img src="../../images/amex.png" width="70">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Card Number
                        </label>

                        <input type="text" class="form-control" placeholder="1234 5678 9012 3456">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Card Holder Name
                        </label>

                        <input type="text" class="form-control" placeholder="John Doe">

                    </div>

                    <div class="row">

                        <div class="col-6">

                            <label class="form-label">
                                Expiry Date
                            </label>

                            <input type="text" class="form-control" placeholder="MM/YY">

                        </div>

                        <div class="col-6">

                            <label class="form-label">
                                CVV
                            </label>

                            <input type="password" class="form-control" placeholder="123">

                        </div>

                    </div>

                    <hr>

                    <div class="form-check mt-3">

                        <input class="form-check-input" type="radio" name="payment">

                        <label class="form-check-label fw-bold">
                            Cash On Delivery
                        </label>

                    </div>

                </div>

            </div>

            <!-- ORDER SUMMARY -->

            <div class="col-lg-4">

                <div class="checkout-card">

                    <h4 class="mb-4">
                        Order Summary
                    </h4>
                    <?php while ($row = mysqli_fetch_assoc($result)) {

                        $subtotal = $row['price'] * $row['quantity'];
                        $total += $subtotal;
                        ?>

                        <div class="order-item">

                            <img src="../../images/<?php echo $row['image']; ?>">

                            <div class="product-info">

                                <h6><?php echo $row['product_name']; ?></h6>

                                <small>x<?php echo $row['quantity']; ?></small>

                            </div>
                            <div class="price">
                                <span>Rs. <?php echo $subtotal; ?></span>
                            </div>
                        </div>

                    <?php } ?>

                    <hr>

                    <div class="d-flex justify-content-between">

                        <span>Subtotal</span>

                        <span>Rs. <?php echo $total; ?></span>

                    </div>

                    <div class="d-flex justify-content-between mt-2">

                        <span>Shipping</span>

                        <span>Rs. 300</span>

                    </div>

                    <div class="d-flex justify-content-between mt-2">

                        <span>Discount</span>

                        <span>Rs. 0</span>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">

                        <h4>Total</h4>

                        <h4 class="text-primary">
                            Rs. <?php echo $total + 300; ?>
                        </h4>

                    </div>

                    <form action="../../php/place_order.php" method="POST">

                        <button type="submit" class="btn btn-primary w-100 mt-4 place-btn">
                            Place Order
                        </button>

                    </form>
                </div>

            </div>

        </div>

    </div>

    <!-- FOOTER -->

    <footer class="footer mt-5">

        <h3>LUVIA</h3>

        <p>Customize your fashion with AI powered shopping</p>

    </footer>

</body>

</html>