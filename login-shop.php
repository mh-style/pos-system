<?php include('includes/header.php');?>
    <div class="ve-form-body ve-admin">
        <span class="dot-1"></span>
        <span class="dot-2"></span>
    <div class="ve-container">
        <div class="header">
            <img src="./assets/images/logo.jpg" alt="Vegetables Healthy Life Logo" class="logo">
            <h1>Shop</h1>
        </div>
        <form action="login-code.php" class="ve-form" method="POST">
            <div class="ve-form-select">
                <div class="select-selected">Choose Your Shop</div>
                <ul class="select-items select-hide">
                    <li value="shop1">Shop One</li>
                    <li value="shop2">Shop Two</li>
                    <li value="shop3">Shop Three</li>
                </ul>
                <input type="hidden" id="car" name="car"> 
            </div>
            <input type="email" name="email" id="email" class="ve-form-control" placeholder="User Id" required>
            <input type="password" name="password" id="password" class="ve-form-control" placeholder="Password" required>
            
            <div class="ve-buttons">
                <a href="./login-admin.php" class="ve-btn admin-btn">Admin</a>
                <button type="submit" name="loginBtn" class="ve-btn shop-btn">Sign In</button>
            </div>
        </form>
    </div>
    <script>
    // Script to handle custom select dropdown behavior
    document.querySelector(".select-selected").addEventListener("click", function() {
      this.nextElementSibling.classList.toggle("select-hide");
    });

    document.querySelectorAll(".select-items li").forEach(item => {
      item.addEventListener("click", function() {
        document.querySelector(".select-selected").textContent = this.textContent;
        document.getElementById("car").value = this.textContent; // Update hidden input with selected value
        document.querySelector(".select-items").classList.add("select-hide");
      });
    });
  </script>
<?php include('includes/footer.php');?>