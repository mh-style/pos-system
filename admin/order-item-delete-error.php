<?php
require '../config/function.php';

$paramResult = checkParamId('index');
if(is_numeric($paramResult)){

    $indexvalue = validate($paramResult);
    if(isset($_SESSION['productItems']) && isset($_SESSION['productItemIds'])){
        unset($_SESSION['productItems'][$indexvalue]);
        unset($_SESSION['productItemIds'][$indexvalue]);
        
        redirect('orders-create.php', 'Item Removed');
    }else{
        redirect('orders-create.php', 'There is no item');
    }


}else{
    redirect('orders-create.php', 'param not numeric');
}


?>