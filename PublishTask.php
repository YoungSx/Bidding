<?php
/**
 * Created by PhpStorm.
 * User: Shangxin
 * Date: 2016/10/9
 * Time: 2:23
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

if( !isset( $_GET ) || !isset($_GET['title']) ){
    echo json_encode(array("success" => "0","error" => "6","message" => "task information is wrong."));
    exit();
}
$title = $_GET['title'];
$text = $_GET['text'];
$price = $_GET['price'];
$need_count = $_GET['need_count'];

if ( $user->publishTask($conn ,$title ,$text ,$price ,$need_count) )
    echo json_encode(array("success" => "1","error" => "0","message" => "task publish successful."));
else
    echo json_encode(array("success" => "0","error" => "101","message" => "unknown error."));
