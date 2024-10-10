<?php include('includes/header.php');?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Customer</h4>
            <a href="customers.php" class="btn btn-primary float-end">Back</a>
        </div>
        <div class="card-body">
            <?php alertMessage();?>
            <form action="code.php" method="POST">
            <?php
                $parmValue = checkParamId('id');
                if(!is_numeric($parmValue)){
                    echo '<h5>'.$parmValue.'</h5>';
                    return false;
                }
                
                $customerData = getById('customers', $parmValue);
                    if($customerData['status'] == 200){
                ?>
                <input type="hidden" name="customerId" value="<?= $customerData['data']['id'];?>">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name">Name *</label>
                        <input type="text" name="name" id="name" value="<?= $customerData['data']['name'];?>" required class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= $customerData['data']['email'];?>" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone">Phone</label>
                        <input type="number" name="phone" id="phone" value="<?= $customerData['data']['phone'];?>" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status">Status (Unchecked=Visible, Checked=Hidden)</label><br/>
                        <input type="checkbox" name="status" id="status" <?= $customerData['data']['status'] == true ? 'checked' : '';?> style="width:30px;height:30px;">
                    </div>
                    <div class="col-md-6 mb-3 text-end">
                        <button type="submit" name="updateCustomer" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                        }else{
                            echo '<h5>'.$customerData['message'].'</h5>';
                        }
                    
                ?>
            </form>
        </div>

    </div>
</div>

<?php include('includes/footer.php');?>