<?php
include('connection.php');

session_start();

if(isset($_SESSION['id']) ){

    $cart = isset($_POST["cart"]) ? $_POST["cart"] : null;
    $popup = isset($_POST["popup"]) ? $_POST["popup"] : null;

    if(isset($_POST['submit'])){
        $food_id = $_POST["prod_id"];
        $session_id = $_SESSION['id'];

        $insert_code = "INSERT INTO cart (session_id, item) VALUES ('$session_id', '$food_id')";
        $submit = mysqli_query($connection, $insert_code);
    }

    $query = "SELECT item FROM cart WHERE session_id = '{$_SESSION['id']}'";
    $result = mysqli_query($connection, $query);
    $items = [];
    while($row = mysqli_fetch_assoc($result)){
        $food_id = $row['item'];
        if(isset($items[$food_id])){
            $items[$food_id] += 1;
        } else {
            $items[$food_id] = 1;
        }
    }

    $url = "../../?";
    $total_type = 0;
    $params = [];

    foreach($items as $food_id => $qty){
        $params[] = "id$total_type=$food_id&quan$total_type=$qty";
        $total_type = $total_type + 1;
    }
    if($popup !== null && $cart === null){
         $url .=  "popup=open&cart=&totalitem=".$total_type."&";
     }
    elseif($cart !== null){
        $url .=  "popup=&cart=open&totalitem=".$total_type."&";
    }
    else{
        $url .=  "popup=&cart=&totalitem=".$total_type."&";
    }
    
    $url .= implode("&", $params);

    echo $url;
    header("location: $url"); 
    
}
else{

    if(isset($_POST['submit'])){

        $food_id = $_POST["prod_id"];
        $url = $_POST["url"];
        $cart = isset($_POST["cart"]) ? $_POST["cart"] : null;
        $popup = isset($_POST["popup"]) ? $_POST["popup"] : null;
        //echo $food_id;
        //echo $url;

        $parsed_url = parse_url($url);
        parse_str($parsed_url['query'], $query);

        $total_type = (int)$query['totalitem'];
        $items = [];

    
        for ($i = 0; $i < $total_type; $i++) {
            $id = $query["id$i"];
            $quan = $query["quan$i"];
            $items[$id] = $quan;
        }

    
        if(isset($items[$food_id])){
            $items[$food_id]++; 
        } else {
            $items[$food_id] = 1; 
        }

    
        $params = [];
        $i = 0;
        foreach($items as $id => $qty){
            $params[] = "id$i=$id&quan$i=$qty";
            $i++;
        }
        $port = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';

if($popup !== null && $cart === null){
    $new_url = $parsed_url['scheme'] . "://" . $parsed_url['host'] . $port . $parsed_url['path'] .
               "?popup=open&cart=&totalitem=" . count($items) . "&" . implode("&", $params);
}
elseif($cart !== null && $popup === null){
    $new_url = $parsed_url['scheme'] . "://" . $parsed_url['host'] . $port . $parsed_url['path'] .
               "?popup=&cart=open&totalitem=" . count($items) . "&" . implode("&", $params);
}
else{
    $new_url = $parsed_url['scheme'] . "://" . $parsed_url['host'] . $port . $parsed_url['path'] .
               "?popup=&cart=&totalitem=" . count($items) . "&" . implode("&", $params);
}

        echo $new_url;

        header("Location: $new_url");
        exit;
    }
}

?>