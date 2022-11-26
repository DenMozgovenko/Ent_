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
    <link href="style.css", rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Carefully</title>
</head>
<body>
<?php
require_once('param.php');
if(isset($_GET['id']) && !empty($_GET['id']))
{
    $query = "Select name,code,categories,date,responsible,description from Accounting WHERE id = ".$_GET['id'];
    $result = mysqli_query($dbc,$query) or die("Вийшла помилка,сбробуйте пізніше");
    $next = mysqli_fetch_array($result);
    ?>
    <div class="form" align="center">
        <form action="update_accounting.php" method="post" >
            <h2>Редагування</h2>
            <p>Назва</p>
            <input type="text" name="name" value="<?=$next['name']?>" size="50%"><br>
            <p>Код</p>
            <input type="text" name="code" value="<?=$next['code']?>" size="50%"><br>
            <p>Змінити категорію</p>
            <select name="categories">
                <?php
                $query_cat = "SELECT id, name FROM Categories";
                $result_cat = mysqli_query($dbc,$query_cat) or die("Помилка з'єднання");
                while ($next_cat = mysqli_fetch_array($result_cat))
                {
                    if ($next['categories'] == $next_cat['id'])
                    {
                        echo "<option selected value='".$next_cat['id']."'>".$next_cat['name']."</option>";
                    }
                    else
                    {
                        echo "<option value = '".$next_cat['id']."'>".$next_cat['name']."</option>";
                    }
                }
                ?>
            </select><br>
            <p>Дата</p>
            <input type="date" name="date" value="<?=$next['date']?>"><br>
            <p>Відповідальний</p>
            <select name="responsible">
                <?php
                $query_res = "SELECT id,name,surname FROM AdminUsers";
                $result_res= mysqli_query($dbc,$query_res) or die("Unreachable database!");
                while($next_res = mysqli_fetch_array($result_res))
                {
                    if ($next['responsible'] == $next_res['id'])
                    {
                        echo "<option selected value='".$next_res['id']."'>".$next_res['surname']."&nbsp;".$next_res['name']."</option>";
                    }
                    else
                    {
                        echo "<option value='".$next_res['id']."'>".$next_res['surname']."&nbsp;".$next_res['name']."</option>";
                    }
                }
                ?>
            </select><br>
            <p>Опис</p>
            <textarea name="description" cols="39" rows="3"><?=$next['description']?></textarea><br>
            <div id="button">
                <input type="submit" name="save" value="Зберегти"><br>
            </div>
            <input type="hidden" name="id" value="<?=$_GET['id']?>">
        </form>
    </div>
    <?php
}
else if (isset($_POST['save']) && !empty($_POST['id']) && !empty($_POST['name']) && !empty($_POST['code']) && !empty($_POST['categories']) && !empty($_POST['date']) && !empty($_POST['responsible'] && !empty($_POST['description'])))
{
    $query = "UPDATE Accounting SET name = '" . $_POST['name'] . "' , code = '" . $_POST['code'] . "' , categories = '" . $_POST['categories'] . "' , date = '".$_POST['date']."', responsible = '".$_POST['responsible']."' , description = '" . $_POST['description'] . "' WHERE id = " . $_POST['id'];
    $result = mysqli_query($dbc, $query) or die ("Вийшла помилка,спробуйте пізніше");
    echo "<div align='center' class='phrases'>Успішно відредаговано!</div><br><br>";
    header("refresh:2;url=index.php");
}
else
{
    echo "<div align='center' class='phrases'>Не можливо відредагувати<br></div>";
    header("refresh:2;url=index.php");
}
mysqli_close($dbc);
?>
</body>
</html>
<?php }
else{echo "<div align='center'><h1>ERROR 404 NOT FOUND</h1></div>";header("refresh:2;url=../enter.php");}
?>