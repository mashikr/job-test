<?php include_once "includes/header.php" ?>
<?php 
if(!isset($_SESSION["user_name"])) {
    header("Location: login.php");
} 
?>
<!-- content part start -->
<section class="bg-light">
    <div class="display-4 text-center my-4">
        Hello, <?= $_SESSION["user_name"] ?>
    </div>
</section>
<!-- content part end -->

<?php include_once "includes/footer.php" ?>
