<?php
session_start();
if (isset($_COOKIE['id']) && isset($_COOKIE['name']) && isset($_COOKIE['surname']) && isset($_COOKIE['phone']))
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
    <title>List</title>
</head>
<body>
<?php
echo "<div class='link' align='right'><a href='add_accounting.php'> Додати предмет в базу </a>&nbsp;&nbsp;&nbsp;<a href='registration.php'>Зарєєструвати адміністратора</a></div><div class='link' align='right'><a href='registration_user.php'>Зареєструвати користувача</a>&nbsp;&nbsp;&nbsp;<a href='exit.php'>Вихід</a></div>
<div class='search' align='center'>
<form action='index.php' method='post'>
    <input size='100%' type='text' name='search' placeholder='Пошук'> 
    <div id='btn_srch'><input type='submit' name='btn_search' value='Пошук'></div>
</form>
</div><br>";
require_once ('param.php');
echo "<div class='link' align='center'>";
$query_cat = "Select id, name from Categories";
$result_cat = mysqli_query($dbc,$query_cat) or die("Неможлива операція");
while ($next_cat = mysqli_fetch_array($result_cat))
{
    echo "<a href='index.php?id_cat=".$next_cat['id']."'>".$next_cat['name']."</a>&nbsp;&nbsp;";
}
echo "<a href='index.php'>Всі категорії</a>";
echo "</div><br>";
$poster = 10;
if (isset($_GET['id_cat']) && !empty($_GET['id_cat']))
{
    $query_list = "Select id from Accounting WHERE categories =".$_GET['id_cat'];
}
else
{
    $query_list = "Select id from Accounting";
}
$result_list = mysqli_query($dbc,$query_list) or die("Неможлива операція!");
$counter = mysqli_num_rows($result_list);
$pages = ceil($counter/$poster);
if (isset($_GET['page']))
{
    $active_page = $_GET['page'];
}
else
{
    $active_page = 1;
}
$skip = ($active_page - 1)* $poster;
if (isset($_GET['sort']) && !empty($_GET['sort']))
{
    $sort = $_GET['sort'];
}
switch ($sort)
{
    case "ASC":
        $sort = "DESC";
        break;
    case "DESC":
        $sort = "ASC";
        break;
    default:
        $sort = "ASC";
}
if (isset($_GET['id_cat']) && !empty($_GET['id_cat']))
{
    echo "<table align='center' class='mytable'>
<tr>
<th>N</th>
<th ><a href = 'index.php?sort=".$sort."&id_cat=".$_GET['id_cat']."' > Назва</a ></th >
<th>Код</th>
<th>Категорія</th>
<th>Початок експлуатації</th>
<th>Відповідальний</th>
<th>Опис</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
</tr>";
}
else
{
    echo "<table align='center' class='mytable' class='mytable'>
<tr>
<th>N</th>
<th ><a href = 'index.php?sort=" . $sort . "' > Назва</a ></th >
<th>Код</th>
<th>Категорія</th>
<th>Початок експлуатації</th>
<th>Відповідальний</th>
<th>Опис</th
<th>&nbsp;</th>
<th>&nbsp;</th>
</tr>";
}
if (isset($_GET['id_cat']))
{
    $query = "Select id,name,code,categories,date,responsible,description from Accounting WHERE categories=".$_GET['id_cat']." ORDER BY name $sort limit $skip,$poster";
}
else if (isset($_POST['btn_search']) && !empty($_POST['search']))
{
    $query="Select id,name,code,categories,date,responsible,description from Accounting WHERE name LIKE '%".$_POST['search']."%' OR code LIKE '%".$_POST['search']."%'";
}
else
{
    $query = "Select id,name,code,categories,date,responsible,description from Accounting ORDER BY name $sort limit $skip,$poster";
}
$result = mysqli_query($dbc,$query) or die("Виникла помилка!");
$n = 1;
while($next = mysqli_fetch_array($result))
{
    $query_cat = "SELECT name from Categories WHERE id = '".$next['categories']."'";
    $result_cat = mysqli_query($dbc,$query_cat) or die("Помилка");
    $next_cat = mysqli_fetch_array($result_cat);
    $query_res = "SELECT name, surname from AdminUsers WHERE id = ".$next['responsible'];
    $result_res = mysqli_query($dbc,$query_res) or die("Error User");
    $next_res = mysqli_fetch_array($result_res);
    echo "<tr>
<td>$n</td>
<td>".$next['name']."</td>
<td>".$next['code']."</td>
<td>".$next_cat['name']."</td>
<td>".$next['date']."</td>
<td>".$next_res['surname']."&nbsp;".$next_res['name']." </td>
<td>".$next['description']."</td>
<td><a href='update_accounting.php?id=".$next['id']."'>Редагувати</a></td>
<td><a href='delete_accounting.php?id=".$next['id']."&name=".$next['name']."'>Видалити</a></td>
</tr>";
    $n++;
}
echo "</table>";
if (isset($sort) && $sort == "DESC")
{
    $sort = "ASC";
}
else
{
    $sort = "DESC";
}
echo "<table class='poster' align='center'><tr>";
if ($active_page == 1)
{
    echo "<td><<&nbsp;&nbsp;&nbsp;</td>";
}
else
{
    if (isset($_GET['id_cat']) && !empty($_GET['id_cat']))
    {
        echo "<td><a href='index?page=1&id_cat=" . $_GET['id_cat'] . "&sort=".$sort."'><<</a>&nbsp;&nbsp;&nbsp;</td>";
        echo "<td><a href='index.php?page=" . ($active_page - 1) . "&id_cat=" . $_GET['id_cat'] . "&sort=".$sort."'><</a>&nbsp;&nbsp;&nbsp;</td>";
    }
    else
    {
        echo "<td><a href='index.php?page=1&sort=".$sort."'><<</a>&nbsp;&nbsp;&nbsp;</td>";
        echo "<td><a href='index.php?page=".($active_page - 1)."&sort=".$sort."'><</a>&nbsp;&nbsp;&nbsp;</td>";
    }
}
for ($i=1;$i<=$pages;$i++)
{
    if ($i == $active_page)
    {
        echo "<td>".$i."&nbsp;&nbsp;&nbsp;</td>";
    }
    else
    {
        if (isset($_GET['id_cat']) && !empty($_GET['id_cat']))
        {
            echo "<td><a href='index.php?page=" . $i . "&id_cat=" . $_GET['id_cat'] . "&sort=".$sort."'>" . $i . "</a>&nbsp;&nbsp;&nbsp;</td>";
        }
        else
        {
            echo "<td><a href='index.php?page=".$i."&sort=".$sort."'>".$i."</a>&nbsp;&nbsp;&nbsp;</td>";
        }
    }
}
if ($active_page == $pages)
{
    echo "<td>>>&nbsp;&nbsp;&nbsp;</td>";
}
else
{
    if (isset($_GET['id_cat']) && !empty($_GET['id_cat']))
    {
        echo "<td><a href='index.php?page=" . ($active_page + 1) . "&id_cat=" . $_GET['id_cat'] . "&sort=".$sort."'>></a>&nbsp;&nbsp;&nbsp;</td>";
        echo "<td><a href='index.php?page=" . $pages . "&id_cat=" . $_GET['id_cat'] . "&sort=".$sort."'>>></a>&nbsp;&nbsp;&nbsp;</td>";
    }
    else
    {
        echo "<td><a href='index.php?page=".($active_page + 1)."&sort=".$sort."'>></a>&nbsp;&nbsp;&nbsp;</td>";
        echo "<td><a href='index.php?page=".$pages."&sort=".$sort."'>>></a>&nbsp;&nbsp;&nbsp;</td>";
    }
}
echo "</tr></table>";

mysqli_close($dbc);
?>
</body>
</html>
<?php }
else {echo"<div align='center'><h1>ERROR 404 NOT FOUND</h1></div>";header("refresh:2;url=../enter.php");}
?>