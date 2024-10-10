<?php include('includes/header.php');?>
    <div class="ve-form-body ve-admin">
        <span class="dot-1"></span>
        <span class="dot-2"></span>
    <div class="ve-container">
        <div class="header">
            <img src="./assets/images/logo.jpg" alt="Vegetables Healthy Life Logo" class="logo">
            <h1>Admin</h1>
        </div>
        <form action="login-code.php" class="ve-form" method="POST">
                <input type="email" name="email" id="email" class="ve-form-control" placeholder="User Id" required>
                <input type="password" name="password" id="password" class="ve-form-control" placeholder="Password" required>
            
            <div class="ve-buttons">
                <a href="./login-shop.php" class="ve-btn admin-btn">Shop</a>
                <button type="submit" name="loginBtn" class="ve-btn shop-btn">Sign In</button>
            </div>
        </form>
    </div>
<?php include('includes/footer.php');?>