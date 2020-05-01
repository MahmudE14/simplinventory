<?php
include_once("database/constants.php");

if (!isset($_SESSION["userid"])) {
    header("location:" . DOMAIN . "/");
}

?>

<?php include_once("templates/header.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card mx-auto">
                <img src="images/login.png" style="width: 60%;" class="card-img-top mx-auto" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Profile Info.</h5>
                    <p class="card-text"><i class="fa fa-user">&nbsp;</i>Usama Mahmud</p>
                    <p class="card-text"><i class="fa fa-user">&nbsp;</i>Admin</p>
                    <p class="card-text"><i class="fa fa-user">&nbsp;</i>Last login: xxxx</p>
                    <a href="#" class="btn btn-primary"><i class="fa fa-user">&nbsp;</i>Edit Profile</a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="jumbotron" style="width: 100%; height: 100%;">
                <h1>Welcome Admin</h1>
                <div class="row">
                    <div class="col-sm-6">
                        <!--  -->
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">New Orders</h4>
                                <p class="card-text">Here you can create new orders.</p>
                                <a href="#" class="btn btn-primary">New Orders</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Categories</h4>
                    <p class="card-text">You can manage your categories here.</p>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#category_modal">Add</a>
                    <a href="manage_categories.php" class="btn btn-primary">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Brands</h4>
                    <p class="card-text">You can manage your brands here.</p>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#brand_modal">Add</a>
                    <a href="manage_brand.php" class="btn btn-primary">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Products</h4>
                    <p class="card-text">You can manage your products here.</p>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#product_modal">Add</a>
                    <a href="#" class="btn btn-primary">Manage</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php 
    include_once("templates/brand_modal.php"); 
    include_once("templates/category_modal.php"); 
    include_once("templates/product_modal.php"); 
?>

<?php include_once("templates/footer.php"); ?>