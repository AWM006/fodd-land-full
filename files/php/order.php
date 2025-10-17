<?php
include("./connection.php");
session_start();

if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $url = $_POST['url'];
}
elseif(isset($_POST['submit-s'])){
              $name = $_POST['name-s'];
              $phone = $_POST['phone-s'];
              $address = $_POST['address-s'];
              $url = $_POST['url-s'];
}

$customerId = 'C-009E3ADFA76C43E';
$key        = 'UHJpdGFtQDEyMzQ=';
$scope      = 'NEW';
$mobileNumber = $phone;

$successMessage = '';
$errorMessage = '';

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OTP Verification</title>

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    input[type=tel] {
      text-align: center; 
      letter-spacing: 8px;
      font-size: 24px;
      width: 150px;
      border: 2px solid #0d6efd;
      border-radius: 8px;
      padding: 8px;
    }

    .otp_input {
      text-align: center; 
      margin-top: 20px;
    }

    .submit_btn {
      width: 100%;
    }
  </style>
</head>
<body>
  <section class="wrapper py-5">
    <div class="container">
      <div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xl-6 offset-xl-3 text-center">
        <form class="rounded bg-white shadow p-5" method="post">
          <h3 class="text-dark fw-bolder fs-4 mb-2">Two Step Verification</h3>

          <div class="fw-normal text-muted mb-4">
            Enter the code we sent to <?php echo $phone ?>
          </div>  
          <?php if ($errorMessage): ?>
            <h3 style="color:red;"><?= $errorMessage ?></h3>
          <?php endif; ?>
          <div class="otp_input">
            <label class="mb-2 fw-semibold">Type your 4-digit security code</label>
            <div class="d-flex justify-content-center">
              <input type="tel" pattern="[0-9]*" minlength="4" maxlength="4" name="otp_code" placeholder="OTP" required>
              <input type="text" value="<?php echo $name ?>" name="<?php if(isset($_POST['submit'])){echo "name";}else{echo "name-s";}  ?>" hidden>
              <input type="tel" value="<?php echo $phone ?>" name="<?php if(isset($_POST['submit'])){echo "phone";}else{echo "phone-s";}  ?>" hidden>
              <input type="text" value="<?php echo $address ?>" name="<?php if(isset($_POST['submit'])){echo "address";}else{echo "address-s";}  ?>" hidden>
              <input type="text" value="<?php echo $url ?>" name="<?php if(isset($_POST['submit'])){echo "url";}else{echo "url-s";}  ?>"  hidden>
            </div> 
          </div>  

          <button type="submit" name="<?php if(isset($_POST['submit'])){echo "submit";}else{echo "submit-s";}  ?>" class="btn btn-primary submit_btn my-4">Submit OTP</button> 

          <div class="fw-normal text-muted mb-2">
            Didn’t get the code? 
            <a href="<?php echo "../odering/".$url ?>" class="text-primary fw-bold text-decoration-none">Resend</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</body>
</html>



<?php

// Step 1: Fetch auth token
$authUrl = sprintf(
    'https://cpaas.messagecentral.com/auth/v1/authentication/token?customerId=%s&key=%s&scope=%s',
    urlencode($customerId),
    urlencode($key),
    urlencode($scope)
);

$ch = curl_init($authUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
$authResponse = curl_exec($ch);
if ($authResponse === false) die("Auth cURL error: " . curl_error($ch));
curl_close($ch);

$authData = json_decode($authResponse, true);
$token = $authData['token'] ?? null;
if (!$token) die("Token not found.");





// Step 2: Send OTP
$sendUrl = sprintf(
    'https://cpaas.messagecentral.com/verification/v3/send?countryCode=91&flowType=SMS&mobileNumber=%s',
    urlencode($mobileNumber)
);

$ch2 = curl_init($sendUrl);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_POST, true);
curl_setopt($ch2, CURLOPT_HTTPHEADER, [
    'authToken: ' . $token,
    'Accept: application/json',
]);
$otpResponse = curl_exec($ch2);
if ($otpResponse === false) die("OTP cURL error: " . curl_error($ch2));
curl_close($ch2);

$otpData = json_decode($otpResponse, true);
$verificationId = $otpData['data']['verificationId'] ?? null;
if (!$verificationId) die("Verification ID not found.");





// Step 3: Handle OTP submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['otp_code'])) {
    $code = $_POST['otp_code'];

    $validateUrl = sprintf(
        'https://cpaas.messagecentral.com/verification/v3/validateOtp?verificationId=%s&code=%s',
        urlencode($verificationId),
        urlencode($code)
    );

    $ch3 = curl_init($validateUrl);
    curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch3, CURLOPT_HTTPHEADER, [
        'authToken: ' . $token,
        'Accept: application/json',
    ]);
    $validateResponse = curl_exec($ch3);
    if ($validateResponse === false) die("Validation cURL error: " . curl_error($ch3));
    curl_close($ch3);

    // Save validation response
    file_put_contents(__DIR__ . '/validate_response.json', $validateResponse);

    $validateData = json_decode($validateResponse, true);
    $status = $validateData['data']['verificationStatus'] ?? '';

    if ($status === 'VERIFICATION_COMPLETED') {
        if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $url = $_POST['url'];
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
  } else {
        $errorMessage = "OTP Verification Failed. Please try again.";
    }
}

?>






