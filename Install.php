<?php
/**
 * Created by PhpStorm.
 * User: Shangxin
 * Date: 2016/10/7
 * Time: 23:34
 */

$db_create_sql = "create database `Bidding`;";
$user_db_create_sql = "create table `user`(
	id int(5) not null auto_increment primary key,
	username varchar(20) not null,
	password varchar(20) not null,
	nickname varchar(20) not null default '',
	telephone int(12) not null,
	success_rate float null default 0,
	credit float null default 0
);";
$task_db_create_sql = "create table `task`(
	id int(5) not null auto_increment primary key,
	title varchar(200) not null,
	text varchar(2000) null default '',
	price decimal(5,2) not null,
	publisher int(5) not null,
	need_count int(5) not null default 1,
	already_count int(5) null default 0
);";