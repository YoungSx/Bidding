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
    var $success_rate;
    var $id;

    function __construct($username)
    {
        $this->username = $username;
    }
    public function setUserInfo($username, $nickname ,$success_rate, $id ){
        $this->username = $username;
        $this->nickname = $nickname;
        $this->success_rate = $success_rate;
        $this->id = $id;
    }
    public function updateUserInfo($conn){
        $username = $this->username;
        $user_info_sql = "SELECT `nickname`,`success_rate`,`id` FROM `User` where `username` = ' $username ' ;";
        $result = $conn->query($user_info_sql);

        $row = $result->fetch_assoc();
        $this->nickname = $row['nickname'];
        $this->success_rate = $row['success_rate'];
        $this->id = $row['id'];
    }
    public function getUserInfo(){
        $user = array(
            "username" => $this->username,
            "nickname" => $this->nickname,
            "success_rate" => $this->success_rate,
            "if" => $this->id
        );
        return $user;
    }
}