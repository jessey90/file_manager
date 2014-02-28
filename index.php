<?php
session_start();
if(isset($_SESSION['user_login']))
{
    include_once("includes/config.php");
    include_once("includes/function.php");
    
    if(array_key_exists('addaccount', $_POST))
    {
        $account = $_POST['username'];
        $password = $_POST['password'];
        
        $sql = "select * from user where account='".$account."'";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        if (mysqli_num_rows($result) >= 1) {
            $alert = "Thêm tài khoản không thành công !!! Tài khoản đã tồn tại !!!";
        }
        else
        {
            $sql = "INSERT INTO user (account,password) VALUES ('".$account."','".md5($password)."')";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $alert = "Thêm tài khoản thành công !!!";
            $directory = "files/".$account;
            if(!is_dir($directory))
            {
                mkdir($directory,"0777");
            }
        }
    }
    
    include_once("includes/template.php");
    $tpl = new Template();
    $file_tpl = 'index';
    $html = $tpl->get_main($file_tpl);
    
    if($_SESSION['user_login']=="admin")
    {
        $check_admin = '<div>
            <form method="post">
                <input type="text" name="username" placeholder="Nhập username"/>
                <input type="password" name="password" placeholder="Nhập password"/>
                <input type="submit" name="addaccount" value="Thêm tài khoản" style="cursor: pointer;"/>
                &nbsp;&nbsp;&nbsp;<label>{alert}</label>
            </form>
        </div>';
    }
    $sql = "select * from user";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));


    
    $html = $tpl->get_vars($html,array('check_admin'=>$check_admin,'alert'=>$alert));
    $tpl->show_tpl($html);
}
else
{
    header("location:login.php");
}
?>