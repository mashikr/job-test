<?php include_once "includes/header.php" ?>
<?php 
if(!isset($_SESSION["user_name"])) {
    header("Location: login.php");
}
$user = mysqli_query($db, "SELECT * From users WHERE email='". $_SESSION["user_email"] ."' AND is_active=1");
$user = mysqli_fetch_assoc($user);
?>
<!-- content part start -->
<section class="bg-light">
<div class="row justify-content-center py-4">
       <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Profile</h3>
                </div>
                <div class="card-body">
                    <form action="profile_edit.php" method="POST">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name" required value="<?= $user["name"] ?>">
                            <span class="text-danger"><?= get_msg("name_error") ?></span>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone No</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Your Phone" required value="<?= $user["phone"] ?>">
                            <span class="text-danger"><?= get_msg("phone_error") ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="submit_profile_edit" value="Submit">
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

if(isset($_POST["submit_profile_edit"])) {
    $name = primary_validate($_POST["name"]);
    $phone = primary_validate($_POST["phone"]);
    $email = $_SESSION["user_email"];

    $is_error = false;
    if(strlen($name)==0){
        set_msg("name_error", "Name Reqired");
        $is_error=true;
    } else if (!preg_match ("/^[a-zA-z ]*$/", $name)) {  
        set_msg("name_error", "Only alphabets and whitespace are allowed");
        $is_error=true;
    }

    if(strlen($phone)==0){
        set_msg("phone_error", "Phone no Reqired");
        $is_error=true;
    } else if (!preg_match ("/^[0-9]*$/", $phone)) {  
        set_msg("phone_error", "Only digits allowed");
        $is_error=true;
    }

    if(!$is_error) {
        mysqli_query($db, "UPDATE users SET name='$name' ,phone='$phone' WHERE email='$email'");
        $_SESSION["user_name"]=$name;

        set_msg("update_msg", "Your Profile is Updated");
        header("Location: profile.php");

    } else {
        header("Location: profile_edit.php");
    }
}
