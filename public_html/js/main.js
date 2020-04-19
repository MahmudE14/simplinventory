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
                        console.log(data);
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
    })

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
    })

    function validateEmail(mail) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
            return (true)
        }
        return (false)
    }

});