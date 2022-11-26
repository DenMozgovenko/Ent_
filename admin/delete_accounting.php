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
    <title>Deleting?</title>
</head>
<body>
<?php
if (isset($_GET['id']) && !empty($_GET['id']) && !empty($_GET['name']))
{
    ?>
    <div align="center" class="del_form">
        <form action="delete_accounting.php" method="post">
            <input type="radio" name="choose" checked value="TaK">Taк<br>
            <input type="radio" name="choose" value="Hi"> Hi<br>
            <input type="hidden" name="id" value="<?=$_GET['id']?>"><br>
            <div id="button">
                <input type="submit" name="del" value="Видалити">
            </div>
        </form>
    </div>
    <?php
}
else if (isset($_POST['del']) && !empty($_POST['id']) && $_POST['choose'] == "TaK")
{
    require_once ('param.php');
    $query = "Delete from Accounting WHERE id =".$_POST['id'];
    $result = mysqli_query($dbc,$query) or die ("Неможливо видалити з бази данних");
    echo "<div align='center' class='phrases'>Успішно видалено!<br></div>";
    mysqli_close($dbc);
    header("refresh:2;url=index.php");
}
elseif($_POST['choose'] == "Hi") {echo "<div class='phrases' align='center'> Ви відмінили видалення! </div>"; header("refresh:2;url=index.php");}
else {echo "<div align='center' class='phrases'>Видалення не можливе<br></div>"; header("refresh:2;url=index.php");}
?>
</body>
</html>
<?php }
else{echo "<div align='center'><h1>ERROR 404 NOT FOUND</h1></div>";header("refresh:2;url=../enter.php");}
?>