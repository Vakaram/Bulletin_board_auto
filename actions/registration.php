<?php


if(isset($_POST['reg'])) {

    $msg = registration($_POST);

    if($msg === TRUE) {
        $_SESSION['msg'] = "Вы успешно зарегистрировались на сайте. И для подтвержения регистрации  Вам на посту отправлено писмо с инструкциями.";
    }
    else {
        $_SESSION['msg'] = $msg;
    }

    header("Location:".$_SERVER['PHP_SELF']);
    exit();
}


$content = render(TEMPLATE . "registration.tpl", array("title" => "hello"));



