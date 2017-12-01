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

    $file = $_POST['plik'];
    $user = $_COOKIE['login'];
    //$sciezka = $_COOKIE['sciezka'];
    $sciezka = $user;
    $sciezka = $sciezka.'/'.$file;
    //setcookie('sciezka', $sciezka, time() + 60*60*3);
    $_SESSION['sciezka'] = $sciezka;
    header('Location: wyslij.php');

?>
