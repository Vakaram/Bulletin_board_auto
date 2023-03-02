<?php

    #функция для пожключения к БД
    function db ($host,$user,$pass,$db_name){
        $db = mysqli_connect($host,$user,$pass);#тут во первых поменять на новую функцию, во вторых если подключение дуачно тоон запишет нам в переменную данные
        if(!$db){
            exit(mysqli_error());#если не подключился то выходим просто из функции
        }
        if (!mysqli_select_db($db,$db_name)){
            exit(mysqli_error());
        }
        mysqli_query($db,"SET NAMES UTF8"); #функция даёт возмодность отправить запрос в Бд. отправим запрос для определения кодировки
    }

    #функция для очисти actions
    function clear_str($str) {
        return trim(strip_tags($str)); #!!! блять почему то не выводит ничего кроме main ((((!
    }



