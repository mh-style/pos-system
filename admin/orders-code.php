<?php

include('../config/function.php');


if (!isset($_SESSION['productItemIds'])) {
    $_SESSION['productItemIds'] = [];
}
if (!isset($_SESSION['productItems'])) {
    $_SESSION['productItems'] = [];
}

if (isset($_POST['addItem'])) {
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId' LIMIT 1");
    if($checkProduct){
        if (mysqli_num_rows($checkProduct)>0) {
            $row = mysqli_fetch_assoc($checkProduct);
            if($row['quantity']<$quantity){
                redirect('order-create.php','Only '.$row['quantity'].' quantity available!');
            }
            $productData = [
                'product_id' => $row['id'],
                'name' => $row['name'],
                'image' => $row['image'],
                'price' => $row['price'],
                'quantity' => $quantity,
            ];
            if(!in_array($row['id'],$_SESSION['productItemIds'])){
            array_push($_SESSION['productItemIds'],$row['id']);
            array_push($_SESSION['productItems'],$productData);
            }else{
                foreach($_SESSION['productItems'] as $key => $prodSeessionItem){
                    if($prodSeessionItem['product_id'] == $row['id']){
                        $newQuantity = $prodSeessionItem['quantity'] + $quantity;
                        $productData = [
                            'product_id' => $row['id'],
                            'name' => $row['name'],
                            'image' => $row['image'],
                            'price' => $row['price'],
                            'quantity' => $newQuantity,
                        ];
                        $_SESSION['productItems'][$key] = $productData;
                    }
                }
            }
            redirect('order-create.php', 'Item Added '.$row['name']);

        } else {
            redirect('order-create.php', 'No such product found!');
        }
        
    }else{
        redirect('order-create.php', 'Something Went Wrong');
    }
}


if(isset($_POST['productIncDec'])){
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $flag = false;
    foreach($_SESSION['productItems'] as $key => $item){
        if($item['product_id'] == $productId){

            $flag = true;
            $_SESSION['productItems'][$key]['quantity'] = $quantity;
        }
    }
    if($flag){
        jsonResponse(200, 'success', 'Quantity Updated');
     }else{
        jsonResponse(200, 'success', 'Quantity Updated');
        

     }

}


if(isset($_POST['proceedToPlaceBtn'])){
    $phone = validate($_POST['cphone']);
    $payment_mode = validate($_POST['payment_mode']);

    // Checking for Customer
    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$phone' LIMIT 1");
    if($checkCustomer){
        if(mysqli_num_rows($checkCustomer)>0){
            $_SESSION['invoice_no'] = "INV-".rand(111111,999999);
            $_SESSION['cphone'] = $phone;
            $_SESSION['payment_mode'] = $payment_mode;
            jsonResponse(200, 'success', 'Customer Found');
        }
        else{
            $_SESSION['cphone'] = $phone;
            jsonResponse(404, 'warning', 'Customer Not Found');
        }
    }else{
        jsonResponse(500, 'error', 'Something Went Wrong');
    }
}

if(isset($_POST['saveCustomerBtn'])){
    $name = validate($_POST['name']);
    $phone = validate($_POST['phone']);
    $email = validate($_POST['email']);
    if ($name != '' && $phone != '') {
        $data = [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
        ];
        $result = insert('customers', $data);
        if ($result) {
            jsonResponse(200, 'success', 'Customer Created Successfully');
        }else{
            jsonResponse(500, 'error', 'Something Went Wrong');
        }
    }else{
        jsonResponse(422, 'warning', 'Please fill required fields');
    }
}

/*
if(isset($_POST['saveOrder'])){
    $phone = validate($_POST['cphone']);
    $invoice_no = $_SESSION['invoice_no'];
    $payment_mode = validate($_POST['payment_mode']);
    $order_placed_by_id = $_SESSION['loggedInUser']['user_id'];

    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$phone' LIMIT 1");

    if(!$checkCustomer){
        jsonResponse(500, 'error', 'Something Went Wrong!');
    }
    if (mysqli_num_rows($checkCustomer)> 0) {
        $customerData = mysqli_fetch_assoc($checkCustomer);
        if(!isset($_SESSION['productItems'])){
            jsonResponse(404, 'warning', 'No Items to place order!');
        }
        $sessionProducts = $_SESSION['productItems'];
        $totalAmount = 0;
        foreach($sessionProducts as $amtItem){
            $totalAmount += $amtItem['price'] * $amtItem['quantity'];
        }

        $data = [
            'customer_id' => $customerData['id'],
            'tracking_no' => rand(11111,99999),
            'invoice_no' => $invoice_no,
            'total_amount' => $totalAmount,
            'order_date' => date('d-M-Y'),
            'order_status' => 'booked',
            'payment_mode' => $payment_mode,
            'order_placed_by_id' => $order_placed_by_id
        ];
        $result = insert('orders', $data);
    }
}*/
if (isset($_POST['saveOrder'])) {
    $phone = validate($_SESSION['cphone']);
    $invoice_no = validate($_SESSION['invoice_no']);
    $payment_mode = validate($_SESSION['payment_mode']);
    $order_placed_by_id = $_SESSION['loggedInUser']['user_id'];

    // Find customer by phone number
    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone = '$phone' LIMIT 1");

    if (!$checkCustomer) {
        jsonResponse(500, 'error', 'Something went wrong!');
    }

    if (mysqli_num_rows($checkCustomer) > 0) {
        $customerData = mysqli_fetch_assoc($checkCustomer);

        // Check if there are products in the session
        if (!isset($_SESSION['productItems'])) {
            jsonResponse(404, 'warning', 'No items to place order!');
        }

        // Calculate the total amount
        $sessionProducts = $_SESSION['productItems'];
        $totalAmount = 0;
        foreach ($sessionProducts as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Insert the order into the orders table
        date_default_timezone_set('Asia/Dhaka');
        $orderDate = date('Y-m-d H:i:s');
        $orderStatus = 'booked';
        $trackingNo = rand(11111, 99999);

     
        $orderQuery = "INSERT INTO orders (customer_id, tracking_no, invoice_no, total_amount, order_date, order_status, payment_mode, order_placed_by_id) 
                       VALUES ('{$customerData['id']}', '$trackingNo', '$invoice_no', '$totalAmount', '$orderDate', '$orderStatus', '$payment_mode', '$order_placed_by_id')";

        if (mysqli_query($conn, $orderQuery)) {
            
            $orderId = mysqli_insert_id($conn);

            
            foreach ($sessionProducts as $item) {
                $product_id = $item['product_id'];
                $price = $item['price'];
                $quantity = $item['quantity'];

                $itemQuery = "INSERT INTO order_items (order_id, product_id, price, quantity) 
                VALUES ('$orderId', '$product_id', '$price', '$quantity')";

                mysqli_query($conn, $itemQuery);
                $checkProductQuantityQuery = mysqli_query($conn, "SELECT * FROM products WHERE id='$product_id'");
                $productQtyData = mysqli_fetch_assoc($checkProductQuantityQuery);
                $totalProductQuantity = $productQtyData['quantity'] - $quantity;
                

                $updateProductQty = "UPDATE products SET quantity = $totalProductQuantity WHERE id = '$product_id'";
                mysqli_query($conn, $updateProductQty);
            }
            unset($_SESSION['productItemIds']);
            unset($_SESSION['productItems']);
            unset($_SESSION['cphone']);
            unset($_SESSION['payment_mode']);
            unset($_SESSION['invoice_no']);

            jsonResponse(200, 'success', 'Order placed successfully!');
        } else {
            jsonResponse(500, 'error', 'Failed to place the order.');
        }
    } else {
        jsonResponse(404, 'warning', 'Customer not found.');
    }
}


?>