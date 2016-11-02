<?php
/**
 * Created by PhpStorm.
 * User: Shangxin
 * Date: 2016/10/10
 * Time: 2:28
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

if( !isset( $_GET ) || !isset($_GET['task_id']) ){
    echo json_encode(array("success" => "0","error" => "7","message" => "task id is wrong."));
    exit();
}
$task_id = $_GET['task_id'];

$task_info_sql = "SELECT `id`,`title`,`text`,`price`,`publisher`,`need_count`,`already_count` FROM `task` where `id` = '$task_id';";
$task_info_result = $conn->query($task_info_sql);

if( $task_info_result == FALSE )
    echo json_encode(array("success" => "0","error" => "101","message" => "ERROR."));

$task_info_row = $task_info_result->fetch_assoc();

/////////////////////////////////////////////////////获取任务参与者信息
$task_join_sql = "SELECT `user_id`,`accept` FROM `join` where `task_id` = '$task_id';";
$task_join_result = $conn->query($task_join_sql);
if( $task_join_result == FALSE )
    echo json_encode(array("success" => "0","error" => "101","message" => "ERROR."));
$task_join=array();
while ($task_join_row = $task_join_result->fetch_assoc()){
    $task_join[] = $task_join_row ;
}
/////////////////////////////////////////////////////

$task_info = array(
    'id' => $task_info_row['id'],
    'title' => $task_info_row['title'],
    'text' => $task_info_row['text'],
    'price' => $task_info_row['price'],
    'publisher' => $task_info_row['publisher'],
    'need_count' => $task_info_row['need_count'],
    'already_count' => $task_info_row['already_count'],
    'task_join' => $task_join
);
echo json_encode($task_info);

