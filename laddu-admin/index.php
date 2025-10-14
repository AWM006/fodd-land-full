<?php
    include('./php/connection.php');
    session_start();
    if(isset( $_SESSION['laddu_id'])){
        $query = "SELECT name, id, phone, address, url FROM laddu";
        $result = $connection->query($query);

        $orders = [];
        while($row = $result->fetch_assoc()){
            $orders[] = [  "name" => $row['name'], "id" => $row['id'], "phone" => $row['phone'], "address" => $row['address'], "url" => $row['url']  ];
        }
        
        //take url
        function getFullURL() {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'];     // e.g. localhost or example.com
            $uri  = $_SERVER['REQUEST_URI'];   // e.g. /dashboard/food-land/laddu-admin/index.php?id=2

            return $protocol . $host . $uri;
        }

    }
    else{
        header('location:./laddu-login/');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo getFullURL(); ?>/bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo getFullURL(); ?>/style/style.css">
    <title>Document</title>
</head>
    
<body class="bg-light">

    <div class="container py-5">
        <h2 class="mb-4">All Orders</h2>

        <div id="carting-div">
                <!-- Example order card 
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Order #1</h5>
                        <p class="mb-2"><strong>Name:</strong> yo is my name</p>
                        <p class="mb-2"><strong>Phone:</strong> 9876543210</p>
                        <p class="mb-2"><strong>Address:</strong> 123, Some Street, City</p>

                        <label for="items1" class="form-label"><strong>Items</strong></label>
                        <textarea id="items1" class="form-control" rows="1" readonly>
                            Item 1 - 2 Item 2 - 5
                            Item 3 - 1
                        </textarea>
                        <p class="mb-2"><strong>Total Price = ₹1000</strong></p>
                        <form action="./php/orderDone.php" method="POST" class="mt-3">
                            <input type="hidden" name="order_id" value="1">
                            <button type="submit" class="btn btn-success">Delivered</button>
                        </form>
                    </div>
                </div>
                -->

                
                
    </div>

    <script>
        document.querySelectorAll('textarea').forEach(textarea => {
            textarea.style.height = "auto";
            textarea.style.height = (textarea.scrollHeight) + "px";
        });
        const orders = <?php echo json_encode($orders); ?>;
    </script>
    <script src="<?php echo getFullURL(); ?>/bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
    <script src="<?php echo getFullURL(); ?>/script/script.js"></script>
    
</body>
</html>