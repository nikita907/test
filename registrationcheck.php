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

function input_in_xml(){
    if(is_file("users.xml")){
        $nXML2= file_get_contents('users.xml');
        $sXML = new SimpleXMLElement($nXML2); //
        $user = $sXML->addChild("user");
        $user->addChild("Login",$_POST['Login']);
        $salt=generateSalt();
        $crypted=md5($_POST['Password'].($salt));
        $user->addChild('Salt',$salt);
        $user->addChild("Password",$crypted);
        $user->addChild("Email",$_POST['Email']);
        $user->addChild("Name",$_POST['Name']);
        $sXML->saveXML("users.xml");
    }
}
if ($_POST['Name'] && $_POST['Password']&& $_POST['ConfirmPassword'] && $_POST['Login']&& $_POST['Email']) {
    if (is_file('users.xml')) {
        $xml = simplexml_load_file("users.xml");
        foreach ($xml as $child) {
            if ($child->Login == $_POST['Login']) {
                ?><label class="errormessage">Пользователь с таким логином уже существует</label>
                <?php
                exit();
                break;
            } else if ($child->Email == $_POST['Email']) {
                ?><label class="errormessage">Пользователь с таким электронным адресом уже существует</label>
                <?php
                exit();
                break;
            }
        }
    }
    if ($_POST['Password'] != $_POST['ConfirmPassword']) {
        ?><label class="errormessage">Вы ввели неправильный повторный пароль</label>
    <?php
        exit();
    }
    else {
        if (!is_file('users.xml')) {
            /*$xml = new XMLWriter();
            $xml->formatOutput = True;
            $salt=generateSalt();
            $crypted=md5($_POST['Password'].($salt));
            $xml->openMemory();
            $xml->startDocument();
            $xml->startElement('User');
            $xml->writeElement("Login",$_POST['Login']);
            $xml->writeElement("Name",$_POST['Name']);
            $xml->writeElement("Email",$_POST['Email']);
            $xml->writeElement("Password",$crypted);
            $xml->writeElement("Salt",$salt);
            $xml->endElement();
            echo $xml->outputMemory();
            */
            $xml = new DOMDocument("1.0", "utf-8");
            $xml->formatOutput = True;
            $users = $xml->createElement('users');
            $xml->appendChild($users);
            $user = $xml->createElement('user');
            $user_login = $xml->createElement("Login", $_POST['Login']);
            $user->appendChild($user_login);
            $salt = generateSalt();
            $crypted = md5($_POST['Password'] . ($salt));
            $user_salt = $xml->createElement("Salt", $salt);
            $user->appendChild($user_salt);
            $user_password = $xml->createElement("Password", $crypted);
            $user->appendChild($user_password);
            $user_email = $xml->createElement("Email", $_POST['Email']);
            $user->appendChild($user_email);
            $user_name = $xml->createElement("Name", $_POST['Name']);
            $user->appendChild($user_name);
            $xml->save("users.xml");
            input_in_xml();
        } else {
            input_in_xml();
        }
        header('Location:authorisation.html');
}
}
else{
    ?><label class="errormessage">Не оставляйте поля пустыми</label>
    <?php
}
?>