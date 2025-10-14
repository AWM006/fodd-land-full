<?php
  include("../php/connection.php");
  session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          
          <a class="navbar-brand fw-bold">Food <span style="color: brown;">Land</span></a>
        
          <ul class="navbar-nav mb-2 mb-lg-0">

            <?php
                if(isset($_SESSION['id'])){
                  $query = "SELECT * FROM people WHERE session_id='{$_SESSION['id']}'";
                  $result = mysqli_query($connection, $query);
                  $data = mysqli_fetch_assoc($result);
            ?>
            <li class="nav-item">
              <a class="nav-link text-white"href="../account/"><strong>Order as <?php echo "{$data['FirstName']}"; ?></strong></a>
            </li>

            <?php } ?> 


            <li class="nav-item">
              <a class="nav-link text-white" id="home"><strong>Home</strong></a>
            </li>
          </ul>
        </div>
    </nav>


    <div class="container my-4">
        <h2 class="mb-4">Your Cart</h2>
        <div class="row fw-bold border-bottom pb-2 mb-2">
          <div class="col-2">Product Image</div>
          <div class="col-3">Product Name</div>
          <div class="col-2">Quantity</div>
          <div class="col-2">Unit Price</div>
          <div class="col-3">Total</div>
        </div>
    
    <div class="row align-items-center mb-3" id="items-lister">
    <!-- items added there hehe-->
    </div>

  <!-- Cart Total -->
  <div class="row border-top pt-3 fw-bold">
    <div class="col-9 text-end">Grand Total:</div>
    <div class="col-3" id="total-price">₹0</div>




    <?php
        if(isset($_SESSION['id'])){
    ?>

          <form action="../php/order.php" method="post">
            <hr class="border border-dark border-3">
            <div class="form-group">
              <label for="exampleFormControlInput1">Name</label>
              <input required type="text" name="name-s" class="form-control border-dark border-1" id="exampleFormControlInput1" value="<?php echo "{$data['FirstName']} {$data['LastName']}";  ?>">
            </div>
            <div class="form-group">
              <label for="exampleFormControlInput1">Phone</label>
              <input required type="tel" minlength="10"  maxlength="10" pattern="[0-9]{10}" name="phone-s" class="form-control border-dark border-1" id="exampleFormControlInput1" value="<?php echo "{$data['phone']}";  ?>">
              <input hidden name="url-s" type="text" class="form-control border-dark border-1" id="urlvalue">
            </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Address</label>
              <textarea required name="address-s" type="text" class="form-control border-dark border-1" id="exampleFormControlTextarea1" rows="3"><?php echo "{$data['address']}"; ?></textarea>
            </div>
            <br>
            <button type="submit" name="submit-s" class="btn btn-danger btn-lg w-100" id="place-order" onclick="">Place Order</button>
          </form>

    <?php              
        }
        else{
    ?>

          <form action="../php/order.php" method="post">
              <hr class="border border-dark border-3">
              <div class="form-group">
                <label for="exampleFormControlInput1">Name</label>
                <input required type="text" name="name" class="form-control border-dark border-1" id="exampleFormControlInput1">
              </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">Phone</label>
                <input required type="tel" minlength="10"  maxlength="10" pattern="[0-9]{10}" name="phone" class="form-control border-dark border-1" id="exampleFormControlInput1">
                <input hidden name="url" type="text" class="form-control border-dark border-1" id="urlvalue">
              </div>
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Address</label>
                <textarea required name="address" type="text" class="form-control border-dark border-1" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>
              <br>
              <button type="submit" name="submit" class="btn btn-danger btn-lg w-100" id="place-order" onclick="">Place Order</button>
          </form>
    <?php } ?>

    
    <br>
  </div>
    

    <script src="./script.js"></script>
    <script src="../bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
    <script>
      
    </script>
</body>
</html>