<?php include_once "includes/header.php" ?>

<!-- content part start -->
<section class="bg-light">
   <?php
        if(isset($_GET["token"])) {
            $token = primary_validate($_GET["token"]);
            $user = mysqli_query($db, "SELECT * From users WHERE token='$token'");
            if(mysqli_num_rows($user)==0) {
                echo '<h3 class="text-danger">Invalid Token</h3>';
            } else {
                $user = mysqli_fetch_assoc($user);
                $email=$user["email"];
                $datetime = date_create()->format('Y-m-d H:i:s');
                $update_query = mysqli_query($db, "UPDATE users SET  verify_token=null, is_active=1 ,updated_at= '$datetime' WHERE email='$email'");

                echo '<h3 class="text-success">Account Activated</h3>';
            }
        }
   ?>
</section>
<!-- content part end -->

<?php include_once "includes/footer.php" ?>
