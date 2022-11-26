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
    <title>Add</title>
</head>
<body>
<?php
require_once ('param.php');
if(!isset($_POST['add'])){
?>
    <div class="form" align="center">
        <form action="add_accounting.php" method="post">
            <h3>Add accessories</h3>
            <input type="text" name="name" placeholder="Enter name accessories"><br><br>
            <input type="text" name="code" placeholder="Enter code accessories"><br><br>
            <select name="categories">
                <?php
                    $query_cat = "SELECT id, name FROM Categories";
                    $result_cat = mysqli_query($dbc,$query_cat) or die("Error Categories");
                    while ($next_cat = mysqli_fetch_array($result_cat))
                    {echo "<option value='".$next_cat['id']."'>".$next_cat['name']."</option>";}
                ?>
            </select><br><br>
            <input type="date" name="date"><br><br>
            <select name="responsible">
                <?php
                    $query_res = "SELECT id, surname FROM AdminUsers ";
                    $result_res = mysqli_query($dbc,$query_res) or die("Error Responsible!");
                    while($next = mysqli_fetch_array($result_res))
                    {echo "<option value = '".$next['id']."'>".$next['surname']."</option>"; }
                ?>
            </select><br><br>
            <textarea name="description" placeholder="Enter Description"></textarea><br><br>
            <input type="submit" name="add" value="ADD"><br><br>
        </form>
    </div>
<?php
}
else if (isset($_POST['add']) && !empty($_POST['name']) && !empty($_POST['code']) && !empty($_POST['categories']) && !empty($_POST['date']) && !empty($_POST['responsible']) && !empty($_POST['description']))
{

    /*$generator = new BarcodeGenerator(EncodeTypes::CODE_128, $_POST['code']);
    $generator->getParameters()->setResolution(200);
    $generator->getParameters()->getCaptionAbove()->setText("BARCODE's CAPTION");
    $generator->getParameters()->getCaptionAbove()->setVisible(true);
    $generator->getParameters()->getCaptionAbove()->getFont()->setStyle(FontStyle::ITALIC);
    $generator->getParameters()->getCaptionAbove()->getFont()->getSize()->setPoint(10);
    $generator->getParameters()->setResolution(200);
    $save_path = "barcodes/".time()."generate-barcode-caption.bmp";
    $generator->saveImageFormat($save_path, "BMP");
    */
    $generator = new BarcodeGenerator(EncodeTypes::CODE_128, "12367891011");
    $generator->getParameters()->setResolution(200);
    $generator->save("barcodes/generate-barcode.png");
    $query = "INSERT INTO Accounting (name, code, categories, date, responsible, description) VALUES ('".$_POST['name']."','".$_POST['code']."','".$_POST['categories']."','".$_POST['date']."','".$_POST['responsible']."','".$_POST['description']."')";
    $result = mysqli_query($dbc,$query) or die("Error, cannot to add!");
    echo "<div class='phrases' align='center'>Successfully added! </div><br> ";
    header("refresh:3;url=index.php");
}
else { echo "<div class='phrases' align='center'>Empty Fields! </div>";header("refresh:2;url=index.php"); }
?>
</body>
</html>
<?php }
else{echo "<div align='center'><h1>ERROR 404 NOT FOUND</h1></div>";header("refresh:2;url=../enter.php");}
    ?>