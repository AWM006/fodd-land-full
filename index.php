<?php
  include("./files/php/connection.php");
  session_start();

  //getting url address
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'|| $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $url_last = substr($url , -2);


  if(!isset($_SESSION['id']) && $url_last == "d/"){
   header('location:./?totalitem=0');
  }
  elseif(isset($_SESSION['id']) && $url_last == "d/"){
    header('location:./files/php/cart_conn.php');
  }
?>
<!DOCTYPE html>
<!--v1.3-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOODS</title>
    <link rel="stylesheet" href="files/style/style.css">
    <link rel="stylesheet" href="files/bootstrap-5.3.8-dist/css/bootstrap.min.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <!-- Brand Name -->
          <a class="navbar-brand fw-bold" href="./">Food <span style="color: brown;">Land</span></a>
        
          <!-- Search Bar 
          <form class="d-flex flex-grow-1 mx-2">
            <input class="form-control me-2" type="search" placeholder="Search Food Land" aria-label="Search">
            <button class="btn btn-warning" type="submit"><i class="bi bi-search"></i></button>
          </form>
          -->
          <!-- Right Side -->
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">


              <?php
                if(isset($_SESSION['id'])){
                  $query = "SELECT * FROM people WHERE session_id='{$_SESSION['id']}'";
                  $result = mysqli_query($connection, $query);
                  $data = mysqli_fetch_assoc($result);
              ?>
              <a class="nav-link text-white" href="./files/account/"><strong>hi <?php echo  "{$data['FirstName']}"; ?></strong></a>
              <?php }
              else{
              ?>
              <a class="nav-link text-white" href="./files/signup/"><strong>Signup</strong></a>
              <a class="nav-link text-white" href="./files/login/"><strong>Login</strong></a>
              <?php } ?>


            </li>
            <li class="nav-item">
              <a class="nav-link text-white d-flex align-items-center" id="cart-img" href="#">
                <i class="bi bi-cart-fill fs-4"></i>
                <span class="ms-1"><strong>Cart</strong></span>
                 <span class="badge ms-2" id="count" style="background-color: brown; color: white;">0</span>
              </a>
            </li>
          </ul>
        </div>
    </nav>
    
    <!--cart open div-->
<div class="cart-div">
    <div class="cart-title">YOUR CART</div>
    <br>

<div class="cart-item-listing"> 
</div>
    

    <div class="closeandtotal">
        <div class="total" onclick="confirmOrder()">ORDER<div class="total1" style="border: none;">0</div></div>
        <div class="close">close</div>
    </div>
</div>
<!--change menu-->
<div class="section">
    <button class="morning" onclick="daylist()">VIEW MORNING ITEMS</button>
    <button class="evening" onclick="nightlist()">VIEW EVENING ITEMS</button>
    <button class="combo" onclick="combolist()"> VIEW COMBO ITEMS</button>
</div>



    <!--item add div-->


<div class="container-fluid" id="main-container">
  <div class="row h-100" id="addItem">
    
         <!--       
        <div class="col-sm-6 col-md-4" name="dummy">
          <div class="card h-100">
            <div class="card-img-top" 
                 style="background-image:url('./files/photos/items/rgrg.jpeg'); 
                        background-size: cover; 
                        background-position: center; 
                        height: 200px;">
            </div>
            <div class="card-body text-center">
              <h5 class="card-title">dummy</h5>
              <p class="card-text">₹43434</p>
              <form action="./files/php/cart_conn.php" method="post">
                <input type="number" value="101" name="prod_id" hidden/>
                <input type="submit" name="submit" class="btn w-100" style="background-color: brown; color: white;" onclick=" addtoCart(100); popup();" value="Add to Cart" />
              </form>
            </div>
          </div>
        </div>
      -->

  </div>
</div>


<div class="go-to-cart-popup" id="goToCartPopup">
    <p>Item added to cart!</p>
    <button class="carting">Go to Cart</button>
  </div>

  <script src="files/script/script.js"></script>
  <script src="files/script/cart.js"></script>
  <script src="files/script/open.js"></script>
  <script src="files/bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
  <script>
 
  </script>

</body>
</html>