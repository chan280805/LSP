<?php

session_start();

require '../config/database.php';
require '../models/user.php';

use Models\User;

$db = new Database();
$conn = $db->connect();

$user = new User();

if(isset($_POST['login'])){

    $data = $user->login($conn,$_POST['username'],$_POST['password']);

    if($data){

        $_SESSION['user']=$data;

        if($data['role']=="admin"){
            header("location:dashboard_admin.php");
        }else{
            header("location:dashboard_user.php");
        }

    }else{
        echo "Login gagal";
    }
}
?>

<form method="POST">

Username
<input type="text" name="username">

Password
<input type="password" name="password">

<button name="login">Login</button>

</form>