<?php
include_once("../database/constants.php");
include_once("user.php");

// Register
if (isset($_POST["username"]) && isset($_POST["email"])) {
    $user = new User();
    $result = $user->createUserAccount($_POST["username"], $_POST["email"], $_POST["password"], $_POST["usertype"]);
    echo $result;
}

// Login
if (isset($_POST["login_email"]) && isset($_POST["login_password"])) {
    $user = new User();
    $result = $user->userLogin($_POST["login_email"], $_POST["login_password"]);
    echo $result;
}