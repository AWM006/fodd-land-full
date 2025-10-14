<?php

session_start();
include('connection.php');

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $password = $_POST['password'];
    $session_id = bin2hex(random_bytes(32));
    
    if($id === "laddu" && $password === "laddu@foodland"){
        $_SESSION['laddu_id']=$session_id;
        header('location:../');
    }
    else{
        header('location:../laddu-login/');
    }
}

?>