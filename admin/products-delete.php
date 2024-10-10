<?php

require '../config/function.php';

$paraRestultId = checkParamId('id');

if(is_numeric($paraRestultId)){
    $productsId  = validate($paraRestultId);
    $product = getById('products', $productsId);
    if($product['status'] == 200){
        $productDeleteRes = delete('products', $productsId);
        if($productDeleteRes){
            $deleteImage = "../".$product['data']['image'];
            if(file_exists($deleteImage)){
                unlink($deleteImage);
            }
            redirect('products.php', 'Product Deleted Successfully.');
        }else{
            redirect('products.php', 'Something Went Wrong.');
        }

    }else{
        redirect('products.php', $product['message']);
    }
    
    //echo $productsId;
}else{
    redirect('products.php', 'Something Went Wrong.');
}


?>