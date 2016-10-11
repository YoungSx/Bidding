<?php
/**
 * Created by PhpStorm.
 * User: Shangxin
 * Date: 2016/10/7
 * Time: 23:34
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

$db_create_sql = "create database `Bidding` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
if( $conn->query($db_create_sql) ) echo '数据库创建成功';
else echo '数据库创建失败';

$conn->select_db("Bidding");
$conn->query('SET NAMES utf8');


$user_table_create_sql = "create table `user`(
	id int(5) not null auto_increment primary key,
	username varchar(20) not null unique,
	password varchar(20) not null,
	nickname varchar(20) not null default '',
	telephone varchar(11) not null,
	success_rate float null default 0,
	credit float null default 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

if( $conn->query($user_table_create_sql) ) echo 'user表创建成功';
else echo 'user表创建失败';

$task_table_create_sql = "create table `task`(
	id int(5) not null auto_increment primary key,
	title varchar(200) not null,
	text varchar(2000) null default '',
	price decimal(5,2) not null,
	publisher int(5) not null,
	need_count int(5) not null default 1,
	already_count int(5) null default 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

if( $conn->query($task_table_create_sql) ) echo 'task表创建成功';
else echo 'task表创建失败';

$jion_table_create_sql = "create table `join`(
	id int(5) not null auto_increment primary key,
	user_id int(5) not null,
	task_id int(5) not null,
	accept int(5) null default 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

if( $conn->query($jion_table_create_sql) ) echo 'join表创建成功';
else echo 'join表创建失败';