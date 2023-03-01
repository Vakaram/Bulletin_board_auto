<?php #основная и единственная точка входа на сайт, общение с сайтом
header("Content-Type:text/html;charset=UTF-8");

session_start( );#сессия работаем с ней обязательно( будем ещё хранить различные сообщения хз какие конечно)

require_once "config.php";#подключаем необходимые файлы
require_once "functions.php";#подключаем необходимые файлы

db(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);#будет выполнять подключение базы данных















