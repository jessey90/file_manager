<?php
session_start();
include_once("includes/config.php");
include_once("includes/function.php");

if(array_key_exists('login_btn', $_POST))
{
    $account = $_POST['account'];
    $password = $_POST['password'];
    
    if($account == "admin" && md5($password) == "fec30a5d1baf782ad98614b10c376902")
    {
        $_SESSION['user_login'] = "admin";
        header("location:index.php");
    }
    else
    {
        $sql = "select * from user where account='".$account."' and password='".md5($password)."'";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        if (mysqli_num_rows($result) >= 1) {
            $_SESSION['user_login'] = $account;
            $directory = "files/".$account;
            if(!is_dir($directory))
            {
                mkdir($directory,"0777");
            }
            header("location:index.php");
        }
    }
}

include_once("includes/template.php");
$tpl = new Template();
$file_tpl = 'login';
$html = $tpl->get_main($file_tpl);

$tpl->show_tpl($html);
?>