<?php
include '../../php/db.php';
session_start();

$user = null;
$user_id = null;

if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    $result = mysqli_query(
        $conn,
        "SELECT * FROM users WHERE user_id='$user_id'"
    );

    $user = mysqli_fetch_assoc($result);
}

// Get Loyalty Points
$point_query = mysqli_query($conn, "
SELECT points
FROM loyalty_points
WHERE user_id='$user_id'
");

if (mysqli_num_rows($point_query) > 0) {

    $point_row = mysqli_fetch_assoc($point_query);

    $points = $point_row['points'];

} else {

    $points = 0;

}

$product_query = mysqli_query($conn, "
    SELECT *
    FROM products
    LIMIT 8
");


$total_cart = 0;

if ($user_id) {

    $count_query = mysqli_query(
        $conn,
        "SELECT SUM(quantity) as total
         FROM cart
         WHERE user_id='$user_id'"
    );

    $count = mysqli_fetch_assoc($count_query);

    $total_cart = $count['total'] ?? 0;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LUVIA | Home</title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS FILE -->

    <link rel="stylesheet" href="../style.css">

</head>

<body class="home-page">

    <!-- TOP NAVBAR -->

    <header>

        <div class="top-navbar">

            <!-- Logo -->
            <div class="nav-logo d-flex align-items-center">
                <img src="../../images/logo.png" class="img-fluid rounded-circle me-2" alt="Logo"
                    style="width:60px; height:60px; object-fit:cover;">

                <div>
                    <h1 class="m-0">LUVIA</h1>
                    <small class="text-muted">Design Your Style</small>
                </div>
            </div>
            <!-- Search BAR-->
            <form id="search-form" action="../products/products.php" method="GET" class="search-bar">

                <input type="text" id="search-input" name="search" placeholder="Search for products...">

                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

            </form>

            <!-- Icons -->
            <div class="nav-icons">

                <!-- Voice Search -->
                <div class="voice-search" id="voice-search-btn">
                    <i class="fa-solid fa-microphone"></i>
                    <span>Voice Search</span>
                </div>


                <div class="cart-icon">

                    <?php if (isset($_SESSION['user_id'])) { ?>

                        <a href="../cart/cart.php" class="text-decoration-none text-dark">

                            <i class="fa-solid fa-cart-shopping"></i>

                            <span class="cart-count">
                                <?= $total_cart; ?>
                            </span>

                        </a>

                    <?php } else { ?>

                        <a href="../login/login.html" class="text-decoration-none text-dark">

                            <i class="fa-solid fa-cart-shopping"></i>

                            <span class="cart-count">
                                <?= $total_cart; ?>
                            </span>

                        </a>

                    <?php } ?>


                </div>

                <?php if (isset($_SESSION['user_id']) && $user) { ?>

                    <a href="../profile/my_profile.php" class="user-profile text-decoration-none text-dark">
                        <i class="fa-regular fa-user"></i>
                        <span>Hello<br><?= htmlspecialchars($user['full_name']); ?></span>
                    </a>

                <?php } else { ?>

                    <a href="../login/login.html" class="user-profile text-decoration-none text-dark">
                        <i class="fa-regular fa-user"></i>
                        <span>Login/Register</span>
                    </a>

                <?php } ?>


            </div>

        </div>

        <!-- MAIN NAVBAR -->

        <nav>

            <ul>
                <li><a href="../home/home.php">Home</a></li>

                <li><a href="../products/products.php">Products</a></li>

                <li><a href="../customize/customize.php">Customize</a></li>

                <li><a href="../point/loyalty_point.php">Offers</a></li>

                <li><a href="../contact/contact.php">Contact</a></li>
            </ul>

            <!-- Loyalty Points -->
            <div class="points-box">
                <i class="fa-regular fa-star"></i>
                My Points : <?php echo $points; ?>
            </div>
        </nav>

    </header>

    <!-- HERO SECTION -->

    <section class="hero-section container mt-4">

        <div class="row align-items-center">

            <!-- Left Content -->

            <div class="col-lg-12 hero-text">

                <h1>Customize Your Style <br> Make it Unique!</h1>

                <p>
                    Create your own apparel with our
                    customization tools.
                </p>

                <a href="../customize/customize.php" class="btn hero-btn">
                    Customize Now
                </a>

            </div>

        </div>

    </section>

    <!-- ALL PRODUCTS SECTION -->

    <section class="container mt-5">

        <div class="text-center mb-4">

            <h2>
                Our Products
            </h2>

            <p>
                Explore our latest fashion collection
            </p>

        </div>


        <div class="row g-4">


            <?php while ($row = mysqli_fetch_assoc($product_query)) { ?>


                <div class="col-md-3">


                    <div class="home-product-card">


                        <img src="../../images/<?php echo $row['image']; ?>" class="home-product-img">


                        <h4>
                            <?php echo $row['product_name']; ?>
                        </h4>


                        <p>
                            Rs. <?php echo $row['price']; ?>
                        </p>


                        <form action="../../php/add_to_cart.php" method="POST">

                            <input type="hidden" name="product_id" value="<?= $row['product_id']; ?>">

                            <input type="hidden" name="size" value="M">

                            <input type="hidden" name="color" value="white">


                            <button type="submit" name="add_cart" class="btn btn-dark">

                                Add To Cart

                            </button>

                        </form>

                    </div>


                </div>


            <?php } ?>


        </div>

    </section>

    <!-- FOOTER -->

    <footer class="footer mt-5">

        <h3>LUVIA</h3>

        <p>Customize your fashion with AI powered shopping</p>

    </footer>

    <script>

        const voiceBtn = document.getElementById("voice-search-btn");
        const searchInput = document.getElementById("search-input");

        const SpeechRecognition =
            window.SpeechRecognition ||
            window.webkitSpeechRecognition;

        if (SpeechRecognition) {

            const recognition = new SpeechRecognition();

            recognition.lang = "en-US";
            recognition.continuous = false;
            recognition.interimResults = false;

            voiceBtn.addEventListener("click", function () {

                recognition.start();

                voiceBtn.innerHTML =
                    '<i class="fa-solid fa-microphone"></i> Listening...';

            });

            recognition.onresult = function (event) {

                const text = event.results[0][0].transcript;

                searchInput.value = text;

                document.getElementById("search-form").submit();

            };

            recognition.onend = function () {

                voiceBtn.innerHTML =
                    '<i class="fa-solid fa-microphone"></i><span> Voice Search</span>';

            };

        }
        else {
            alert("Voice Search is not supported in this browser");
        }

    </script>

</body>

</html>