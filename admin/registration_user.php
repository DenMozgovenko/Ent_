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
?>
<!doctype html>
<html lang="ua">
<head>
    <link href="style.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ordinary User?</title>
</head>
<body>
<?php
require_once ('param.php');
if (!isset($_POST['register'])){
    ?>
    <div align="center" class="form">
        <form action="registration_user.php" method="post">
            <h3>Registration new user</h3>
            <input type="text" name="name" placeholder="Enter name"><br><br>
            <input type="text" name="surname" placeholder="Enter surname"><br><br>
            <input type="text" name="mail" placeholder="Enter mail"><br><br>
            <input type="text" name="phone" placeholder="Enter phone"><br><br>
            <input type="password" name="password1" placeholder="Enter password"><br><br>
            <input type="password" name="password2" placeholder="Repeat password"><br><br>
            <input type="submit" name="register" value="Registration">
        </form>
    </div>
    <?php
}
elseif (isset($_POST['register']) && !empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['mail']) && !empty($_POST['phone']) && !empty($_POST['password1']) && !empty($_POST['password2']) && $_POST['password1'] == $_POST['password2'])
{
    $query = "INSERT INTO Users (name, surname, mail, phone, password) VALUES ( '".$_POST['name']."' , '".$_POST['surname']."' , '".$_POST['mail']."' , '".$_POST['phone']."' , SHA1('".$_POST['password2']."'))";
    $result = mysqli_query($dbc, $query) or die("Помилка при внесенні даних до бази!");
    echo "<div class='phrases' align='center'>Succesfully Added!</div>";
    header("refresh:2;url=index.php");
    mysqli_close($dbc);
}
else {echo "<div class='phrases' align='center'>Empty fields!</div>";header("refresh:2;url=index.php");}
?>
</body>
</html>
<?php }
else{echo "<div align='center'><h1>ERROR 404 NOT FOUND</h1></div>";header("refresh:2;url=../enter.php");}
?>