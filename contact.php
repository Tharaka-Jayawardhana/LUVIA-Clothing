<?php

session_start();

$user_id = $_SESSION['user_id'] ?? null;

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

<body class="contact-page">

    <div class="container py-5">

        <div class="text-center mb-5">
            <h2 class="fw-bold">Contact Us</h2>
            <p class="text-muted">
                We'd love to hear from you.
            </p>
        </div>

        <div class="row g-4 justify-content-center">

            <!-- Contact Info -->
            <div class="col-lg-4">

                <div class="card shadow-sm border-1 rounded-4 h-100">

                    <div class="card-body">

                        <h4 class="fw-bold mb-4">
                            Contact Information
                        </h4>

                        <p>
                            <i class="fa-solid fa-location-dot text-primary me-2"></i>
                            Colombo, Sri Lanka
                        </p>

                        <p>
                            <i class="fa-solid fa-phone text-primary me-2"></i>
                            +94 77 918 0272
                        </p>

                        <p>
                            <i class="fa-solid fa-envelope text-primary me-2"></i>
                            luviaclothing@gmail.com
                        </p>

                        <p>
                            <i class="fa-solid fa-clock text-primary me-2"></i>
                            Contact-Sat : 8.00 AM - 6.00 PM
                        </p>

                        <p>
                            <a href="#">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                            Luvia
                        </p>

                        <p>
                            <a href="#">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                            Luvia Clothing
                        </p>
                    </div>

                </div>

            </div>

            <!-- Chatbot -->
            <div class="col-lg-4" id="chatbot-section">

                <div class="card shadow-sm border-1 rounded-4 h-100">

                    <div class="card-body">

                        <div class="text-center mb-4">

                            <h4 class="fw-bold mt-3">
                                AI Chat Assistant
                            </h4>
                            <?php if (isset($_SESSION['user_id'])) { ?>

                                <a href="../../php/chat_bot.php" class="chat-icon">
                                    🤖
                                </a>

                                <h6 class="fw-bold mt-3">
                                    Chat with LUVIA Assistant
                                </h6>

                            <?php } else { ?>

                                <a href="../login/login.html" class="chat-icon">
                                    🤖
                                </a>

                                <h6 class="fw-bold mt-3">
                                    Login and continue chatting
                                </h6>

                            <?php } ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>