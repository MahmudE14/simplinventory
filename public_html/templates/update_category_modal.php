<div class="modal fade" id="update_category_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="update_category_form" onsubmit="return false">
          <div class="form-group">
            <label>Category Name</label>
            <input type="hidden" name="update_cid" id="update_cid" value="">
            <input type="text" class="form-control" id="update_category_name" name="update_category_name">
            <small id="update_cat_error" class="form-text text-muted"></small>
          </div>
          <div class="form-group">
            <select name="update_parent_cat" id="update_parent_cat">
              <option class="form-control" value="0">Root</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>