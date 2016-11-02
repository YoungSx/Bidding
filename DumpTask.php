<?php
/**
 * Created by PhpStorm.
 * User: Shangxin
 * Date: 2016/10/10
 * Time: 20:42
 */
if( !isset( $_POST ) || !isset($_POST['session_id']) ){
    echo json_encode(array("success" => "0","error" => "11","message" => "session_id is wrong."));
    exit();
}
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

$dump_sql = "select * from `task`;";
$dump_result = $conn->query($dump_sql);
$task_list = array();
while( $dump_row = $dump_result->fetch_assoc()){
    $task_list[] = $dump_row;
}
echo json_encode($task_list);