<?php

    function db ($host,$user,$pass,$db_name) {
        $db = mysql_connect($host,$user,$pass); #тут во первых поменять на новую функцию, во вторых если подключение дуачно тоон запишет нам в переменную данные
        if(!$db){
            exit(mysql_error());#если не подключился то выходим просто из функции
        }
        if (!mysql_select_db($db_name,$db)){
            exit(mysql_error());
        }
        mysql_query("SET NAMES UTF8"); #функция даёт возмодность отправить запрос в Бд. отправим запрос для определения кодировки
    }


