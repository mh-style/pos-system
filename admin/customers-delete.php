<?php

require '../config/function.php';

$paraRestultId = checkParamId('id');

if(is_numeric($paraRestultId)){
    $customersId  = validate($paraRestultId);
    $customer = getById('customers', $customersId);
    if($customer['status'] == 200){
        $customerDeleteRes = delete('customers', $customersId);
        if($customerDeleteRes){
            redirect('customers.php', 'Customer Deleted Successfully.');
        }else{
            redirect('customers.php', 'Something Went Wrong.');
        }

    }else{
        redirect('customers.php', $customer['message']);
    }
    
    //echo $customersId;
}else{
    redirect('customers.php', 'Something Went Wrong.');
}


?>