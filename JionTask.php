<?php
/**
 * Created by PhpStorm.
 * User: Shangxin
 * Date: 2016/10/10
 * Time: 2:24
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

if( !isset( $_POST ) || !isset($_POST['task_id']) ){
    echo json_encode(array("success" => "0","error" => "7","message" => "task id is wrong."));
    exit();
}
$task_id = $_POST['task_id'];

if( $user->joinTask($conn ,$task_id) ){
    echo json_encode(array("success" => "1","error" => "0","message" => "join task successful."));
}else{
    echo json_encode(array("success" => "0","error" => "101","message" => "join task failed."));
}

