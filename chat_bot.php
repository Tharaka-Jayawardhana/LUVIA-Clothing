<?php

session_start();

include 'db.php';


if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit();

}

$user_id = $_SESSION['user_id'];


if (isset($_POST['send'])) {

    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $msg = strtolower($message);


    // Bot replies

    if (str_contains($msg, "hi") || str_contains($msg, "hello")) {

        $reply = "Hello 😊 Welcome to LUVIA Fashion Store! How can I help you?";

    } elseif (str_contains($msg, "price")) {

        $reply = "You can check product prices from our Products page.";

    } elseif (str_contains($msg, "customize") || str_contains($msg, "customization")) {

        $reply = "You can customize T-shirts by changing color, size, adding text and images.";

    } elseif (str_contains($msg, "delivery")) {

        $reply = "Delivery takes around 3-5 working days.";

    } elseif (str_contains($msg, "order")) {

        $reply = "You can track your order from My Orders section.";

    } elseif (str_contains($msg, "payment")) {

        $reply = "We provide online payment options during checkout.";

    } elseif (str_contains($msg, "return")) {

        $reply = "You can request returns according to our return policy.";

    } elseif (str_contains($msg, "offers")) {

        $reply = "You can see your offers from my order.";

    } else {

        $reply = "Sorry 😔 I couldn't understand. Please ask about products, customization, orders or delivery.";

    }



    // Save chat to database

    mysqli_query(
        $conn,

        "INSERT INTO chatbot_messages
    (user_id,message,reply)
    VALUES
    ('$user_id','$message','$reply')"

    );


}



// Load previous chats

$chat_query = mysqli_query(
    $conn,

    "SELECT * FROM chatbot_messages
WHERE user_id='$user_id'
ORDER BY message_id ASC"

);


?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>LUVIA Chat Bot</title>


    <style>
        body {

            background: #F5F5FF;
            font-family: Poppins, Arial;

        }



        .chat-container {

            width: 380px;
            height: 550px;
            background: white;
            margin: 40px auto;
            border-radius: 20px;
            box-shadow: 0 5px 20px #ccc;
            overflow: hidden;

        }



        .chat-header {

            background: #5B3DF5;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;

        }



        .chat-body {

            height: 400px;
            padding: 15px;
            overflow-y: auto;

        }



        .bot {

            background: #5B3DF5;
            color: white;
            padding: 10px 15px;
            border-radius: 15px;
            margin: 10px 0;
            width: fit-content;

        }



        .user {

            background: #eeeeee;
            padding: 10px 15px;
            border-radius: 15px;
            margin: 10px 0;
            margin-left: auto;
            width: fit-content;

        }



        .chat-input {

            display: flex;
            padding: 10px;

        }



        .chat-input input {

            flex: 1;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ccc;

        }



        .chat-input button {

            margin-left: 10px;
            background: #5B3DF5;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;

        }
    </style>


</head>


<body>


    <div class="chat-container">


        <div class="chat-header">

            🤖 LUVIA Assistant

        </div>



        <div class="chat-body" id="chat">


            <div class="bot">

                Hello 👋 I'm LUVIA Assistant. How can I help you?

            </div>



            <?php while ($row = mysqli_fetch_assoc($chat_query)) { ?>


                <div class="user">

                    <?= htmlspecialchars($row['message']); ?>

                </div>


                <div class="bot">

                    <?= htmlspecialchars($row['reply']); ?>

                </div>


            <?php } ?>



        </div>




        <form method="POST">

            <div class="chat-input">

                <input type="text" name="message" placeholder="Type your message..." required>


                <button type="submit" name="send">
                    Send
                </button>


            </div>

        </form>


    </div>



    <script>

        // Auto scroll bottom

        let chat = document.getElementById("chat");

        chat.scrollTop = chat.scrollHeight;


    </script>



</body>

</html>