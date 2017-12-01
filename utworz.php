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
    $sciezka = $user;
    $nazwa_katalogu = $_POST['nazwa_katalogu']; //Nie towrzy katalogu!!!
    //$nazwa_katalogu = "katalog";
    // mkdir — Makes directory The mode is 0777 by default, which means the widest possible access
    if (!file_exists($sciezka."/".$nazwa_katalogu)) {
    mkdir($sciezka."/".$nazwa_katalogu, 0700);
    echo "Utworzono katalog".$nazwa_katalogu;
  }else{
    echo " Katalog o takiej nazwie już istnieje ";
  }
    //mkdir("/path/to/my/dir", 0700);
    /*
    // Pobieranie pliku
    $file = 'jakisplik.txt';
    $user = $_COOKIE['login'];
    $file = $user.'/'.$file;

    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');  //The basename() function returns the filename from a path.
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else{
      echo "Nie ma takiego pliku ";
    }
    */
?>
