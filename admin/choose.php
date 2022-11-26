<?php
session_start();
if (isset($_COOKIE['id']) && $_COOKIE['name'] && $_COOKIE['surname'] && $_COOKIE['phone'])
{
    $_SESSION['id'] = $_COOKIE['id'];
    $_SESSION['name'] = $_COOKIE['name'];
    $_SESSION['surname'] = $_COOKIE['surname'];
    $_SESSION['phone'] = $_COOKIE['phone'];
}
if (isset($_SESSION['id']) && isset($_SESSION['name']) && isset($_SESSION['surname']) && isset($_SESSION['phone']))
{
?><!doctype html>
<html lang="ua">
<head>
    <link href="style.css", rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Choose..</title>
</head>
<body>
    <div align="center" class="links_1">
        <a href="add_accounting.php">Додати інвентар</a>
        <a href="index.php">Переглянути інвентар</a>
        <a href="exit.php">Вихід</a>
    </div>
</body>
</html>
<?php }
else{echo "<div align='center'><h1>ERROR 404 NOT FOUND</h1></div>";header("refresh:2;url=../enter.php");}
?>