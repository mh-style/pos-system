<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Product</h4>
            <a href="products.php" class="btn btn-primary float-end">Back</a>
        </div>
        <div class="card-body">
            <?php alertMessage();

            ?>
            <form action="code.php" method="POST" enctype="multipart/form-data">
                <?php
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>Id is not an integer</h5>';
                    return false;
                }
                $product = getById('products', $paramValue);
                if ($product) {
                    if ($product['status'] == 200) {
                ?>
                        <div class="row">
                <input type="hidden" name="productId" value="<?= $product['data']['id'];?>">

                            <div class="col-md-12 mb-3">
                                <label for="">Select Category</label>
                                <select name="category_id" class="form-select" id="">
                                    <option value="">Select Category</option>
                                    <?php
                                    $categories = getAll('categories');
                                    if ($categories) {
                                        if (mysqli_num_rows($categories) > 0) {
                                            foreach ($categories as $cateItem) {
                                                ?>
                                                <option value="<?= $cateItem['id'] ?>" 
                                                <?= $product['data']['category_id'] == $cateItem['id'] ? 'selected' :''; ?>
                                                ><?= $cateItem['name'] ?></option>
                                                <?php
                                                // echo '<option value="' . $cateItem['id'] . '">' . $cateItem['name'] . '</option>';
                                            }
                                        } else {
                                            echo '<option>No Categories Found</option>';
                                        }
                                    } else {
                                        echo '<option>Something Went Wrong!</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="name">Product Name *</label>
                                <input type="text" name="name" id="name" value="<?= $product['data']['name'];?>" required class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="desc">Description</label>
                                <textarea name="description" id="desc" class="form-control"  value="<?= $product['data']['description'];?>" rows="3"></textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="price"> Price *</label>
                                <input type="text" name="price" id="price" required value="<?= $product['data']['price']; ?>" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="quantity">Quantity *</label>
                                <input type="text" name="quantity" id="quantity" value="<?= $product['data']['quantity']; ?>" required class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="image">Product Image</label>
                                <input type="file" name="image" id="image" class="form-control" >
                                <img src="../<?= $product['data']['image'];?>" style="width:50px;height:50px;" alt="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status">Status (Unchecked=Visible, Checked=Hidden)</label><br />
                                <input type="checkbox" name="status" id="status"  style="width:30px;height:30px;">
                            </div>
                            <div class="col-md-6 mb-3 text-end">
                                <button type="submit" name="updateProduct" class="btn btn-primary">Update</button>
                            </div>
                        </div>

                <?php
                    } else {
                        echo '<h5>' . $product['message'] . '</h5>';
                        return false;
                    }
                } else {
                    echo '<h5>Something Went Wrong</h5>';
                    return false;
                }
                ?>
            </form>
        </div>

    </div>
</div>

<?php include('includes/footer.php'); ?>