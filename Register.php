<?php
/**
 * Created by PhpStorm.
 * User: Shangxin
 * Date: 2016/10/7
 * Time: 23:50
 */

//判断用户名密码在不在
if(isset( $_POST ) && ( isset($_POST['username']) && isset($_POST['password']) )){
    if( $_POST['username'] == "" || $_POST['password'] == "" ){
        echo json_encode(array("success" => "0","error" => "3","message" => "username or password is wrong."));
        exit();
    }
}else{
    echo json_encode(array("success" => "0","error" => "3","message" => "username or password is wrong."));
    exit();
}
$username = $_POST['username'];
//$password = md5($_POST['password']);
$password = $_POST['password'];
if(isset($_POST['nickname']))
    $nickname = $_POST['nickname'];
if(isset($_POST['telephone']))
    $telephone = $_POST['telephone'];
else $telephone = '00000000000';
include 'Config.php';

$register_sql = "
    insert into `user`(`username`,`password`,`nickname`,`telephone`)values('$username','$password','$nickname','$telephone');
";
$conn->query("USE `".$db_name."`");
if($conn->query($register_sql) == TRUE ){
    echo json_encode(array("success" => "1","error" => "0","message" => "register successful."));
    $conn->close();
}else{
    echo json_encode(array("success" => "0","error" => "2","message" => "database operating failed.". $conn->error));
    $conn->close();
    exit();
}
