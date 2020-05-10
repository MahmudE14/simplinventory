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
if (isset($_POST["added_date"]) && isset($_POST["product_name"])) {
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

/**
 * = = = = = = = = = = = = = = = = = = = 
 * CATEGORY
 * = = = = = = = = = = = = = = = = = = = 
 */
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
        <tr>
            <td colspan="5"><?php echo $pagination; ?></td>
        </tr>
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

// Get single for Update Category
if (isset($_POST["updateCategory"])) {
    $m = new Manage();
    $result = $m->getSingleCategory("categories", "cid", $_POST["id"]);
    echo json_encode($result);
    exit();
}

// Update Category
if (isset($_POST["update_category_name"])) {
    $m = new Manage();
    $cid = $_POST["update_cid"];
    $name = $_POST["update_category_name"];
    $parent_cat = $_POST["update_parent_cat"];
    $result = $m->updateRecords("categories", ["cid" => $cid], ["parent_cat" => $parent_cat, "category_name" => $name, "status" => 1]);
    echo $result;
    exit();
}

/**
 * = = = = = = = = = = = = = = = = = = = 
 * Brand
 * = = = = = = = = = = = = = = = = = = = 
 */
// Manage Brand
if (isset($_POST["manageBrand"])) {
    $m = new Manage();
    $result = $m->manageRecordWithPagination('brands', $_POST["page_no"]);
    $rows = $result["rows"];
    $pagination = $result["pagination"];

    if (count($rows) > 0) {
        $n = (($_POST["page_no"] - 1) * 5) + 1;
        foreach ($rows as $row) {
        ?>
            <tr>
                <th scope="row"><?php echo $n; ?></th>
                <td><?php echo $row["brand_name"]; ?></td>
                <td><a href="#" class="btn btn-success btn-sm">Active</a></td>
                <td>
                    <a href="#" did="<?php echo $row["bid"]; ?>" class="btn btn-danger btn-sm del_brand">Delete</a>
                    <a href="#" eid="<?php echo $row["bid"]; ?>" data-toggle="modal" data-target="#update_brand_modal" class="btn btn-info btn-sm edit_brand">Edit</a>
                </td>
            </tr>
        <?php
            $n++;
        }
        ?>
        <tr>
            <td colspan="5"><?php echo $pagination; ?></td>
        </tr>
        <?php
        exit();
    }
}

// Delete Brand
if (isset($_POST["deleteBrand"])) {
    $m = new Manage();
    $result = $m->deleteRecord('brands', 'bid', $_POST["id"]);
    echo $result;
    exit();
}

// Get single for Update Brand
if (isset($_POST["updateBrand"])) {
    $m = new Manage();
    $result = $m->getSingleCategory("brands", "bid", $_POST["id"]);
    echo json_encode($result);
    exit();
}


// Update Brand
if (isset($_POST["update_brand_name"])) {
    $m = new Manage();
    $id = $_POST["update_bid"];
    $name = $_POST["update_brand_name"];
    $result = $m->updateRecords("brands", ["bid" => $id], ["brand_name" => $name, "status" => 1]);
    echo $result;
    exit();
}

/**
 * = = = = = = = = = = = = = = = = = = = 
 * Product
 * = = = = = = = = = = = = = = = = = = = 
 */
// Manage Product
if (isset($_POST["manageProduct"])) {
    $m = new Manage();
    $result = $m->manageRecordWithPagination('products', $_POST["page_no"]);
    $rows = $result["rows"];
    $pagination = $result["pagination"];

    if (count($rows) > 0) {
        $n = (($_POST["page_no"] - 1) * 5) + 1;
        foreach ($rows as $row) {
        ?>
            <tr>
                <th scope="row"><?php echo $n; ?></th>
                <td><?php echo $row["product_name"]; ?></td>
                <td><?php echo $row["category_name"]; ?></td>
                <td><?php echo $row["brand_name"]; ?></td>
                <td><?php echo $row["product_price"]; ?></td>
                <td><?php echo $row["product_stock"]; ?></td>
                <td><?php echo $row["added_date"]; ?></td>
                <td><a href="#" class="btn btn-success btn-sm">Active</a></td>
                <td>
                    <a href="#" did="<?php echo $row["pid"]; ?>" class="btn btn-danger btn-sm del_product">Delete</a>
                    <a href="#" eid="<?php echo $row["pid"]; ?>" data-toggle="modal" data-target="#update_product_modal" class="btn btn-info btn-sm edit_product">Edit</a>
                </td>
            </tr>
        <?php
            $n++;
        }
        ?>
        <tr>
            <td colspan="9"><?php echo $pagination; ?></td>
        </tr>
    <?php
        exit();
    }
}

// Delete Product
if (isset($_POST["deleteProduct"])) {
    $m = new Manage();
    $result = $m->deleteRecord('prouct', 'pid', $_POST["id"]);
    echo $result;
    exit();
}

// Get single for Update Product
if (isset($_POST["updateProduct"])) {
    $m = new Manage();
    $result = $m->getSingleCategory("products", "pid", $_POST["id"]);
    echo json_encode($result);
    exit();
}

// Update Product
if (isset($_POST["update_product_name"])) {
    $m = new Manage();

    $id = $_POST["update_pid"];
    $name = $_POST["update_product_name"];
    $category = $_POST['update_select_cat'];
    $brand = $_POST["update_select_brand"];
    $price = $_POST["update_product_price"];
    $qty = $_POST["update_product_qty"];
    $date =  $_POST["added_date"];

    $result = $m->updateRecords(
        "products",
        ["pid" => $id],
        [
            "cid" => $category,
            "bid" => $brand,
            "product_name" => $name,
            "product_price" => $price,
            "product_stock" => $qty,
            "added_date" => $date,
            "p_status" => 1
        ]
    );

    echo $result;
    exit();
}

/**
 * = = = = = = = = = = = = = = = = = = = 
 * Order processing
 * = = = = = = = = = = = = = = = = = = = 
 */
if (isset($_POST["getNewOrderItem"])) {
    $obj = new DBOperation();
    $rows = $obj->getAllRecords("products");
    ?>
    <tr>
        <td><span class="font-weight-bold number" id="number">1</span></td>
        <td>
            <select name="pid[]" class="form-control form-control-sm pid" required>
                <option value="">Choose product</option>
            <?php foreach ($rows as $row) { ?>
                <option value="<?php echo $row["pid"]; ?>"><?php echo $row["product_name"]; ?></option>
            <?php } ?>
            </select>
        </td>
        <td>
            <input type="text" name="tqty[]" class="form-control form-control-sm tqty" readonly>
        </td>
        <td>
            <input type="text" name="qty[]" class="form-control form-control-sm qty" required>
        </td>
        <td>
            <input type="text" name="price[]" class="form-control form-control-sm price" readonly>
        </td>
        <td>
            <input style="display: none;" type="hidden" name="pro_name[]" class="form-control form-control-sm pro_name">
        </td>
        <td>BDT <span class="amt">00.00</span>/-</td>
    <?php
    exit();
}

// Get Price and Quantity for single item
if (isset($_POST["getPriceAndQty"])) {
    $m = new Manage();
    $result = $m->getSingleRecord("products", "pid", $_POST["id"]);
    echo json_encode($result);
    exit();
}

// Get Order
if (isset($_POST["order_date"]) && isset($_POST["cust_name"])) {
    $order_date = $_POST["order_date"];
    $customer_name = $_POST["cust_name"];

    $arr_tqty = $_POST["tqty"];
    $arr_qty = $_POST["qty"];
    $arr_price = $_POST["price"];
    $arr_pro_name = $_POST["pro_name"];

    $sub_total = $_POST["sub_total"];
    $gst = $_POST["gst"];
    $discount = $_POST["discount"];
    $net_total = $_POST["net_total"];
    $paid = $_POST["paid"];
    $due = $_POST["due"];
    $payment_type = $_POST["payment_type"];

    $m = new Manage();
    $result = $m->storeCustomerOrderInvoice($order_date, $customer_name, $arr_tqty, $arr_qty, $arr_price, $arr_pro_name, $sub_total, $gst, $discount, $net_total, $paid, $due, $payment_type);
    echo $result;
}
