<?php

include("./connection.php");
session_start();


if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $url = $_POST['url'];
    echo $url;

    $insert_code = "INSERT INTO laddu (name,phone,address,url) VALUES('$name','$phone','$address','$url')";
    $submit = mysqli_query($connection, $insert_code);
    if($submit) {
         header('location:../complete/');   
         exit;
    }
}
elseif(isset($_POST['submit-s'])){
    $name = $_POST['name-s'];
    $phone = $_POST['phone-s'];
    $address = $_POST['address-s'];
    $url = $_POST['url-s'];
    
    $insert_code = "INSERT INTO laddu (name,phone,address,url) VALUES('$name','$phone','$address','$url')";
    $submit = mysqli_query($connection, $insert_code);

    if($submit) {
        $delete_code = "DELETE FROM cart WHERE session_id = '{$_SESSION['id']}'";
        $submitok = mysqli_query($connection, $delete_code);
        if($submitok){
            header('location:../complete/');
            exit;
        }
    }
    
}


?>