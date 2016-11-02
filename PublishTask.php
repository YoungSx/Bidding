<?php
/**
 * Created by PhpStorm.
 * User: Shangxin
 * Date: 2016/10/9
 * Time: 2:23
 */

if( !isset( $_POST ) || !isset($_POST['title']) ){
    echo json_encode(array("success" => "0","error" => "6","message" => "task information is wrong."));
    exit();
}
$title = $_POST['title'];
$text = $_POST['text'];
$price = $_POST['price'];
$need_count = $_POST['need_count'];
$session_id = $_POST['session_id'];

session_id($session_id);
session_start();
if( !isset( $_SESSION['username'] ) ){
    echo json_encode(array("success" => "0","error" => "5","message" => "cannot found SESSION[username]."));
    exit();
}
include 'Config.php';
include 'User.php';

$user = new User($_SESSION['username']);
$user->updateUserInfo($conn);

if ( $user->publishTask($conn ,$title ,$text ,$price ,$need_count) )
    echo json_encode(array("success" => "1","error" => "0","message" => "task publish successful."));
else
    echo json_encode(array("success" => "0","error" => "101","message" => "unknown error."));
