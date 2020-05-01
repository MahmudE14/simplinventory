<?php
include_once("database/constants.php");

if (!isset($_SESSION["userid"])) {
    header("location:" . DOMAIN . "/");
}

?>

<?php include_once("templates/header.php"); ?>

<div class="container">
    <table class="table table-hover table-bordered mt-2">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Brand</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="get_brand">
            <!-- <tr>
                <th scope="row">1</th>
                <td>Electronics</td>
                <td><a href="#" class="btn btn-success btn-sm">Active</a></td>
                <td>
                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                    <a href="#" class="btn btn-info btn-sm">Edit</a>
                </td>
            </tr> -->
        </tbody>
    </table>
</div>


<?php include_once("templates/update_brand_modal.php"); ?>


<?php include_once("templates/footer.php"); ?>