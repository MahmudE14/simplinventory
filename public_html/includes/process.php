<?php
include_once("../database/constants.php");
include_once("user.php");
include_once("DBOperation.php");

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