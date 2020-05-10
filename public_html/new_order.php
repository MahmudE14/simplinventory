<?php
include_once("database/constants.php");

if (!isset($_SESSION["userid"])) {
    header("location:" . DOMAIN . "/");
}

?>

<?php include_once("templates/header.php"); ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow">
                <div class="card-header">
                    <h4>New Orders</h4>
                </div>
                <div class="card-body">
                    <form id="get_order_data" onsubmit="return false">
                        <div class="form-group row">
                            <label class="col-sm-3" align="right">Order Date:</label>
                            <div class="col-sm-6">
                                <input type="text" id="order_date" name="order_date" class="form-control form-control-sm" readonly value="<?php echo date("Y-d-m"); ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3" align="right">Customer Name*:</label>
                            <div class="col-sm-6">
                                <input type="text" id="cust_name" name="cust_name" class="form-control form-control-sm" required placeholder="Enter custoer name...">
                            </div>
                        </div>
                        <div class="card shadow-sm my-3 p-3">
                            <div class="card-body">
                                <h3 class="font-weight-light">Make a order list</h3>
                                <table align="center" style="width: 800px;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="text-align: center">Item Name</th>
                                            <th style="text-align: center">Total Quantity</th>
                                            <th style="text-align: center">Quantity</th>
                                            <th style="text-align: center">Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoice_item">
                                        <!-- <tr>
                                            <td><span class="font-weight-bold" id="number">1</span></td>
                                            <td>
                                                <select name="pid[]" class="form-control form-control-sm" required>
                                                    <option value="">Washing machine</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="tqty[]" class="form-control form-control-sm" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="qty[]" class="form-control form-control-sm" required>
                                            </td>
                                            <td>
                                                <input type="text" name="price[]" class="form-control form-control-sm" readonly>
                                            </td>
                                            <span>
                                                <input type="hidden" name="pro_name[]" class="form-control form-control-sm pro_name">
                                            </span>
                                            <td>BDT 55000</td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div> <!-- caro-body end -->
                            <div class="text-center p-2">
                                <button id="add" class="text-center btn btn-success m-1" style="width: 150px;">Add</button>
                                <button id="remove" class="text-center btn btn-danger m-1" style="width: 150px;">Remove</button>
                            </div>
                        </div> <!-- Order list caro end -->
                        <div class="form-group row pt-3">
                            <label for="sub_total" class="col-sm-3 col-form-label" align="right">Sub Total</label>
                            <div class="col-sm-6">
                                <input type="text" name="sub_total" id="sub_total" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="form-group row pt-3">
                            <label for="gst" class="col-sm-3 col-form-label" align="right">GST (18%)</label>
                            <div class="col-sm-6">
                                <input type="text" name="gst" id="gst" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="form-group row pt-3">
                            <label for="discount" class="col-sm-3 col-form-label" align="right">Discount</label>
                            <div class="col-sm-6">
                                <input type="text" name="discount" id="discount" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="form-group row pt-3">
                            <label for="net_total" class="col-sm-3 col-form-label" align="right">Net Total</label>
                            <div class="col-sm-6">
                                <input type="text" name="net_total" id="net_total" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="form-group row pt-3">
                            <label for="paid" class="col-sm-3 col-form-label" align="right">Paid</label>
                            <div class="col-sm-6">
                                <input type="text" name="paid" id="paid" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="form-group row pt-3">
                            <label for="due" class="col-sm-3 col-form-label" align="right">Due</label>
                            <div class="col-sm-6">
                                <input type="text" name="due" id="due" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="form-group row pt-3">
                            <label for="payment_type" class="col-sm-3 col-form-label" align="right">Payment type</label>
                            <div class="col-sm-6">
                                <select name="payment_type" id="payment_type" class="form-control form-control-sm" required>
                                    <option>Cash</option>
                                    <option>Card</option>
                                    <option>Draft</option>
                                    <option>Cheque</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="submit" id="order_form" class="btn btn-info" style="width: 150px;" value="Order">
                            <input type="submit" id="print_invoice" class="btn btn-success d-none" style="width: 150px;" value="Print Invoice">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once("templates/footer.php"); ?>
<script src="js/order.js"></script>
