<?php include('includes/header.php');?>

<div class="container-fluid px-4">

    <div class="row mt-3">
        <div class="col-md-12">
            <?php alertMessage();?>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body p-3 bg-primary text-white">
                <p class="text-sm mb-0 text-capitalize">Total Category</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('categories');?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body bg-warning p-3">
                <p class="text-sm mb-0 text-capitalize">Total Products</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('products');?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body bg-info p-3 text-white">
                <p class="text-sm mb-0 text-capitalize">Total Admins</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('admins');?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body p-3">
                <p class="text-sm mb-0 text-capitalize">Total Customers</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('customers');?>
                </h5>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="row">
            <hr>
            <h5>Orders</h5>
            
            <div class="col-md-3 mb-3">
                <div class="card card-body p-3">
                    <p class="text-sm mb-0 text-capitalize">Today Orders</p>
                    <h5 class="fw-bold mb-0">
                        <?php
                            $todayDate = date('Y-m-d');
                            $todayOrders = mysqli_query($conn, "SELECT * FROM orders WHERE order_date = '$todayDate' ");
                            if($todayOrders){
                                if(mysqli_num_rows($todayOrders)>0){
                                    $totalCountOrders = mysqli_num_rows($todayOrders);
                                    echo $totalCountOrders;
                                }else{
                                    echo "0";
                                }
                            }else {
                                echo 'Something went wrong!';
                            }
                        ?>
                    </h5>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card card-body p-3">
                    <p class="text-sm mb-0 text-capitalize">Total Orders</p>
                    <h5 class="fw-bold mb-0">
                        <?= getCount('orders');?>
                        
                    </h5>
                </div>
            </div>
        </div>
        </div>
    </div>


    <!--<h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Primary Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Warning Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Success Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Danger Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>-->
</div>

<?php include('includes/footer.php');
?>
