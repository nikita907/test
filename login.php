<?php

function generateSalt()
{
    $salt = '';
    $saltLength = 8;
    for($i=0; $i<$saltLength; $i++) {
        $salt .= chr(mt_rand(33,126));
    }
    return $salt;
}

if ($_POST['a_login']!=""|| $_POST['a_password']!="") {
    $xml = simplexml_load_file("users.xml");
    foreach ($xml as $child) {
        if ($child->Login == $_POST['a_login']) {
            $user_salt = $child->Salt;
            $user_password = $_POST['a_password'];
            $crypted = md5($user_password . $user_salt);
            if ($crypted == $child->Password) {
                session_start();
                $_SESSION['auth'] = True;
                $_SESSION['login'] = $_POST['a_login'];
                if (!empty($_POST['rememberme']) and $_POST['rememberme'] == 1) {
                    //Сформируем случайную строку для куки
                    $key = generateSalt(); //назовем ее $key

                    //Пишем куки (имя куки, значение, время жизни - сейчас+месяц)
                    setcookie('login', $_POST['a_login'], time() + 60 * 60 * 24 * 30); //логин
                    setcookie('key', $key, time() + 60 * 60 * 24 * 30); //случайная строка
                    $cookie = $child->addChild("cookie", $key);
                    $xml->saveXML("users.xml");
                }
                echo "Hello"." ".$child->Name;
                ?><a href="logout.php">Выйти</a><?php
            }
            else {
                ?><label class="errormessage">Неверный пароль</label>
                <a href="authorisation.html">Исправить</a>
                <?php
                exit();
                break;
            }
        }
    }
    if($_SESSION['auth']==False){
        ?><label class="errormessage">Пользователя с таким логином не существует</label>
        <a href="authorisation.html">Исправить</a>
        <?php
    }
}
else{
?><label class="errormessage">Не оставляйте поля пустыми</label>
<a href="authorisation.html">Исправить</a>
<?php
}
?>
