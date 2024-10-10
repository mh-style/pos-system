<?php include('includes/header.php');?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Shop List</h4>
            <a href="add-shop.php" class="btn btn-primary float-end">Add Shop</a>
        </div>
        <div class="card-body">
            <?php alertMessage();?>
             <?php 
                $shopList = getAll('shop_list');
                if(!$shopList){
                    echo '<h4>Something Went Wrong!</h4>';
                    return false;
                }
                if(mysqli_num_rows($shopList) > 0){?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>VAT Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  foreach ($shopList as $item) :  ?>

                        <tr>
                            <td><?= $item['id'];?></td>
                            <td><?= $item['code'];?></td>
                            <td><?= $item['name'];?></td>
                            <td><?= $item['vat_number'];?></td>
                            
                            <td><a href="products-edit.php" class="btn btn-success btn-sm">Edit</a>
                            <a href="products-delete.php" class="btn btn-danger btn-sm"
                             onclick="return confirm('Are You sure yor want to delete this image.')">Delete</a></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <?php }else{ ?>
            <h4 class="mb-0">No Record found</h4>
            
            <?php } ?>
        </div>

    </div>
</div>

<?php include('includes/footer.php');?>