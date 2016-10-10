<?php

/**
 * Created by PhpStorm.
 * User: Shangxin
 * Date: 2016/10/7
 * Time: 23:26
 */
class User
{
    var $username;
    var $nickname;
    var $telephone;
    var $success_rate;
    var $credit;
    var $id;

    function __construct($username)
    {
        $this->username = $username;
    }

    public function getUsername(){
        return $this->username;
    }

    public function setUserInfo($username, $nickname ,$telephone, $success_rate,$credit, $id ){
        $this->username = $username;
        $this->nickname = $nickname;
        $this->telephone = $telephone;
        $this->success_rate = $success_rate;
        $this->credit = $credit;
        $this->id = $id;
    }
    public function updateUserInfo($conn){
        $username = $this->username;
        $user_info_sql = "SELECT `nickname`,`telephone`,`success_rate`,`credit`,`id` FROM `user` where `username` = '$username';";
        $result = $conn->query($user_info_sql);

        $row = $result->fetch_assoc();
        $this->nickname = $row['nickname'];
        $this->telephone = $row['telephone'];
        $this->success_rate = $row['success_rate'];
        $this->credit = $row['credit'];
        $this->id = $row['id'];
    }
    public function getUserInfo(){
        $user = array(
            "username" => $this->username,
            "nickname" => $this->nickname,
            "telephone" => $this->telephone,
            "success_rate" => $this->success_rate,
            "credit" => $this->credit,
            "id" => $this->id
        );
        return $user;
    }

    public function publishTask($conn ,$title ,$text ,$price ,$need_count){
        $publisher_id = $this->id;
        $publish_task_sql = "insert into `task`(title,text,price,publisher,need_count,already_count)values('$title','$text.',$price,$publisher_id,$need_count,null);";
        $result = $conn->query($publish_task_sql);
        if( $result == TRUE ) return true;
        else return false;
    }

    public function joinTask($conn ,$task_id){
        $user_id = $this->id;

        //判断是否已经加入了这个任务
        $task_repeat_confirm_sql = "select `user_id`,`task_id` from `join` where user_id=$user_id and task_id=$task_id;";
        $task_repeat_confirm_result = $conn->query($task_repeat_confirm_sql);
        $task_repeat_row = $task_repeat_confirm_result->fetch_assoc();
        if( !empty($task_repeat_row) ) return false;

        $task_sql = "select `need_count`,`already_count` from `task` where id=$task_id;";
        $result = $conn->query($task_sql);
        $row = $result->fetch_assoc();

        $need_count = $row['need_count'];
        if($row['already_count'] == "") $already_count=0;
        else $already_count = $row['already_count'];

        //判断是否已满
        if($need_count == $already_count) return false;

        $join_sql = "insert into `join`(`user_id`,`task_id`)values($user_id ,$task_id);";
        $join_result = $conn->query($join_sql);

        if( $join_result ) return TRUE;
        else return FALSE;
    }

    public function checkTask($conn ,$user_id ,$task_id){

        //判断是否已经确认
        $confirm_sql = "select `accept` from `join` where user_id=$user_id and task_id=$task_id;";
        $confirm_result = $conn->query( $confirm_sql );
        $confirm_row =  $confirm_result->fetch_assoc();
        if( $confirm_row['accept'] != 0 ) return false;

        $check_sql = "update `join` set `accept`=1 where user_id=$user_id and task_id=$task_id;";
        $check_result = $conn->query($check_sql);

        $already_plus_sql = "update `task` set `already_count`=`already_count`+1 where `id`=$task_id";
        $plus_result = $conn->query($already_plus_sql);

        if( $plus_result && $check_result ) return TRUE;
        else return FALSE;
    }
}