<?php include_once "includes/header.php" ?>

<!-- content part start -->
<section class="bg-light">
    <div class="row justify-content-center py-4">
       <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Login</h3>
                </div>
                <div class="card-body">
                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" required>
                            
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                            <span class="text-danger"><?= get_msg("password_error") ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="submit_login" value="Submit">
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <span class="text-danger"><?= get_msg("cred_msg") ?></span>
                </div>
            </div>
       </div>
    </div>
</section>
<!-- content part end -->

<?php include_once "includes/footer.php" ?>
<?php

if(isset($_POST["submit_login"])) {
    $email = primary_validate($_POST["email"]);
    $password = primary_validate($_POST["password"]);

    $is_error = false;

    if(strlen($email)==0){
        set_msg("email_error", "Email Reqired");
        $is_error=true;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
        set_msg("email_error", "Invalid Email");
        $is_error=true;
    }

    if(strlen($password)<6){
        set_msg("password_error", "Password need min 6 character");
        $is_error=true;
    }

    if(!$is_error) {
       
        $user = mysqli_query($db, "SELECT * From users WHERE email='$email' AND is_active=1");
        if(mysqli_num_rows($user)==1) {
            $user = mysqli_fetch_assoc($user);
            $password = md5($password);

            if($password==$user["password"]) {
                $_SESSION['user_name'] = $user["name"];
                $_SESSION['user_email'] = $user["email"];

                header("Location: home.php");
            } else {
                set_msg("cred_msg","Wrong Credential!");
                header("Location: login.php");
            }
        } else {
            set_msg("cred_msg","Wrong Credential!");
            header("Location: login.php");
        }

    } else {
        header("Location: login.php");
    }
}
