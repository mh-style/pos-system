<?php
include('../config/function.php');


// Admin Save function
if(isset($_POST['saveAdmin'])){
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = validate($_POST['is_ban']) == true ? 1:0;
    $role = validate($_POST['role']);
    $shop_code = validate($_POST['shop_code']);

    if($name != '' && $email != '' && $password != ''){
        
        $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);  // "s" specifies that the parameter is a string
        $stmt->execute();
        $emailCheck = $stmt->get_result();

        // Check if email already exists
        if ($emailCheck && $emailCheck->num_rows > 0) {
            redirect('admins-create.php', 'Email already used by another user.');
        } else {
            // Hash the password using bcrypt
            $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert new admin using prepared statements
            $data = [
                 'name' =>	$name,
                 'email' =>	$email,
                 'password' =>	$bcrypt_password,
                 'phone' =>	$phone,
                 'role' => $role,
                 'shop_code' => $shop_code,
                 'is_ban' =>	$is_ban,
        
                              
             ];
             $result = insert('admins', $data);

            // Redirect based on the result
            if ($result) {
                redirect('admin.php', 'Admin Created Successfully.');
            } else {
                redirect('admins-create.php', 'Something went wrong!');
            }

            // Close the statement
            $stmt->close();
        }

        // Close the email check result set
        $emailCheck->close();
    }else {
        redirect('admins-create.php', 'Please fill required fields.');
    }

}


// Admin Update Function
if (isset($_POST['updateAdmin'])) {
   
    $adminId = validate($_POST['adminId']);

    // Fetch existing admin data using a secure function (assuming `getById` is already secure)
    $adminData = getById('admins', $adminId);
    if ($adminData['status'] != 200) {
        redirect('admins-edit.php?id=' . $adminId, 'Invalid admin data or missing fields.');
    }

    // Sanitize input fields
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) && $_POST['is_ban'] == true ? 1 : 0;
    $role = validate($_POST['role']);  // Fetch role from form
    $shop_code = validate($_POST['shop_code']);
    // Prepare SQL statement to check if the email is already used by another admin (excluding the current admin)
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ? AND id != ?");
    $stmt->bind_param("si", $email, $adminId);  // Bind email as string and adminId as integer
    $stmt->execute();
    $checkResult = $stmt->get_result();

    // Check if email already exists for another admin
    if ($checkResult && $checkResult->num_rows > 0) {
        redirect('admins-edit.php?id=' . $adminId, 'Email already used by another user.');
    }

    // Hash the password if it is provided, otherwise keep the existing one
    if ($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password']; // Keep the existing password
    }

    // Ensure required fields are filled
    if ($name != '' && $email != '') {
        // Prepare the update query using prepared statements
        $data = [
            'name' =>	$name,
            'email' =>	$email,
            'password' =>	$hashedPassword,
            'phone' =>	$phone,
            'is_ban' =>	$is_ban,
            'role' => $role,  // Add role
            'shop_code' => $shop_code 
            				
        ];
        $result = update('admins', $adminId , $data);

        if ($result) {
            redirect('admins-edit.php?id=' . $adminId, 'Admin updated successfully.');
        } else {
            redirect('admins-edit.php?id=' . $adminId, 'Something went wrong!');
        }

        // Close the statement
    } else {
        redirect('admins-edit.php?id=' . $adminId, 'Please fill required fields.');
    }
}


// Category Save Function
if(isset($_POST['saveCategory'])){
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1:0;


    $data = [
        'name' =>	$name,
        'description' =>	$description,
        'status' =>	$status
                        
    ];
    $result = insert('categories', $data);

    if ($result) {
        redirect('categories.php', 'Category Created Successfully.');
        
    }else{
        redirect('categories-create.php', 'Something Went Wrong!');
    }


}

// Category Update Function
if(isset($_POST['updateCategory'])){
    $categoryId = validate($_POST['categoryId']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1:0;


    $data = [
        'name' =>	$name,
        'description' =>	$description,
        'status' =>	$status
                        
    ];
    $result = update('categories',$categoryId, $data);

    if ($result) {
        redirect('categories-edit.php?id='.$categoryId, 'Category Updated Successfully.');
        
    }else{
        redirect('categories-edit.php?id='.$categoryId, 'Something Went Wrong!');
    }
}

// Product Save Function
if(isset($_POST['saveProduct'])){
    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1:0;

    if($_FILES['image']['size']>0){
        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        $filename = time().'.'.$image_ext;
        move_uploaded_file($_FILES['image']['tmp_name'],$path."/".$filename);
        $finalImage = "assets/uploads/products/".$filename;
    }else{
        $finalImage = '';
    }


    $data = [
        'category_id' =>	$category_id,
        'name' =>	$name,
        'description' =>	$description,
        'price' =>	$price,
        'quantity' =>	$quantity,
        'image' =>	$finalImage,
        'status' =>	$status		
                        
    ];
    
    $result = insert('products', $data);

    if ($result) {
        redirect('products.php', 'Product Created Successfully.');
        
    }else{
        redirect('products-create.php', 'Something Went Wrong!');
    }
}


// Product Update Function
if(isset($_POST['updateProduct'])){
    $productId = validate($_POST['productId']);
    $productData = getById('products', $productId);
    if(!$productData){
        redirect('products.php', 'No Such product found');
    }


    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1:0;

    if($_FILES['image']['size']>0){
        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        $filename = time().'.'.$image_ext;
        move_uploaded_file($_FILES['image']['tmp_name'],$path."/".$filename);
        $finalImage = "assets/uploads/products/".$filename;
        $deleteImage = "../".$productData['data']['image'];
        if(file_exists($deleteImage)){
            unlink($deleteImage);
        }
    }else{
        $finalImage = $productData['data']['image'];
    }


    $data = [
        'category_id' =>	$category_id,
        'name' =>	$name,
        'description' =>	$description,
        'price' =>	$price,
        'quantity' =>	$quantity,
        'image' =>	$finalImage,
        'status' =>	$status		
                        
    ];
    
    $result = update('products', $productId, $data);

    if ($result) {
        redirect('products-edit.php?id='.$productId, 'Product Updated Successfully.');
        
    }else{
        redirect('products-edit.php?id='.$productId, 'Something Went Wrong!');
    }
}

// Customer Save Function
if(isset($_POST['saveCustomer'])){
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = validate($_POST['status']) == true ? 1:0;

    if($name != ''){

        $emailCheck = mysqli_query($conn,"SELECT * FROM customers WHERE email ='$email'");
        if($emailCheck){
            if (mysqli_num_rows($emailCheck)>0) {
                redirect('customers.php','Email Alrady used by another user.');
            }
        }
        $data =[
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status,
        ];

        $result = insert('customers', $data);
        if ($result) {
            redirect('customers.php', 'Customer Create Successfully');
        } else {
            redirect('customers.php','Something Went Wrong!');
        }

    }else{
        redirect('customers.php','Please fill required fields');
    }
}
// Customer Update Function
if(isset($_POST['updateCustomer'])){
    $customerId = validate($_POST['customerId']);
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = validate($_POST['status']) == true ? 1:0;
    if($name != ''){

        $emailCheck = mysqli_query($conn,"SELECT * FROM customers WHERE email ='$email' AND id!='$customerId'");
        if($emailCheck){
            if (mysqli_num_rows($emailCheck)>0) {
                redirect('customers-edit.php?id='.$customerId,'Email Alrady used by another user.');
            }
        }
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status
        ];
        $result = update('customers',$customerId, $data);

        if ($result) {
            redirect('customers-edit.php?id='.$customerId, 'Customer Updated Successfully.');
            
        }else{
            redirect('customers-edit.php?id='.$customerId, 'Something Went Wrong!');
        }
    }else{
        redirect('customers-edit.php?id='.$customerId,'Please fill required fields');
    }
}

// Shop Add Function

if(isset($_POST['addShop'])){
    $name = validate($_POST['name']);
    $code = validate($_POST['code']);
    $vat_number = validate($_POST['vat_number']);

    if($name != ''){

        $codeCheck = mysqli_query($conn,"SELECT * FROM shop_list WHERE code ='$code'");
        if($codeCheck){
            if (mysqli_num_rows($codeCheck)>0) {
                redirect('shops.php','Code Alrady used by another Shop.');
            }
        }
        $data =[
            'name' => $name,
            'code' => $code,
            'vat_number' => $vat_number,
        ];

        $result = insert('shop_list', $data);
        if ($result) {
            redirect('shops.php', 'Customer Create Successfully');
        } else {
            redirect('shops.php','Something Went Wrong!');
        }

    }else{
        redirect('shops.php','Please fill required fields');
    }
}

?>