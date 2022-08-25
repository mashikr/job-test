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
                    Name: <?= $user["name"] ?> <br>
                    Email: <?= $user["email"] ?> <br>
                    Phone: <?= $user["phone"] ?>
                </div>
                <div class="card-footer">
                    <a class="btn btn-primary" href="profile_edit.php">Edit Profile</a>
                </div>
            </div>
            <div class="text-center text-success">
                <h5><?= get_msg("update_msg") ?></h5>
            </div>
       </div>
    </div>
</section>
<!-- content part end -->

<?php include_once "includes/footer.php" ?>
