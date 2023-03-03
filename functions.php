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

    #функция шаблонизатор для отображения главной страницы по центру
    function render($path,$param = array()  ) { #path путь к шаблону
        extract($param);# она распаковывает как бы их принимает параметром массив и создаёт переменные в памяти и имена это ключи массива
        ob_start();#буферезированный вывод она помещается в буфер обмена и не выводится, а только тогда когда данные получим из буфера
        if (!include($path.".php")) { #подключаем имя шаблончика
            exit("Нет такого шаблона");
        }

        return ob_get_clean(); # для того чтобы вытащить данные из буфера и вытащить их, а ещё и подчистить
    }

    #функция для проверки регистрации и типа логин ввести и проверить и т.д.
    function registration($post) {

        $login = clear_str($post['reg_login']);
        $password = trim($post['reg_password']);
        $conf_pass= trim($post['reg_password_confirm']);
        $email = clear_str($post['reg_email']);
        $name = clear_str($post['reg_name']);

        $msg = '';

        if(empty($login)) {
            $msg .= "Введите логин <br />";
        }
        if(empty($password)) {
            $msg .= "Введите пароль <br />";
        }
        if(empty($email)) {
            $msg .= "Введите адресс почтового ящика <br />";
        }
        if(empty($name)) {
            $msg .= "Введите имя <br />";
        }

        if($msg) {
            $_SESSION['reg']['login'] = $login;
            $_SESSION['reg']['email'] = $email;
            $_SESSION['reg']['name'] = $name; #если ввели неправильно или не всё, чтобы заново пользователь не вводил лог и т.д. отправляем сами это в форму
            return $msg;
        }

        if($conf_pass == $password) { #тут чтобы обратиться к базе , мы прописали префикс и название базы во фром
            $sql = "SELECT user_id
                        FROM ".PREF."users 
                        WHERE login='%s'";
            $sql = sprintf($sql,mysqli_real_escape_string ($login)); #тут заменить тоооочно блять а чё туда передать то

            $result = mysqli_query($sql);

            if(mysqli_num_rows($result) > 0) {
                $_SESSION['reg']['email'] = $email;
                $_SESSION['reg']['name'] = $name;

                return "Пользователь с таким логином уже существует";
            }

            $password = md5($password); #шифруем пароль
            $hash = md5(microtime()); #уже шифрованная строка которая будет использоваться для регистрации

            $query = "INSERT INTO".PREF."users (
                            name,
                            email,
                            password,
                            login,
                            hash
                            ) 
                        VALUES (
                            '%s',
                            '%s',
                            '%s',
                            '%s',
                            '$hash'
                        )";
            $query = sprintf($query, #выполняет запрос для вставки даннх в БД
                mysqli_real_escape_string($name),
                mysqli_real_escape_string($email),
                $password,
                mysqli_real_escape_string($login)
            );
            $result2 = mysqli_query($query);

            if(!$result2) {
                $_SESSION['reg']['login'] = $login;
                $_SESSION['reg']['email'] = $email;
                $_SESSION['reg']['name'] = $name;
                return "Ошибка при добавлении пользователя в базу данных".mysqli_error();
            }
            else {
                $headers = '';
                $headers .= "From: Admin <admin@mail.ru> \r\n";
                $headers .= "Content-Type: text/plain; charset=utf8";

                $tema = "registration";

                $mail_body = "Спасибо за регистрацию на сайте. Ваша ссылка для подтверждения  учетной записи: ".SITE_NAME."?action=registration&hash=".$hash;

                mail($email,$tema,$mail_body,$headers); #выше мы всё формировали, теперь вызвав эту функцию отправляем пользователю смс чтобы он перешёл по ссылке

                return TRUE;

            }
        }
        else {
            $_SESSION['reg']['login'] = $login;
            $_SESSION['reg']['email'] = $email;
            $_SESSION['reg']['name'] = $name;
            return "Вы не правильно подтвердили пароль";
        }

    }



