<?php

function BasicQuery($Query) {
    $mysql = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if($mysql->connect_errno > 0){
        print ('Unable to connect to database [' . $mysql->connect_error . ']');
    } else {$mysql->set_charset("utf8");}

    if(!$result = $mysql->query($Query)){die('Error [' . $mysql->error . ']');}

    // $result->close();
    return $result;
}