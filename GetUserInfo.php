<?php
/**
 * Created by PhpStorm.
 * User: Shangxin
 * Date: 2016/10/10
 * Time: 21:09
 */
session_start();
if( !isset( $_SESSION['username'] ) ){
    echo json_encode(array("success" => "0","error" => "5","message" => "cannot found SESSION[username]."));
    exit();
}
include 'Config.php';
include 'User.php';

$user = new User($_SESSION['username']);
$user->updateUserInfo($conn);

if( !isset( $_POST ) || !isset($_POST['user_id']) ){
    echo json_encode(array("success" => "0","error" => "9","message" => "user id is wrong."));
    exit();
}
$user_id = $_POST['user_id'];

$user_info_sql = "SELECT * FROM `user` where `id` = '$user_id';";
$user_info_result = $conn->query($user_info_sql);

if( $user_info_result == FALSE )
    echo json_encode(array("success" => "0","error" => "101","message" => "ERROR."));

$user_info_row = $user_info_result->fetch_assoc();

echo json_encode($user_info_row);