<div class="modal fade" id="update_product_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="update_product_form" onsubmit="return false">
          <div class="form-row">
            <div class="form-group col-md-6">
                <input type="hidden" name="update_pid" id="update_pid" value="">
              <label>Date</label>
              <input type="text" class="form-control" id="added_date" name="added_date" value="<?php echo date("Y-m-d");?>" readonly>
            </div>
            <div class="form-group col-md-6">
              <label>Product Name</label>
              <input type="text" class="form-control" id="update_product_name" name="update_product_name" required>
            </div>
          </div>
          <div class="form-group">
            <label>Category</label>
            <select name="update_select_cat" id="update_select_cat">
              <!--  -->
            </select>
          </div>
          <div class="form-group">
            <label>Brand</label>
            <select name="update_select_brand" id="update_select_brand">
              <!--  -->
            </select>
          </div>
          <div class="form-group">
            <label>Price</label>
            <input type="text" name="update_product_price" id="update_product_price" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Product Quantity</label>
            <input type="text" name="update_product_qty" id="update_product_qty" class="form-control" required>
          </div> 
          <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
