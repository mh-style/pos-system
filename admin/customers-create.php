<?php include('includes/header.php');?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Customer</h4>
            <a href="customers.php" class="btn btn-primary float-end">Back</a>
        </div>
        <div class="card-body">
            <?php alertMessage();
            
            ?>
            <form action="code.php" method="POST">

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name">Name *</label>
                        <input type="text" name="name" id="name" required class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="phone">Phone</label>
                        <input type="number" name="phone" id="phone" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status">Status (Unchecked=Visible, Checked=Hidden)</label><br/>
                        <input type="checkbox" name="status" id="status" style="width:30px;height:30px;">
                    </div>
                    <div class="col-md-6 mb-3 text-end">
                        <button type="submit" name="saveCustomer" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

<?php include('includes/footer.php');?>