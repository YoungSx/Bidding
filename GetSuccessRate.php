<?php
/**
 * Created by PhpStorm.
 * User: Shangxin
 * Date: 2016/10/11
 * Time: 11:35
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

if( !isset( $_GET ) || !isset($_GET['user_id']) ){
    echo json_encode(array("success" => "0","error" => "9","message" => "user id is wrong."));
    exit();
}
$user_id = $_GET['user_id'];

$sql = "select (select count(*) from `join` where `user_id` = $user_id and `accept` = 1)/(select count(*) from `join` where `user_id` = $user_id) `rate`;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo json_encode(array(
    "success" => "1",
    "error" => "0",
    "success_rate" => $row['rate']
));