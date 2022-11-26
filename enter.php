<?php
session_start();
?>
<!doctype html>
<html lang="ua">
<head>
    <link href="style.css", rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In</title>
</head>
<body>
<?php
if (!isset($_POST['enter']))
{
    ?>
    <div class="link" align="right"><a href="admin/enter_admin.php">Увійти як адмін!</a></div>
    <div class="form" align="center">
    <form action="enter.php" method="post">
        <p>Введіть логін</p>
        <input type="text" name="login"><br>
        <p>Введіть пароль</p>
        <input type="password" name="pass"><br><br>
        <div class="button">
            <input type="submit" name="enter" value="Увійти"><br>
        </div><br><br>
    </form>
    </div>
    <?php
}
else if (isset($_POST['enter']) && !empty($_POST['login']) && !empty($_POST['pass']))
{
    require_once ('admin/param.php');
    $query = "Select id, name from Users WHERE surname = '".$_POST['login']."' and password = SHA1('".$_POST['pass']."')";
    $result  = mysqli_query($dbc,$query) or die("Помилка з'єднання!");
    if (mysqli_num_rows($result) == 1)
    {
        $next=mysqli_fetch_array($result);
        setcookie("id",$next['id'],time()+60*60*24*30*2);
        setcookie("name",$next['name'],time()+60*60*24*30*2);
        $_SESSION['id'] = $next['id'];
        $_SESSION['name'] = $next['name'];
        header("refresh:0;url=index.php");
    }
    else
    {
        echo "<div class='phrases'>Hе збігаються логін з паролем<br></div>";
        header("refresh:3;url=enter.php");
    }
    mysqli_close($dbc);
}
else
{
    echo "<div class='phrases'>Є пусті поля<br></div>";
    header("refresh:3;url=enter.php");
}
?>
</body>
</html>