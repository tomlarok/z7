<?php

    session_start();
    /*
    if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
    {
      //  header('Location: klient_app.php');
        exit(); //wyjscie z strony bez wczytania ponizszych linije kodu
    }
*/

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

<h2 class = "logowanieNapis">Logowanie</h2>


<form method="POST" action="logowanie.php">
<br>

Login: <input type="text" name="login" maxlength="20" size="20"><br>
Hasło: <input type="password" name="password" maxlength="20" size="20"><br>
<input type="submit" value="Zaloguj się"/>
</form>

<br>


<?php
if(isset($_SESSION['blad']))    echo $_SESSION['blad'];

?>

</body>
</html>
