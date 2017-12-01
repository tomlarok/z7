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

    //$sciezka = $_COOKIE['sciezka'];
    $user = $_COOKIE['login'];
    //$sciezka = $user;
    $plik = $_POST['plik'];
    //$plik = 'jakisplik.txt';
    $file = $sciezka."/".$plik;
    /*
    echo $file;
    echo "</br>";
    echo $sciezka;
    echo "</br>";
    echo $plik;
    echo "</br>";
    */
    if (is_dir($sciezka."/".$plik)) { 
      rmdir($sciezka."/".$plik);
      echo "Usunięto ".$file;
      echo "jestem tutaj";
    }
    else if (is_file($sciezka."/".$plik)){
      unlink($sciezka."/".$plik);
      echo "Usunięto ".$file;
    }
    echo '<a href ="wyslij.php">Wstecz</a>';

?>
