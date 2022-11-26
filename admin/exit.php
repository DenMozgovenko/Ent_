<?php
session_start();
?>
    <!doctype html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>EXIT</title>
    </head>
    <body>
<?php
if (isset($_COOKIE['id'])) {setcookie("id","",time()-7200);}
if (isset($_COOKIE['name'])) {setcookie("name","",time()-7200);}
if (isset($_COOKIE['surname'])) {setcookie("surname","",time()-7200);}
if (isset($_COOKIE['surname'])) {setcookie("phone","",time()-7200);}
if (isset($_COOKIE[session_name()])) {setcookie(session_name(),"",time()-7200);}
$_SESSION = array();
session_destroy();
header("refresh:0;url=../enter.php")
?>