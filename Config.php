<?php
/**
 * Created by PhpStorm.
 * User: Shangxin
 * Date: 2016/10/7
 * Time: 23:25
 */

$db_host = "localhost";
$db_username = "root";
$db_password = "usbw";
$db_name = "Bidding";

//连接数据库
$conn = new mysqli($db_host,$db_username,$db_password);
if($conn->connect_error){
    $conn->close();
    echo json_encode(array("success" => "0","error" => "1","message" => "database connecting error."));
    exit();
}
$conn->select_db("Bidding");
$conn->query('SET NAMES utf8');