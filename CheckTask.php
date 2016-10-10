<?php
/**
 * Created by PhpStorm.
 * User: Shangxin
 * Date: 2016/10/10
 * Time: 19:55
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
$user_id = $_POST['user_id'];
///////////////////////////////////////////////////////////// 核对任务所有者
$confirm_task_sql = "select `publisher` from `task` where `id`=$task_id;";
$confirm_task_result = $conn->query($confirm_task_sql);
$row = $confirm_task_result->fetch_assoc();
if( $row['publisher'] != $user->id ){
    $t1 = $row['publisher'];
    $t2 = $user->id;
    echo json_encode(array("success" => "0","error" => "8","message" => "task $t1 is not belong to you $t2."));
    exit();
}

////////////////////////////////////////////////////////////

if( $user->checkTask($conn ,$user_id,$task_id)  )
    echo json_encode(array("success" => "1","error" => "0","message" => "successful."));
else echo json_encode(array("success" => "0","error" => "101","message" => "failed."));



