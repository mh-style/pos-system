<?php include('includes/header.php');?>


<!-- Modal -->
<div class="modal fade" id="addCustomerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Customer</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="c_name">Enter Customer Name</label>
            <input type="text" class="form-control" id="c_name" />
        </div>
        <div class="mb-3">
            <label for="c_phone">Enter Customer Phone No.</label>
            <input type="text" class="form-control" id="c_phone" />
        </div>
        <div class="mb-3">
            <label for="c_email">Enter Customer Email (optional)</label>
            <input type="text" class="form-control" id="c_email" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary saveCustomer">Save</button>
      </div>
    </div>
  </div>
</div>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Create Order</h4>
            <a href="orders.php" class="btn btn-primary float-end">Back</a>
        </div>
        <div class="card-body">
            <?php alertMessage();
            
            ?>
            <form action="order-code.php" method="POST">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="product_id">Select Product</label>
                        <select name="product_id" id="product_id" class="form-select mySelect2">
                            <option value="">---Select Product---</option>
                            <?php
                                $products = getAll('products');
                                if ($products) {
                                    if(mysqli_num_rows($products)>0){
                                        foreach($products as $prodItem){
                                            ?>
                                            <option value="<?= $prodItem['id'];?>"><?= $prodItem['name'];?></option>
                                            <?php
                                        }
                                    }else{
                                        echo '<option value="">No product found</option>';
                                    }
                                } else {
                                    echo '<option value="">Something Went Wrong</option>';
                                }
                                
                                
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" value="1" id="quantity" class="form-control">
                    </div>
                    
                    <div class="col-md-3 mb-3 text-end"><br/>
                        <button type="submit" name="addItem" class="btn btn-primary">Add Item</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h4 class="mb-0">Products</h4>
        </div>
        <div class="card-body" id="productArea">
            <?php
                if(isset($_SESSION['productItems'])){
                $sessionProducts = $_SESSION['productItems'];
                if(empty($sessionProducts)){
                    unset($_SESSION['productItems']);
                    unset($_SESSION['productItemIds']);
                }
                ?>
                <div class="table-responsive mb-3" id="productContent">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                             foreach($sessionProducts as $key => $item) : ?>
                            <tr>
                                <td><?= $i++;?></td>
                                <td><?= $item['name'];?></td>
                                <td><?= $item['price'];?></td>
                                <td>
                                    <div class="input-group qtyBox">
                                        <input type="hidden" name="" value="<?= $item['product_id'];?>" class="prodId">
                                        <button class="input-group-text decrement">-</button>
                                        <input type="text" value="<?= $item['quantity'];?>" class="qty quantityInput" />
                                        <button class="input-group-text increment">+</button>
                                    </div>
                                </td>
                                <td><?= number_format($item['price'] * $item['quantity'], 0);?></td>
                                <td>
                                    <a href="order-item-delete.php?index=<?= $key;?>" class="btn btn-danger">Remove</a>
                                </td>
                                
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>  
                <div class="mt-2">
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="payment_mode">Select Payment Mode</label>
                            <select id="payment_mode" class="form-select">
                                <option value="">---- Select Payment ----</option>
                                <option value="Cash Payment">Cash Payment</option>
                                <option value="Card Payment">Card Payment</option>
                                <option value="Online Payment">Online Payment</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="cphone">Enter Customer Phone Number</label>
                            <input type="text" name="cphone" id="cphone" class="form-control" />
                        </div>
                        <div class="col-md-4">
                            <br>
                            <button type="button" class="btn btn-warning w-100 proceedToPlace">Proceed to place orders</button>
                        </div>
                    </div>
                </div>  
                <?php }else {
                    echo '<h5>No item added</h5>';
                }
            ?>
        </div>
    </div>
    
</div>

<?php include('includes/footer.php');?>