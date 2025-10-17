<?php
include("./connection.php");
session_start();

if(isset($_POST['submit'])){

    $phone = $_POST['phone'];
    $detail = $_POST['detail'];
    $insert_code = "INSERT INTO complain (phone,complain) VALUES('$phone','$detail')";
    $submit = mysqli_query($connection, $insert_code);
    if($submit){
        header('location:../complain/');   
        exit;
    }
}

?>