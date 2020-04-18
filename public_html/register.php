<?php include_once("templates/header.php"); ?>

<div class="container">
    <div class="card mx-auto my-4" style="width: 30rem;">
        <div class="card-header">Register</div>
        <div class="card-body">
            <form id="register_form" onsubmit="return false" autocomplete="off">
                <div class="form-group">
                    <label for="username">Full Name</label>
                    <input type="text" class="form-control" name="username" id="username">
                    <span id="u_error" class="form-text text-muted"></span>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" id="email">
                    <span id="e_error" class="form-text text-muted"></span>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                    <span id="p1_error" class="form-text text-muted"></span>
                </div>
                <div class="form-group">
                    <label for="re_password">Re-enter Password</label>
                    <input type="password" name="re_password" class="form-control" id="re_password">
                    <span id="p2_error" class="form-text text-muted"></span>
                </div>
                <div class="form-group">
                    <label for="usertype">User type</label>
                    <select name="usertype" id="usertype" class="form-control">
                        <option value="">Choose account type</option>
                        <option value="1">Admin</option>
                        <option value="0">User</option>
                    </select>
                    <span id="t_error" class="form-text text-muted"></span>
                </div>
                <button type="submit" name="register" class="btn btn-primary">
                    <i class="fa fa-user">&nbsp;</i>Submit
                </button>
                <span><a href="index.php">Login</a></span>
            </form>
        </div>
        <!-- <div class="card-footer"><a href="#">Forgot password?</a></div> -->
    </div>
</div>

<?php include_once("templates/footer.php"); ?>