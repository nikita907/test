<?php

if (empty($_SESSION['auth']) or $_SESSION['auth'] == false) {
    if ( !empty($_COOKIE['login']) and !empty($_COOKIE['key']) ) {
        $login = $_COOKIE['login'];
        $key = $_COOKIE['key'];
        if( is_file("users.xml")){
            $xml = simplexml_load_file("users.xml");
            foreach ($xml as $child) {
                if ($child->Login == $login) {
                    session_start();
                    $_SESSION['auth'] = true;
                    $_SESSION['login']=$login;
                    echo "Hello"." ".$child->Name;
                    ?><a href="logout.php">Выйти</a><?php
                }
            }
        }
    }
    else{
        header("Location:registration.php");
    }
}
?>