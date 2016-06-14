<?php

class mysql
{
    private $con;
    private $host;
    private $user;
    private $password;
    private $database;

    public function __construct()
    {
        $this->host = '123.57.242.185';
        $this->user = 'ictuser';
        $this->password = 'user@ict2015.';
        $this->database = 'end_db';

        $conn = mysql_connect($this->host, $this->user, $this->password);

        $this->con = $conn;

        if (!$conn) {
            die('Could not connect: ' . mysql_error());
        } else {
//            echo 'Connect Success!';
        }
    }

    public function Excute($sqlstr)
    {
        mysql_select_db($this->database, $this->con);
        mysql_query("SET NAMES 'utf8'");
        mysql_query("SET CHARACTER_SET_CLIENT=utf8");
        mysql_query("SET CHARACTER_SET_RESULTS=utf8");

        $result = mysql_query($sqlstr, $this->con);

//        if($result){
//            echo 'Excute sql success!';
//        }else{
//            echo 'Excute sql failed!'.mysql_error();
//        }
        if (!$result) {
            echo 'Excute sql failed!' . mysql_error();
        }
    }

    public function Select($sqlstr)
    {
        mysql_select_db($this->database, $this->con);
        mysql_query("SET NAMES 'utf8'");
        mysql_query("SET CHARACTER_SET_CLIENT=utf8");
        mysql_query("SET CHARACTER_SET_RESULTS=utf8");

        $arr = mysql_query($sqlstr, $this->con);

        if ($arr) {
            return $arr;
        } else {
            echo 'Excute sql failed!' . mysql_error();
        }
    }

    public function Close()
    {
        mysql_close($this->con);
    }
} 