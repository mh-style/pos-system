<?php include('includes/header.php');?>
    <div class="ve-form-body ve-admin">
      
        <span class="dot-1"></span>
        <span class="dot-2"></span>
    <div class="ve-container">
    <?php alertMessage();?>
        <div class="header">
            <img src="./assets/images/logo.jpg" alt="Vegetables Healthy Life Logo" class="logo">
            <h1>Buraydah</h1>
            <p>Vegetable Super Shop</p>
        </div>
        <form action="login-code.php" class="ve-form" method="POST">
        
            <div class="ve-form-select">
              <div class="select-selected">Choose Your Shop</div>
                <ul class="select-items select-hide">
                    <li data-value="0">Admin</li>
                    <?php
                        $shopList = getAll('shop_list');
                        if($shopList){
                            if(mysqli_num_rows($shopList)>0){
                                foreach($shopList as $shop){?>
                                    <li data-value="<?= $shop['code'];?>"><?= $shop['name'];?></li>
                                <?php }
                            }else {
                                echo '<li value="">No Shop found</li>';
                                
                            }
                        }else{
                            echo '<li value="">Something went wrong</li>';
                        }
                    ?>
                </ul>
                <input type="hidden" id="shop" name="shop"> 
            </div>
            <input type="email" name="email" id="email" class="ve-form-control" placeholder="User Id" required>
            <input type="password" name="password" id="password" class="ve-form-control" placeholder="Password" required>
            
            <div class="ve-buttons">
                <button type="submit" name="loginBtn" class="ve-btn shop-btn">Sign In</button>
            </div>
        </form>
    </div>
    <script>
    // Script to handle custom select dropdown behavior
    document.querySelector(".select-selected").addEventListener("click", function() {
      this.nextElementSibling.classList.toggle("select-hide");
    });
    let selecterItem = document.querySelectorAll(".select-items li");
    selecterItem.forEach(item => {
      item.addEventListener("click", function() {
        document.querySelector(".select-selected").textContent = this.textContent;
        document.querySelector("#shop").value = this.getAttribute("data-value"); // Update hidden input with selected value
        document.querySelector(".select-items").classList.add("select-hide");
        console.log(document.querySelector("#shop").value);
      });
    });
  </script>
    </div>
<?php include('includes/footer.php');?>