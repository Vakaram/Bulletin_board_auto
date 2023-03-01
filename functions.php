<?php

    function db ($host,$user,$pass,$db_name){
        $db = mysqli_connect($host,$user,$pass);#тут во первых поменять на новую функцию, во вторых если подключение дуачно тоон запишет нам в переменную данные
        if(!$db){
            exit(mysqli_error());#если не подключился то выходим просто из функции
        }
        if (!mysqli_select_db($db_name,$db)){
            exit(mysqli_error());
        }
        mysqli_query("SET NAMES UTF8"); #функция даёт возмодность отправить запрос в Бд. отправим запрос для определения кодировки
    }


