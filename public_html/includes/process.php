<?php
include_once("../database/constants.php");
include_once("user.php");
include_once("DBOperation.php");
include_once("manage.php");

// Register
if (isset($_POST["username"]) && isset($_POST["email"])) {
    $user = new User();
    $result = $user->createUserAccount($_POST["username"], $_POST["email"], $_POST["password"], $_POST["usertype"]);
    echo $result;
    exit();
}

// Login
if (isset($_POST["login_email"]) && isset($_POST["login_password"])) {
    $user = new User();
    $result = $user->userLogin($_POST["login_email"], $_POST["login_password"]);
    echo $result;
    exit();
}

// Get Category
if (isset($_POST["getCategory"])) {
    $obj = new DBOperation();
    $rows = $obj->getAllRecords('categories');
    foreach ($rows as $row) {
        echo "<option value='{$row['cid']}'>{$row['category_name']}</option>";
    }
    exit();
}

// Get Brand
if (isset($_POST["getBrand"])) {
    $obj = new DBOperation();
    $rows = $obj->getAllRecords('brands');
    foreach ($rows as $row) {
        echo "<option value='{$row['bid']}'>{$row['brand_name']}</option>";
    }
    exit();
}

// Add Category
if (isset($_POST["category_name"])) {
    $obj = new DBOperation();
    $result = $obj->addCategory($_POST["parent_cat"], $_POST["category_name"]);
    echo $result;
    exit();
}

// Add Brand
if (isset($_POST["brand_name"])) {
    $obj = new DBOperation();
    $result = $obj->addBrand($_POST["brand_name"]);
    echo $result;
    exit();
}

// Add Product
if (isset($_POST["added_date"]) && $_POST["product_name"]) {
    $obj = new DBOperation();
    $result = $obj->addProduct(
                                $_POST["select_cat"], 
                                $_POST["select_brand"], 
                                $_POST["product_name"], 
                                $_POST["product_price"], 
                                $_POST["product_qty"], 
                                $_POST["added_date"]
                            );
    echo $result;
    exit();
}

// Manage Category
if (isset($_POST["manageCategory"])) {
    $m = new Manage();
    $result = $m->manageRecordWithPagination('categories', $_POST["page_no"]);
    $rows = $result["rows"];
    $pagination = $result["pagination"];

    if (count($rows) > 0) {
        $n = (($_POST["page_no"] - 1) * 5) + 1;
        foreach ($rows as $row) {
        ?>
        <tr>
            <th scope="row"><?php echo $n; ?></th>
            <td><?php echo $row["category"]; ?></td>
            <td><?php echo $row["parent"]; ?></td>
            <td><a href="#" class="btn btn-success btn-sm">Active</a></td>
            <td>
                <a href="#" did="<?php echo $row["cid"]; ?>" class="btn btn-danger btn-sm del_cat">Delete</a>
                <a href="#" eid="<?php echo $row["cid"]; ?>" data-toggle="modal" data-target="#update_category_modal" class="btn btn-info btn-sm edit_cat">Edit</a>
            </td>
            </tr>
        <?php
        $n++;
        }
        ?>
        <tr><td colspan="5"><?php echo $pagination; ?></td></tr>
        <?php
        exit();
    }
}

// Delete Category
if (isset($_POST["deleteCategory"])) {
    $m = new Manage();
    $result = $m->deleteRecord('categories', 'cid', $_POST["id"]);
    echo $result;
    exit();
}

// Update Category
if (isset($_POST["updateCategory"]))
{
    $m = new Manage();
    $result = $m->getSingleCategory("categories", "cid", $_POST["id"]);
    echo json_encode($result);
    exit();
}

// Update (any)
if (isset($_POST["update_category_name"])) {
    $m = new Manage();
    $cid = $_POST["update_cid"];
    $name = $_POST["update_category_name"];
    $parent_cat = $_POST["update_parent_cat"];
    $result = $m->updateRecords("categories", ["cid" => $cid], ["parent_cat" => $parent_cat, "category_name" => $name, "status" => 1]);
    echo $result;
}
