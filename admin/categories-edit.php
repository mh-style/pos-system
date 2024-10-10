<?php include('includes/header.php');?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Category</h4>
            <a href="categories.php" class="btn btn-primary float-end">Back</a>
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
                
                $categoryData = getById('categories', $parmValue);
                    if($categoryData['status'] == 200){
                ?>
                <input type="hidden" name="categoryId" value="<?= $categoryData['data']['id'];?>">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name">Name *</label>
                        <input type="text" name="name" id="name" value="<?= $categoryData['data']['name'];?>" required class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="desc">Description</label>
                        <textarea name="description" id="desc" class="form-control" rows="3"><?= $categoryData['data']['description'];?></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status">Status (Unchecked=Visible, Checked=Hidden)</label><br/>
                        <input type="checkbox" name="status" id="status" <?= $categoryData['data']['status'] == true ? 'checked' : '';?> style="width:30px;height:30px;">
                    </div>
                    <div class="col-md-6 mb-3 text-end">
                        <button type="submit" name="updateCategory" class="btn btn-primary">Update</button>
                    </div>
                </div>
                <?php 
                        }else{
                            echo '<h5>'.$categoryData['message'].'</h5>';
                        }
                    
                ?>
            </form>
        </div>

    </div>
</div>

<?php include('includes/footer.php');?>