<?php

include 'db.php';

if(isset($_POST['register'])){

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $address = $_POST['address'];


    $sql = "INSERT INTO users
            (full_name,email,password,phone,address)
            VALUES
            ('$full_name','$email','$password','$phone','$address')";


    if(mysqli_query($conn,$sql)){

        echo "Registration Successful";

    }else{

        echo "Error: ".mysqli_error($conn);

    }

}

?>