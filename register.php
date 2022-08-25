<?php include_once "includes/header.php" ?>

<!-- content part start -->
<section class="bg-light">
    <div class="row justify-content-center py-4">
       <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Register</h3>
                </div>
                <div class="card-body">
                    <form action="register.php" method="POST">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name" required>
                            <span class="text-danger"><?= get_msg("name_error") ?></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" required>
                            <span class="text-danger"><?= get_msg("email_error") ?></span>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone No</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Your Phone" required>
                            <span class="text-danger"><?= get_msg("phone_error") ?></span>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                            <span class="text-danger"><?= get_msg("password_error") ?></span>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter Password" required>
                            <span class="text-danger"><?= get_msg("confirm_password_error") ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="submit_register" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
       </div>
    </div>
</section>
<!-- content part end -->

<?php include_once "includes/footer.php" ?>
<?php

if(isset($_POST["submit_register"])) {
    $name = primary_validate($_POST["name"]);
    $email = primary_validate($_POST["email"]);
    $phone = primary_validate($_POST["phone"]);
    $password = primary_validate($_POST["password"]);
    $confirm_password = primary_validate($_POST["confirm_password"]);

    $is_error = false;
    if(strlen($name)==0){
        set_msg("name_error", "Name Reqired");
        $is_error=true;
    } else if (!preg_match ("/^[a-zA-z ]*$/", $name)) {  
        set_msg("name_error", "Only alphabets and whitespace are allowed");
        $is_error=true;
    }

    if(strlen($email)==0){
        set_msg("email_error", "Email Reqired");
        $is_error=true;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
        set_msg("email_error", "Invalid Email");
        $is_error=true;
    } else {
        $users = mysqli_query($db, "SELECT * From users WHERE email='$email'");
        if(mysqli_num_rows($users)>0) {
            set_msg("email_error", "Email already taken");
            $is_error=true; 
        }
    }

    if(strlen($phone)==0){
        set_msg("phone_error", "Phone no Reqired");
        $is_error=true;
    } else if (!preg_match ("/^[0-9]*$/", $phone)) {  
        set_msg("phone_error", "Only digits allowed");
        $is_error=true;
    }

    if(strlen($password)<6){
        set_msg("password_error", "Password need min 6 character");
        $is_error=true;
    }

    if($password!==$confirm_password){
        set_msg("confirm_password_error", "Confirm Password don't match");
        $is_error=true;
    }

    if(!$is_error) {
        $password = md5($password);
        $token = hash("sha256", rand());
        $datetime = date_create()->format('Y-m-d H:i:s');

        mysqli_query($db, "INSERT INTO users(name, email, phone, password, verify_token, is_active, created_at) VALUES ('$name', '$email', '$phone','$password', '$token', 0,'$datetime')");

        $htmlContent = '
        <html>
        <body>
            Please verify your email. <a href="'.$_SERVER['SERVER_NAME'].'/email_verify.php?=token='.$token.'">Click Here</a>
        </body>
        </html>';

        // Set content-type header for sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        mail($email,"Verify Email", $htmlContent, $headers);

        set_msg("email_msg", "Check Your Email for account activation");
        header("Location: index.php");

    } else {
        header("Location: register.php");
    }
}
