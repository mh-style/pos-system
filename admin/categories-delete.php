<?php

require '../config/function.php';

$paraRestultId = checkParamId('id');

if(is_numeric($paraRestultId)){
    $categoriesId  = validate($paraRestultId);
    $category = getById('categories', $categoriesId);
    if($category['status'] == 200){
        $categoryDeleteRes = delete('categories', $categoriesId);
        if($categoryDeleteRes){
            redirect('categories.php', 'category Deleted Successfully.');
        }else{
            redirect('categories.php', 'Something Went Wrong.');
        }

    }else{
        redirect('categories.php', $category['message']);
    }
    
    //echo $categoriesId;
}else{
    redirect('categories.php', 'Something Went Wrong.');
}


?>