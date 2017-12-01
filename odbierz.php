<?php

//session_start();
/*
if ((!isset($_POST['login'])) || (!isset($_POST['password'])))
{
    header('Location: index.php');
    exit();
}
*/
/*
if (is_uploaded_file($_FILES['plik']['tmp_name']))
{
echo 'Odebrano plik: '.$_FILES['plik']['name'].'<br/>';
move_uploaded_file($_FILES['plik']['tmp_name'],
$_SERVER['DOCUMENT_ROOT'].$_FILES['plik']['name']);
}
else {echo 'Błąd przy przesyłaniu danych!';}
*/
////
//  $user = $_SESSION['user']; //user login,
  $user = $_COOKIE['login'];

$sciezka = 'z7/'.$user.'/';
$max_rozmiar = 1000;
if (is_uploaded_file($_FILES['plik']['tmp_name']))
{
if ($_FILES['plik']['size'] > $max_rozmiar) {echo "Przekroczenie rozmiaru $max_rozmiar"; }
else
{echo 'Odebrano plik: '.$_FILES['plik']['name'].'<br/>';
if (isset($_FILES['plik']['type'])) {echo 'Typ: '.$_FILES['plik']['type'].'<br/>'; }
move_uploaded_file($_FILES['plik']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$sciezka.$_FILES['plik']['name']);
//move_uploaded_file($_FILES['plik']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$_FILES['plik']['name']);
}
}
else {echo 'Błąd przy przesyłaniu danych!';}
echo '</br><a href = "wyslij.php">Wstecz</a>';



?>
