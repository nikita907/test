<?php
session_start();
if (!empty($_COOKIE['login']))
{
header("Location:ifauthorisate.php");
}
?>
<html lang="en">
<head>
    <noscript><meta http-equiv="refresh" content="0;url=nojs.html"></noscript>
    <link href="test.css" rel="stylesheet" type="text/css">
    <script src="jquery-3.5.1.min.js"></script>
    <script type="text/javascript">
        function AjaxFormRequest(result_id,form_id,url) {
            jQuery.ajax({
                url:     "registrationcheck.php", //Адрес подгружаемой страницы
                type:     "POST", //Тип запроса
                dataType: "html", //Тип данных
                data: jQuery("#"+form_id).serialize(),
                success: function(response) { //Если все нормально
                    document.getElementById(result_id).innerHTML = response;
                },
                error: function(response) { //Если ошибка
                    document.getElementById(result_id).innerHTML = "Ошибка при отправке формы";
                }
            });
        }

    </script>
</head>
<body>
   <form id="register"  action="" method="post">
       <div id="result_div_id">
           <em></em>
       <label>Login:</label></br>
       <input type="text" name="Login" placeholder="Please,create login"></br>
       <label>Password:</label></br>
       <input type="text" name="Password" placeholder="Please,create password"></br>
       <label>Confirm Password:</label></br>
       <input type="text" name="ConfirmPassword" placeholder="Please,confirm your password"></br>
       <label>Email:</label></br>
       <input type="text" name="Email" placeholder="Please,enter your email"></br>
       <label>Name:</label></br>
       <input type="text" name="Name" placeholder="Please,enter your Name"></br></br>
       <input type="button" name="Done" value="Отправить" onclick="AjaxFormRequest('result_div_id', 'register', 'registrationcheck.php')" />
       </div>
   </form>
</body>
</html>
