<?php
  include("../php/connection.php");
  session_start();
   if(!isset($_SESSION['id'])){
    header('location:../../');
  }
  else{
    $query = "SELECT * FROM people WHERE session_id='{$_SESSION['id']}'";
    $result = mysqli_query($connection, $query);
    $data = mysqli_fetch_assoc($result);
  }




   
  if (isset($_POST['submit'])) {

    // Get form data
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $address = $_POST["address"];
    $pin = $_POST["pin"];
    $session_id = $_SESSION['id'];

    // Update query
    $update_query = "UPDATE people SET FirstName='$fname', LastName='$lname',  phone='$phone',  password='$password', address='$address', pincode='$pin'  WHERE session_id='$session_id'";

    // Execute query
    $submit = mysqli_query($connection, $update_query);

    // Redirect if successful
    if ($submit) {
        header('Location: ../php/cart_conn.php');
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
}

?>
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <!-- Brand Name -->
          <a class="navbar-brand fw-bold" href="../../">Food <span style="color: brown;">Land</span></a>
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link text-white" href="../../"><strong>HOME</strong></a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="#"><strong></strong></a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="#"><strong>hi <?php echo  "{$data['FirstName']}"; ?> </strong></a>
            </li>
            <li class="nav-item">
                <form action="../php/logout.php" method="post" style="display:inline;">
                  <button type="submit" class="btn btn-primary">Log Out</button>
                </form>
            </li>
          </ul>
        </div>
    </nav>

      <form action="#" method="post">
        <section class="h-100 h-custom gradient-custom-2">
            <div class="container py-5 h-100">
              <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12">
                  <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                    <div class="card-body p-0">
                      <div class="row g-0">
                        <div class="col-lg-6">
                          <div class="p-5">
                            <h3 class="fw-normal mb-5" style="color: #4835d4;">General Infomation</h3>

                            <div class="row">

                              <div class="col-md-12 mb-4 pb-2">
                                <div data-mdb-input-init class="form-outline">
                                  <input type="text" name="fname" id="form3Examplev2" class="form-control form-control-lg border-dark" value="<?php echo  "{$data['FirstName']}"; ?>"/>
                                  <label class="form-label" for="form3Examplev2">First name</label>
                                </div>
                              </div>

                              <div class="col-md-12 mb-4 pb-2">
                                <div data-mdb-input-init class="form-outline">
                                  <input type="text" name="lname" id="form3Examplev3" class="form-control form-control-lg border-dark" value="<?php echo  "{$data['LastName']}"; ?>"/>
                                  <label class="form-label" for="form3Examplev3">Last name</label>
                                </div>                       
                              </div>

                              <div class="col-md-12 mb-4 pb-2">
                                <div data-mdb-input-init class="form-outline">
                                  <input type="text" name="password" id="form3Examplev3" class="form-control form-control-lg border-dark" value="<?php echo  "{$data['password']}"; ?>"/>
                                  <label class="form-label" for="form3Examplev3">Password</label>
                                </div>                       
                              </div>
                            </div>

                        </div>
                        </div>
                        <div class="col-lg-6 bg-indigo text-white">
                          <div class="p-5">
                            <h3 class="fw-normal mb-5">Update Contact Details</h3>

                            <div class="mb-4 pb-2">
                              <div data-mdb-input-init class="form-outline form-white">
                                    <input type="text" name="address" id="form3Examplea2" class="form-control form-control-lg" value="<?php echo  "{$data['address']}"; ?>"/>
                                    <label class="form-label" for="form3Examplea2">Address</label>
                                </div>
                            </div>            
                            <div class="row">
                              <div class="col-md-10 mb-4 pb-2">

                                <div data-mdb-input-init class="form-outline form-white">
                                  <input type="text" name="pin" id="form3Examplea4" class="form-control form-control-lg" value="<?php echo  "{$data['pincode']}"; ?>"/>
                                  <label class="form-label" for="form3Examplea4">Zip Code</label>
                                </div>

                              </div>
                            </div>

                            <div class="mb-4 pb-2">
                              <div data-mdb-input-init class="form-outline form-white">
                                <input type="text" id="form3Examplea6" class="form-control form-control-lg" value="India"/>
                                <label class="form-label" for="form3Examplea6">Country</label>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-5 mb-4 pb-2">

                                <div data-mdb-input-init class="form-outline form-white">
                                  <input type="text" id="form3Examplea7" class="form-control form-control-lg" value="+91"/>
                                  <label class="form-label" for="form3Examplea7">Code +</label>
                                </div>

                              </div>
                              <div class="col-md-7 mb-4 pb-2">

                                <div data-mdb-input-init class="form-outline form-white">
                                  <input type="text" name="phone" id="form3Examplea8" class="form-control form-control-lg" value="<?php echo  "{$data['phone']}"; ?>"/>
                                  <label class="form-label" for="form3Examplea8">Phone Number</label>
                                </div>

                              </div>
                            </div>
                            <button  type="submit" name="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-success btn-lg"
                              data-mdb-ripple-color="dark">Update Details</button>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </section>
      </form>
    <script src="../bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
</body>
</html>
