$(document).ready(function () {
    let DOMAIN = 'http://localhost/inventory/public_html/';

    /**
     *  = = = = = = = = = = 
     * Register
     *  = = = = = = = = = = 
     */
    $('#register_form').on('submit', function () {
        let status = false;
        let name = $('#username');
        let email = $('#email');
        let password = $('#password');
        let re_password = $('#re_password');
        let usertype = $('#usertype');
        // check username
        if (name.val().length < 6) {
            name.addClass('border-danger');
            $('#u_error').html('<span class="text-danger">Name is required and must be at least 6 character</span>');
            status = false;
        } else {
            name.removeClass('border-danger');
            $('#u_error').html('');
            status = true;
        }
        // check email
        if (!validateEmail(email.val())) {
            email.addClass('border-danger');
            $('#e_error').html('<span class="text-danger">Email not valid</span>');
            status = false;
        } else {
            email.removeClass('border-danger');
            $('#e_error').html('');
            status = true;
        }
        // check password - 1
        if (password.val().length < 9) {
            password.addClass('border-danger');
            $('#p1_error').html('<span class="text-danger">Password needs to be at least 9 characters long</span>');
            status = false;
        } else {
            password.removeClass('border-danger');
            $('#p1_error').html('');
            status = true;
        }
        // check password - 2
        if (re_password.val().length < 9) {
            re_password.addClass('border-danger');
            $('#p2_error').html('<span class="text-danger">Password needs to be at least 9 characters long</span>');
            status = false;
        } else {
            re_password.removeClass('border-danger');
            $('#p2_error').html('');
            status = true;
        }
        // check password match
        if (re_password.val() != password.val()) {
            re_password.addClass('border-danger');
            $('#p2_error').html('<span class="text-danger">Passwords didn\'t match</span>');
            status = false;
        } else {
            re_password.removeClass('border-danger');
            $('#p2_error').html('');
            status = true;
        }
        // check user type
        if (!usertype.val()) {
            usertype.addClass('border-danger');
            $('#t_error').html('<span class="text-danger">User type must be selected</span>');
            status = false;
        } else {
            usertype.removeClass('border-danger');
            $('#t_error').html('');
            status = true;
        }
        // if everything is ok, submit
        if (status === true) {
            $.ajax({
                url: DOMAIN + 'includes/process.php',
                method: 'POST',
                data: $('#register_form').serialize(),
                success: data => {
                    if (data == 'EMAIL_ALREADY_EXISTS') {
                        alert("This email is already registered!");
                    } else if (data == 'SOME_ERROR') {
                        alert('Something went wrong');
                    } else {
                        console.log(data);
                        window.location = encodeURI(DOMAIN + 'index.php?msg=You are registered, now you can login');
                    }
                }
            });
        }
    });

    /**
     *  = = = = = = = = = = 
     * Login
     *  = = = = = = = = = = 
     */
    $('#login_form').on('submit', function () {
        // $('.overlay').show()
        let status = false;
        let email = $('#login_email');
        let password = $('#login_password');
        // email
        if (email.val() == '') {
            email.addClass('border-danger');
            $('#e_error').html('<span class="text-danger">Email required</span>');
            status = false;
        } else {
            email.removeClass('border-danger');
            $('#e_error').html('');
            status = true;
        }
        // password
        if (password.val().length < 9) {
            password.addClass('border-danger');
            $('#p_error').html('<span class="text-danger">Password must be 9 characters long</span>');
            status = false;
        } else {
            password.removeClass('border-danger');
            $('#p_error').html('');
            status = true;
        }

        if (status === true) {
            $.ajax({
                url: DOMAIN + 'includes/process.php',
                method: 'POST',
                data: $('#login_form').serialize(),
                success: data => {
                    if (data == 'NOT_REGISTERED') {
                        email.addClass('border-danger');
                        $('#e_error').html('<span class="text-danger">Email is not registered</span>')
                    } else if (data == 'PASSWORD_NOT_MATCHED') {
                        password.addClass('border-danger');
                        $('#p_error').html('<span class="text-danger">Password didn\'t match</span>');
                    } else {
                        // console.log(data);
                        window.location = DOMAIN + 'dashboard.php';
                    }
                }
            });
        }
    });

    fetchCategory();
    fetchBrand();

    /**
     *  = = = = = = = = = = 
     * Fetch Categories
     *  = = = = = = = = = = 
     */
    function fetchCategory() {
        $.ajax({
            url: DOMAIN + 'includes/process.php',
            method: 'POST',
            data: { getCategory: 1 },
            success: data => {
                let root = '<option class="form-control" value="0">Root</option>';
                let choose = '<option class="form-control" value="">Choose Category</option>';
                $('#parent_cat').html(root + data);
                $('#select_cat').html(choose + data);
            }
        });
    }

    /**
     *  = = = = = = = = = = 
     * Fetch Brand
     *  = = = = = = = = = = 
     */
    function fetchBrand() {
        $.ajax({
            url: DOMAIN + 'includes/process.php',
            method: 'POST',
            data: { getBrand: 1 },
            success: data => {
                let choose = '<option class="form-control" value="">Choose Brand</option>';
                $('#select_brand').html(choose + data);
            }
        });
    }

    /**
     *  = = = = = = = = = = 
     * Add Category
     *  = = = = = = = = = = 
     */
    $('#category_form').on('submit', function () {
        if ($('#category_name').val() == '') {
            $('#category_name').addClass('border-danger');
            $('#cat_error').html('<span class="text-danger">Please enter Category name</span>');
        } else {
            $.ajax({
                url: DOMAIN + 'includes/process.php',
                method: 'POST',
                data: $('#category_form').serialize(),
                success: data => {
                    if (data == 'CATEGORY_ADDED') {
                        $('#category_name').removeClass('border-danger');
                        $('#cat_error').html('<span class="text-success">Successfully added new Category!</span>');
                        $('#category_name').val('');
                        fetchCategory();
                    } else {
                        alert(data);
                    }
                }
            });
        }
    });

    /**
     *  = = = = = = = = = = 
     * Add Brand
     *  = = = = = = = = = = 
     */
    $('#brand_form').on('submit', function () {
        if ($('#brand_name').val() == '') {
            $('#brand_name').addClass('border-danger');
            $('#brand_error').html('<span class="text-danger">Please enter Brand name</span>');
        } else {
            $.ajax({
                url: DOMAIN + 'includes/process.php',
                method: 'POST',
                data: $('#brand_form').serialize(),
                success: data => {
                    if (data == 'BRAND_ADDED') {
                        $('#brand_name').removeClass('border-danger');
                        $('#brand_error').html('<span class="text-success">Successfully added new Brand!</span>');
                        $('#brand_name').val('');
                        fetchBrand();
                    } else {
                        alert(data);
                    }
                }
            });
        }
    });

    /**
     *  = = = = = = = = = = 
     * Add Product
     *  = = = = = = = = = = 
     */
    $('#product_form').on('submit', function () {
        $.ajax({
            url: DOMAIN + 'includes/process.php',
            method: 'POST',
            data: $('#product_form').serialize(),
            success: data => {
                if (data == 'NEW_PRODUCT_ADDED') {
                    alert('New Product added successfully!');

                    $('#product_name').val('');
                    $('#product_qty').val('');
                    $('#added_date').val('');
                    $('#select_cat').val('');
                    $('#select_brand').val('');
                    $('#product_price').val('');
                } else {
                    alert('An error occured while adding a product.\nFind error message in console');
                    console.log(data);
                }
            }
        });
    });

    manageCategory(1);
    /**
     *  = = = = = = = = = = 
     * Manage category (Paginate)
     *  = = = = = = = = = = 
     */
    // populating the manage category table
    function manageCategory(page_no) {
        $.ajax({
            url: DOMAIN + 'includes/process.php',
            method: 'POST',
            data: { manageCategory: 1, page_no: page_no },
            success: data => {
                // console.log(data);
                $('#get_category').html(data);
            }
        });
    }

    /**
     *  = = = = = = = = = = 
     * Pagination buttons
     *  = = = = = = = = = = 
     */
    $('body').delegate('.page-link', 'click', function () {
        var pn = $(this).attr('pn');
        manageCategory(pn);
    })

    /**
     *  = = = = = = = = = = 
     * Category delete
     *  = = = = = = = = = = 
     */
    $('body').delegate('.del_cat', 'click', function () {
        let did = $(this).attr('did');
        if (confirm('Are you sure to want to delete?')) {
            $.ajax({
                url: DOMAIN + 'includes/process.php',
                method: 'POST',
                data: { deleteCategory: 1, id: did },
                success: data => {
                    if (data == 'DEPENDANT_CATEGORY') {
                        alert('This category cannot be deleted!\nCategory type: Parent Category');
                    } else if (data == 'CATEGORY_DELETED') {
                        alert('This category deleted successfully!');
                        manageCategory(1);
                    } else if (data == 'DELETED') {
                        alert('Delete successful!');
                    } else {
                        alert(data);
                    }
                }
            });
        } else {
            // 
        }
    });

    // helper function for update
    fetchCategory_forUpdate();
    function fetchCategory_forUpdate() {
        $.ajax({
            url: DOMAIN + 'includes/process.php',
            method: 'POST',
            data: { getCategory: 1 },
            success: data => {
                let root = '<option class="form-control" value="0">Root</option>';
                $('#update_parent_cat').html(root + data);
            }
        });
    }

    /**
     *  = = = = = = = = = = 
     * Category update
     *  = = = = = = = = = = 
     */
    // fill up update modal with related information
    $('body').delegate('.edit_cat', 'click', function () {
        let eid = $(this).attr('eid');
        $.ajax({
            url: DOMAIN + 'includes/process.php',
            method: 'POST',
            dataType: 'json',
            data: { updateCategory: 1, id: eid },
            success: data => {
                console.log(data);
                $('#update_cid').val(data['cid']);
                $('#update_category_name').val(data['category_name']);
                $('#update_parent_cat').val(data['parent_cat']);
            }
        })
    });

    $('#update_category_form').on('submit', e => {
        e.preventDefault();
        if ($('#update_category_name').val() == '') {
            $('#update_category_name').addClass('border-danger');
            $('#update_cat_error').html('<span class="text-danger">Please enter Category name</span>');
        } else {
            $.ajax({
                url: DOMAIN + 'includes/process.php',
                method: 'POST',
                data: $('#update_category_form').serialize(),
                success: data => {
                    if (data == "UPDATED") {
                        $('#update_category_name').removeClass('border-danger');
                        $('#update_cat_error').html('<span class="text-success">Successfully added new Category!</span>');
                        $('#update_category_name').val('');
                        fetchCategory();
                        // window.location.href = "";
                        location.reload();
                    } else {
                        alert(data);
                    }
                }
            });
        }
    });

    /**
     *  = = = = = = = = = = 
     * Manage Brand
     *  = = = = = = = = = = 
     */
    manageBrand(1);
    function manageBrand(page_no) {
        $.ajax({
            url: DOMAIN + 'includes/process.php',
            method: 'POST',
            data: { manageBrand: 1, page_no: page_no },
            success: data => {
                console.log(data);
                $('#get_brand').html(data);
            }
        });
    }

    /**
     *  = = = = = = = = = = 
     * Pagination buttons (brand)
     *  = = = = = = = = = = 
     */
    $('body').delegate('.page-link', 'click', function () {
        var pn = $(this).attr('pn');
        manageBrand(pn);
    });

    /**
     *  = = = = = = = = = = 
     * Delete Brand
     *  = = = = = = = = = = 
     */
    $('body').delegate('.del_brand', 'click', function () {
        let did = $(this).attr('did');
        if (confirm('Are you sure to want to delete?')) {
            $.ajax({
                url: DOMAIN + 'includes/process.php',
                method: 'POST',
                data: { deleteBrand: 1, id: did },
                success: data => {
                    if (data == 'DELETED') {
                        alert('Brand is successfully deleted!')
                        // manageBrand(1);
                    }
                    location.reload();
                }
            });
        }
    });

    /**
     *  = = = = = = = = = = 
     * Update Brand
     *  = = = = = = = = = = 
     */
    // fill up update modal with related information
    $('body').delegate('.edit_brand', 'click', function () {
        let eid = $(this).attr('eid');
        $.ajax({
            url: DOMAIN + 'includes/process.php',
            method: 'POST',
            dataType: 'json',
            data: { updateBrand: 1, id: eid },
            success: data => {
                console.log(data);
                $('#update_bid').val(data['bid']);
                $('#update_brand_name').val(data['brand_name']);
            }
        })
    });

    // Update Brand
    $('#update_brand_form').on('submit', e => {
        e.preventDefault();
        if ($('#update_brand_name').val() == '') {
            $('#update_brand_name').addClass('border-danger');
            $('#update_brand_error').html('<span class="text-danger">Please enter Brand name</span>');
        } else {
            $.ajax({
                url: DOMAIN + 'includes/process.php',
                method: 'POST',
                data: $('#update_brand_form').serialize(),
                success: data => {
                    console.log(data);
                    if (data == "UPDATED") {
                        $('#update_brand_name').removeClass('border-danger');
                        $('#update_brand_error').html('<span class="text-success">Successfully added new Category!</span>');
                        $('#update_brand_name').val('');
                        fetchCategory();
                        // window.location.href = "";
                        location.reload();
                    } else {
                        alert(data);
                    }
                }
            });
        }
    });

    /**
     *  = = = = = = = = = = 
     * Manage Product
     *  = = = = = = = = = = 
     */
    manageProduct(1);
    function manageProduct(page_no) {
        $.ajax({
            url: DOMAIN + 'includes/process.php',
            method: 'POST',
            data: { manageProduct: 1, page_no: page_no },
            success: data => {
                console.log(data);
                $('#get_product').html(data);
            }
        });
    }

    /**
     *  = = = = = = = = = = 
     * Pagination buttons (product)
     *  = = = = = = = = = = 
     */
    $('body').delegate('.page-link', 'click', function () {
        var pn = $(this).attr('pn');
        manageProduct(pn);
    });

    /**
     *  = = = = = = = = = = 
     * Delete Product
     *  = = = = = = = = = = 
     */
    $('body').delegate('.del_product', 'click', function () {
        let did = $(this).attr('did');
        if (confirm('Are you sure to want to delete?')) {
            $.ajax({
                url: DOMAIN + 'includes/process.php',
                method: 'POST',
                data: { deleteProduct: 1, id: did },
                success: data => {
                    if (data == 'DELETED') {
                        alert('Product deleted!')
                        manageProduct(1);
                    }
                    location.reload();
                }
            });
        }
    });

    /**
     * 
     * = = = = = = = = = = 
     * Update Product
     *  = = = = = = = = = = 
     */
    
    // load Category and Brand
    fetchCategory_forUpdateProduct();
    fetchBrand_forUpdateProduct();
    
    // fill up update modal with related information
    $('body').delegate('.edit_product', 'click', function () {
        let eid = $(this).attr('eid');
        $.ajax({
            url: DOMAIN + 'includes/process.php',
            method: 'POST',
            dataType: 'json',
            data: { updateProduct: 1, id: eid },
            success: data => {
                console.log(data);
                $('#update_pid').val(data['pid']);
                $('#update_product_name').val(data['product_name']);
                $('#update_product_price').val(data['product_price']);
                $('#update_product_qty').val(data['product_stock']);
                $('#update_select_cat').val(data['cid']);
                $('#update_select_brand').val(data['bid']);
            }
        })
    });

    // Update Product
    // $('#update_product_form').on('submit', e => {
    //     e.preventDefault();
    //     if ($('#update_product_name').val() == '') {
    //         $('#update_product_name').addClass('border-danger');
    //         $('#update_update_error').html('<span class="text-danger">Please enter Product name</span>');
    //     } else {
    //         $.ajax({
    //             url: DOMAIN + 'includes/process.php',
    //             method: 'POST',
    //             data: $('#update_product_form').serialize(),
    //             success: data => {
    //                 console.log(data);
    //                 if (data == "UPDATED") {
    //                     $('#update_product_name').removeClass('border-danger');
    //                     $('#update_product_error').html('<span class="text-success">Successfully added new Category!</span>');
    //                     $('#update_product_name').val('');
    //                     fetchCategory();
    //                     // window.location.href = "";
    //                     location.reload();
    //                 } else {
    //                     alert(data);
    //                 }
    //             }
    //         });
    //     }
    // });

    // Update Product
    $('#update_product_form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: DOMAIN + 'includes/process.php',
            method: 'POST',
            data: $('#update_product_form').serialize(),
            success: data => {
                // alert(data);
                if (data == 'UPDATED') {
                    alert('Update success!');
                    location.reload();
                } else {
                    alert(data);
                }
            }
        });
    });

    // fetchCategory_forUpdateProduct();
    // fetchBrand_forUpdateProduct();

    // fill-up select category field in Update Product modal
    function fetchCategory_forUpdateProduct() {
        $.ajax({
            url: DOMAIN + 'includes/process.php',
            method: 'POST',
            data: { getCategory: 1 },
            success: data => {
                let root = '<option class="form-control" value="0">Root</option>';
                let choose = '<option class="form-control" value="">Choose Category</option>';
                $('#update_select_cat').html(root + data);
                $('#update_select_brand').html(choose + data);
            }
        });
    }

    // fill-up select brand field in Update Product modal
    function fetchBrand_forUpdateProduct() {
        $.ajax({
            url: DOMAIN + 'includes/process.php',
            method: 'POST',
            data: { getBrand: 1 },
            success: data => {
                let choose = '<option class="form-control" value="">Choose Brand</option>';
                $('#update_select_brand').html(choose + data);
            }
        });
    }

    function validateEmail(mail) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
            return (true)
        }
        return (false)
    }


    // https://www.youtube.com/watch?v=0NtWVV0Fwx4&list=PLB_Wd4-5SGAYCmzk21-bvdVTTF6AkH3-T&index=29
    // 20:45
});