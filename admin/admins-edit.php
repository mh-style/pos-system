<?php include('includes/header.php');?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Admin</h4>
            <a href="admin.php" class="btn btn-danger float-end">Back</a>
        </div>
        <div class="card-body">
            <?php alertMessage();?>
            <form action="code.php" method="POST">
                <?php
                    if(isset($_GET['id'])){
                        if($_GET['id'] != ''){
                            $adminId = $_GET['id'];
                        }else{
                            echo '<h5>No Id Found</h5>';
                            return false;
                        }
                    }else{
                        echo '<h5>No Id given in params</h5>';
                        return false;
                    }
                    $adminData = getById('admins', $adminId);
                    if ($adminData) {
                        if($adminData['status'] == 200){
                            ?>
                <input type="hidden" name="adminId" value="<?= $adminData['data']['id'];?>">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name">Name *</label>
                        <input type="text" name="name" id="name" required value="<?= $adminData['data']['name'];?>" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email">Email *</label>
                        <input type="email" name="email" id="email" required value="<?= $adminData['data']['email'];?>" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password">Password *</label>
                        <input type="password" name="password" id="password"  class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone">Phone</label>
                        <input type="number" name="phone" id="phone" value="<?= $adminData['data']['phone'];?>" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone">Shop List</label>
                        <select name="shop_code" id="shop_code" class="form-select mySelect2">
                            <option value="">-- Select Product --</option>
                            <?php
                                $shopList = getAll('shop_list');
                                if($shopList){
                                    if(mysqli_num_rows($shopList)>0){
                                        foreach($shopList as $shop){?>
                                            <option value="<?= $shop['code'];?>" <?= $adminData['data']['shop_code'] == $shop['code'] ? 'selected': '';?>><?= $shop['name'];?></option>
                                        <?php }
                                    }else {
                                        echo '<option value="">No Shop found</option>';
                                        
                                    }
                                }else{
                                    echo '<option value="">Something went wrong</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="">Role</label><br/>
                        <input type="radio" name="role" value="0" id="admin" <?= $adminData['data']['role'] == 0 ? 'checked' : ''; ?> style="width:30px;height:30px;">
                        <label for="admin">Admin</label><br>
                        <input type="radio" name="role" value="1" id="manager" <?= $adminData['data']['role'] == 1 ? 'checked' : ''; ?> style="width:30px;height:30px;">
                        <label for="manager">Manager</label><br>
                        <input type="radio" name="role" value="2" id="shop_owner" <?= $adminData['data']['role'] == 2 ? 'checked' : ''; ?> style="width:30px;height:30px;">
                        <label for="shop_owner">Shop Owner</label><br>
                        <input type="radio" name="role" value="3" id="employee" <?= $adminData['data']['role'] == 3 ? 'checked' : ''; ?> style="width:30px;height:30px;">
                        <label for="employee">Employee</label><br>
                        <input type="radio" name="role" value="4" id="shop_employee" <?= $adminData['data']['role'] == 4 ? 'checked' : ''; ?> style="width:30px;height:30px;">
                        <label for="shop_employee">Shop Employee</label><br>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="is_ban">Is Ban</label><br/>
                        <input type="checkbox" name="is_ban" id="is_ban" <?= $adminData['data']['is_ban'] == true ? 'checked' : ''; ?> style="width:30px;height:30px;">
                    </div>
                    <div class="col-md-3 mb-3 text-end">
                        <button type="submit" name="updateAdmin" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                        }else{
                            echo '<h5>'.$adminData['message'].'</h5>';
                        }
                    }else{
                        echo '<h5>Something Went Wrong!</h5>';
                        return false;
                    }
                ?>
            </form>
        </div>

    </div>
</div>

<?php include('includes/footer.php');?>