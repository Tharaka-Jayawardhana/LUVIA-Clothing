<?php
include '../../php/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit();

}

$user_id = $_SESSION['user_id'];

$sql = "SELECT cart.cart_id,
               cart.quantity,
               products.product_name,
               products.price,
               products.image
        FROM cart
        JOIN products
        ON cart.product_id = products.product_id
        WHERE cart.user_id = '$user_id'";

$result = mysqli_query($conn, $sql);

$total = 0;
$discount = 0;


// Coupon Apply
if (isset($_POST['apply_coupon'])) {

    $coupon = $_POST['coupon'];

    if ($coupon == "LUVIA10") {
        $discount = 500;
    } elseif ($coupon == "SAVE1000") {
        $discount = 1000;
    }
}


// Final amount (later update after loop)
$total_amount = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LUVIA | Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="../style.css">

</head>


<body>


    <div class="container py-5">


        <h2 class="fw-bold mb-4">
            Your Cart (<?php echo mysqli_num_rows($result); ?>)
        </h2>


        <div class="row">


            <!-- LEFT SIDE CART ITEMS -->

            <div class="col-lg-8">


                <?php

                if (mysqli_num_rows($result) > 0) {


                    while ($row = mysqli_fetch_assoc($result)) {


                        $total += ($row['price'] * $row['quantity']);

                        ?>


                        <div class="cart-item d-flex align-items-center mb-3 p-3">


                            <img src="../../images/<?php echo $row['image']; ?>" class="cart-img">


                            <div class="item-details ms-4 flex-grow-1">


                                <h5>
                                    <?php echo $row['product_name']; ?>
                                </h5>


                                <p>
                                    Quantity : <?php echo $row['quantity']; ?>
                                </p>


                                <h6>
                                    Rs. <?php echo $row['price']; ?>
                                </h6>


                            </div>



                            <div class="qty-box d-flex align-items-center gap-2">


                                <a href="../../php/update_quantity.php?id=<?php echo $row['cart_id']; ?>&action=decrease"
                                    class="btn btn-sm btn-secondary">-</a>

                                <span><?php echo $row['quantity']; ?></span>

                                <a href="../../php/update_quantity.php?id=<?php echo $row['cart_id']; ?>&action=increase"
                                    class="btn btn-sm btn-secondary">+</a>


                            </div>

                            <div class="qty-box">
                                <a href="../../php/remove_cart.php?id=<?php echo $row['cart_id']; ?>" class="btn-dark ms-3">
                                    🗑
                                </a>
                            </div>
                        </div>

                        <?php

                    }
                    $total_amount = $total + 300 - $discount;

                } else {

                    echo "<h5>Your cart is empty</h5>";

                }
                ?>
            </div>

            <!-- RIGHT SIDE SUMMARY -->

            <div class="col-lg-4 d-flex flex-column gap-4">


                <!-- COUPON CARD -->

                <div class="coupon-card p-4 mb-4">


                    <h5>
                        Apply Coupon
                    </h5>


                    <div class="d-flex mt-3">

                        <form action="cart.php" method="POST" class="d-flex w-100 gap-2">
                            <input type="text" name="coupon" class="form-control flex-grow-1"
                                placeholder="Enter Coupon">

                            <button type="submit" class="apply-btn" name="apply_coupon">
                                Apply
                            </button>
                        </form>

                    </div>
                    <hr>
                    <h6>Apply promotion code <b>"LUVIA10"</b></h6>

                </div>



                <!-- ORDER SUMMARY -->


                <div class="summary-card p-4">


                    <h4>
                        Order Summary
                    </h4>


                    <hr>



                    <div class="summary-row d-flex justify-content-between">

                        <span>
                            Subtotal
                        </span>

                        <span>
                            Rs. <?php echo $total; ?>
                        </span>

                    </div>

                    <div class="summary-row d-flex justify-content-between mt-2">

                        <span>
                            Shipping
                        </span>

                        <span>
                            Rs. 300
                        </span>

                    </div>


                    <div class="summary-row d-flex justify-content-between mt-2">

                        <span>Discount</span>
                        <span>Rs. <?php echo $discount; ?></span>

                    </div>

                    <hr>

                    <div class="summary-row total">

                        <span>Total</span>

                        <span>
                            Rs. <?php echo number_format($total_amount, 2); ?>
                        </span>

                    </div>


                    <a href="../checkout/checkout.php" class="checkout-btn text-decoration-none d-block text-center">
                        Proceed To Checkout
                    </a>

                </div>



            </div>



        </div>


    </div>

    <footer class="footer mt-5">
        <h3>
            LUVIA
        </h3>
        <p>
            Customize your fashion with AI powered shopping
        </p>
    </footer>

</body>

</html>