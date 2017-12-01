<?php

    session_start();

    if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
    {
      /*
        header('Location: klient_app.php');
        exit(); //wyjscie z strony bez wczytania ponizszych linije kodu
        */
    } else{
        header('Location: index.php');
        exit(); //wyjscie z strony bez wczytania ponizszych linije kodu
    }
// dostęp gdy jest ciastko
    if((isset($_COOKIE['zalogowany'])) && ($_COOKIE['zalogowany']==true)) {
      /*
        header('Location: klient_app.php');
        exit(); //wyjscie z strony bez wczytania ponizszych linije kodu
        */
    } else{
        header('Location: index.php');
        exit(); //wyjscie z strony bez wczytania ponizszych linije kodu
    }

?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8">
<title>Koralewski</title>

<link rel="stylesheet" href="./styles.css">
</head>

  <body>

  <!--
    <p align = "right">
      <a href = "./rejestracja.php">Rejestracja</a>
    </p>
    -->

<p align = "right">
  <a href = "./logout.php">Wyloguj</a>
</p>

<h2 class = "logowanieNapis">Wyślij plik</h2>


<form action="odbierz.php" method="POST"
    ENCTYPE="multipart/form-data">
    <input type="file" name="plik"/>
    <input type="submit" value="Wyślij plik"/>
    </form>

<br>
<?php
    require_once "connect.php";
    $polaczenie = @new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno;
    }
    else{
      /*
      // WARTOŚCI LOGIN i HASŁO Z FORMULARZA
          $login = $_POST['login'];
          $haslo = $_POST['password'];
          */
          $user = ($_COOKIE['login']);
          $rezultat = mysqli_query ($polaczenie, "SELECT proby, blad_log FROM $db_name.logi WHERE login = '$user'");
          $wiersz = mysqli_fetch_array ($rezultat);
          $proby = $wiersz [0];
          $blad_log = $wiersz [1];
          /*
          $id = $wiersz [0];
          $data_godzina = $wiersz [1];
          $proby = $wiersz [2];
          $login = $wiersz [3];
          */
        
          echo "Ostatnie nieudane logowanie: ";
          echo $blad_log;
          /*
          $wiersz = $rezultat->fetch_assoc();
          $_SESSION['id'] = $wiersz['id'];
          $_SESSION['user'] = $wiersz['login'];
          */
          //0000-00-00 00:00:00
    }


?>


<?php
if(isset($_SESSION['blad']))    echo $_SESSION['blad'];

?>

</body>
</html>
