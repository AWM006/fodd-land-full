<?php
session_start();
if(isset( $_SESSION['laddu_id'])){
    include("./connection.php");
    if(isset($_POST['submit'])){
        $id = $_POST["order_id"];

        $delete_code = "DELETE FROM laddu WHERE id = '{$id}'";
        $submit = mysqli_query($connection, $delete_code);
        if(isset($submit)){
            header('location:../');
        }
    }
}
else{
    header('location:../laddu-login/');
}
?>