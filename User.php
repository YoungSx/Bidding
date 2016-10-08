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
        $user_info_sql = "SELECT `nickname`,`telephone`,`success_rate`,`credit`,`id` FROM `User` where `username` = '$username';";
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
}