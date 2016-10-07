<?php
/**
 * Created by PhpStorm.
 * User: Shangxin
 * Date: 2016/10/7
 * Time: 23:25
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
$password = $_POST['password'];
//$password = md5($_POST['password']);

include 'Config.php';

//初始化用户信息
$login_sql = "select `password` from `User` where `username`= ' $username '" ;
$result = $conn->query($login_sql);



if( $result == TRUE ){
    $row = $result->fetch_assoc();
    //判断密码对不对
    if( $password == $row['password'] ){
        //实例化User，并获取用户其他信息，然后返回
        $user = new User($username);
        $user->updateUserInfo($conn);
        echo json_encode(
            array(
                "success" => "1",
                "error" => "0",
                "message" => "login successful.",
                "user" => array(
                    "nickname" => $user->nickname,
                    "success_rate" => $user->success_rate,
                    "id" => $user->id
                )
            )
        );
    } else{
        echo json_encode(array("success" => "0","error" => "4","message" => "password is wrong."));
    }
}else{
    echo json_encode(array("success" => "0","error" => "4","message" => "username is wrong."));
}
$conn->close();