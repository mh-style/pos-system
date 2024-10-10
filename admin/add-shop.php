<?php include('includes/header.php');?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Admin</h4>
            <a href="admin.php" class="btn btn-primary float-end">Back</a>
        </div>
        <div class="card-body">
            <?php alertMessage();?>
            <form action="code.php" method="POST">

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name">Name *</label>
                        <input type="text" name="name" id="name" required class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="code">Code </label>
                        <input type="text" name="code" id="code"  class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="vat_number">VAT Number</label>
                        <input type="text" name="vat_number" id="vat_number" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3 text-end">
                        <button type="submit" name="addShop" class="btn btn-primary">Add Shop</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<?php include('includes/footer.php');?>