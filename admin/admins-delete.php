<?php

require '../config/function.php';

$paraRestultId = checkParamId('id');

if(is_numeric($paraRestultId)){
    $adminId  = validate($paraRestultId);
    $admin = getById('admins', $adminId);
    if($admin['status'] == 200){
        $adminDeleteRes = delete('admins', $adminId);
        if($adminDeleteRes){
            redirect('admin.php', 'Admin Deleted Successfully.');
        }else{
            redirect('admin.php', 'Something Went Wrong.');
        }

    }else{
        redirect('admin.php', $admin['message']);
    }
    
    //echo $adminId;
}else{
    redirect('admin.php', 'Something Went Wrong.');
}


?>