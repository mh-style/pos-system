<?php
require 'config/function.php';

if (isset($_POST['loginBtn'])) {
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $shop = validate($_POST['shop']);
    if ($email != ''&& $password !='' && $shop != '') { 
       // $stmt = $conn->prepare("SELECT * FROM admins WHERE email=?  LIMIT 1");
        $stmt = $conn->prepare("SELECT * FROM admins WHERE email=? AND (role=? OR shop_code=?) LIMIT 1");
        //$query = "SELECT * FROM admins WHERE email='$email' AND (role='$shop' OR shop='$shop') LIMIT 1";
        //$result = mysqli_query($conn, $query);
        $stmt->bind_param("sss", $email, $shop, $shop);
        //$stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            if($result->num_rows >0){
                $row = $result->fetch_assoc();
                $hasedPassword = $row['password'];

                if(!password_verify($password,$hasedPassword)){
                    redirect('login.php', 'Invalid Password');
                }
                if($row['is_ban']==1){
                    redirect('login.php', 'Your account has been banned. Contact Your Admin');
                }
                $_SESSION['loggedIn'] = true;
                $_SESSION['loggedInUser'] = [
                    'user_id' => $row['id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'role'  => $row['role'],
                    'shop_code'  => $row['shop_code']
                ];
                redirect('admin/index.php', 'Logged In Successfully');

            }else{
                redirect('login.php', 'Invalid Email Address');
            }
        }else{
            redirect('login.php', 'Something Went Wrong!');
        }
    }else{
        redirect('login.php', 'All fields are mandetory!');
$stmt->close();
    }

}





?>