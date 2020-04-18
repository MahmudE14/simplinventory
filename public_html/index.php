<?php 
include_once("database/constants.php");
if (isset($_SESSION["userid"])) {
  header("location:" . DOMAIN . '/dashboard.php');
}
?>
<?php include_once("templates/header.php"); ?>

  <div class="contaner">
    <?php if (isset($_GET["msg"]) && !empty($_GET["msg"])) { ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_GET["msg"]; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php } ?>

    <div class="card mx-auto m-4" style="width: 30rem;">
      <img src="images/login.png" style="width: 40%;" class="card-img-top mx-auto" alt="...">
      <div class="card-body">
        <form id="login_form" onsubmit="return false">
          <div class="form-group">
            <label for="login_email">Email address</label>
            <input type="email" class="form-control" name="login_email" id="login_email" aria-describedby="emailHelp">
            <small id="e_error" class="text-danger"></small>
          </div>
          <div class="form-group">
            <label for="login_password">Password</label>
            <input type="password" class="form-control" name="login_password" id="login_password">
            <small id="p_error" class="text-danger"></small>
          </div>
          <button type="submit" class="btn btn-primary"><i class="fa fa-lock">&nbsp;</i>Login</button>
          <div class="m-1">Don't have an account yet? <a href="register.php">Register</a></div>
        </form>
        <div class="card-footer"><a href="#">Forgot password?</a></div>
      </div>
    </div>
  </div>

  <?php include_once("templates/footer.php"); ?>