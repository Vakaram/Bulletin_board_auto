<?php #основная и единственная точка входа на сайт, общение с сайтом
header("Content-Type:text/html;charset=UTF-8");

session_start();#сессия работаем с ней обязательно( будем ещё хранить различные сообщения хз какие конечно)

require_once "config.php";#подключаем необходимые файлы
require_once "functions.php";#подключаем необходимые файлы

db(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);#будет выполнять подключение базы данных

#$categories#категории массив
#$razd= #типы, предложения и спрос в моём случае
#$user = # должны получить данные о пользователе если он авторизовался

#теперь надо определить какой актион загрузить исходя из запроса пользователя
$action = clear_str($_GET['action']);#эту штуку надо чистить каждый раз очищать запрос как бы. #будем запрос записывать из get local/bulletin_bord_auto/?action = main(главная страница)
if(!$action ){
    $action = "main";
}

#Теперь проверим а если есть такой фалй, то мы файл загрузи = )
if(file_exists(ACTIONS.$action.".php")){ #если есть значит подгружаем
    include ACTIONS.$action.".php";
}
else {
    ACTIONS."main.php"; #Если нет файла
}

#подключаем шаблон
require_once TEMPLATE."/index.php";






















