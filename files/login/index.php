<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css">
    <title>Document</title>
</head>
<body>
    
    <!-- Section: Design Block -->
<section class=" text-center text-lg-start">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand fw-bold" href="./">Food <span style="color: brown;">Land</span></a>
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link text-white d-flex align-items-center" id="cart-img" href="../../">
                <i class="bi bi-cart-fill fs-4"></i>
                <span class="ms-1"><strong>Home</strong></span>
              </a>
            </li>
          </ul>
        </div>
    </nav>

  <div class="card mb-3 mx-auto" style="background: rgba(255, 255, 255, 0.4) !important; backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); border: none !important; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2) !important; border-radius: 15px; margin-top: 50px; width:90%">
    <div class="row g-0 d-flex align-items-center">
      <div class="col-lg-4 d-none d-lg-flex">
        <img src="https://mdbootstrap.com/img/new/ecommerce/vertical/004.jpg" alt="Trendy Pants and Shoes"
          class="w-100 rounded-t-5 rounded-tr-lg-0 rounded-bl-lg-5" />
      </div>
      <div class="col-lg-8" id="main-div">
        <div class="card-body py-5 px-md-5">

          <form action="#" method="post">
            <p class='text-center fw-bold text-danger fs-3' id="error">error cant't find account</p>
            <div data-mdb-input-init class="form-outline mb-4">
              <input required type="number" id="form2Example1" class="form-control" name="phone" style="border: 1px solid black;" />
              <label class="form-label" for="form2Example1">Phone Number</Nav></label>
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
              <input required type="password" id="form2Example2" class="form-control" name="password" style="border: 1px solid black;"/>
              <label class="form-label" for="form2Example2">Password</label>
            </div>

            <div class="row mb-4">
              <div class="col d-flex justify-content-center">
                <a href="#!">Forgot password?</a>
              </div>
            </div>
            <input type="submit" name="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4" />
            <br>
            <span>Didn't have account?</span><a href="../signup/">click here</a>
          </form>

        </div>
      </div>
    </div>
  </div>
</section>


<script src="../bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
<script>

      let num = Math.floor(Math.random() * 10) + 1;
      document.querySelector('body').style.backgroundImage = `url(../photos/items/${num}.jpg)`
  
</script>

<?php
      function ohshit(){
        echo "<script> document.querySelector('#error').style.visibility = 'visible'; </script>";
      }
?>

</body>
</html>

<?php
  session_start();
  include("../php/connection.php");

  if(isset($_POST['submit'])){

    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $query = "SELECT * FROM people WHERE phone='$phone' AND password='$password'";

    $result = mysqli_query($connection, $query);

    $data = mysqli_fetch_assoc($result);
    //echo  $data['FirstName'];

      if(mysqli_num_rows($result) > 0){
        $_SESSION['id']="$data[session_id]";
        header('location:../php/cart_conn.php');
      }
      else{
        ohShit();
      }

}
?>