<?php
/**
 * User Class: account creation and login
 */
class User
{
    private $con;
    public function __construct()
    {
        include_once("../database/db.php");
        $db = new Database();
        $this->con = $db->connect() or die($this->con->error);
    }

    // check if the email is aleardy installed
    private function emailExists($email)
    {
        $pre_stmt = $this->con->prepare("SELECT id FROM user WHERE email = ?");
        $pre_stmt->bind_param("s", $email);
        $pre_stmt->execute();
        $result = $pre_stmt->get_result();

        return ($result->num_rows > 0) ? TRUE : FALSE;
    }

    public function createUserAccount($user, $email, $password, $usertype)
    {
        if ($this->emailExists($email)) {
            return "EMAIL_ALREADY_EXISTS";
        } else {
            $pass_hash = password_hash($password, PASSWORD_BCRYPT, ["cost" >= 8]);
            $date = Date("Y-m-d");
            $notes = "";
            $pre_stmt = $this->con->prepare("INSERT INTO `user`(`username`, `email`, `password`, `usertype`, `register_date`, `last_login`, `notes`) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $pre_stmt->bind_param('sssssss', $user, $email, $pass_hash, $usertype, $date, $date, $notes);
            $result = $pre_stmt->execute() or die($this->con->error);

            if ($result) {
                return $this->con->insert_id;
            } else {
                return "SOME_ERROR";
            }
        }
    }

    public function userLogin($email, $password)
    {
        $pre_stmt = $this->con->prepare("SELECT id, username, password, last_login FROM user WHERE email = ?");
        $pre_stmt->bind_param("s", $email);
        $pre_stmt->execute() or die($this->con->error);
        $result = $pre_stmt->get_result();
        
        if ($result->num_rows < 1) {
            return "NOT_REGISTERED";
        } else {
            $row = $result->fetch_array();
            if (password_verify($password, $row["password"])) {
                $_SESSION["userid"] = $row["id"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["last_login"] = $row["last_login"];

                // set last login
                $last_login = Date("Y-m-d H:i:s");
                $pre_stmt = $this->con->prepare("UPDATE `user` SET `last_login`= ? WHERE email= ?");
                $pre_stmt->bind_param("ss", $last_login, $email);
                $result = $pre_stmt->execute() or die($this->con->error);
                if ($result) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return "PASSWORD_NOT_MATCHED";
            }
        }
    }
}

// TEST
// $user = new User();
// echo $user->createUserAccount('def', 'def@example', '123456', 'Admin');
// echo $user->userLogin('abc@example', '123456');
// echo $_SESSION["username"];