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

<h2 class = "logowanieNapis">Utwórz katalog</h2>


<form action="utworz.php" method="POST">
    <input type="text" name="nazwa_katalogu" maxlength="20" size="20"/>
    <input type="submit" value="Utwórz katalog"/>
    </form>

<br>
<?php
    require_once "connect.php";

    //  $user = $_SESSION['user']; //user login,
    /*
      $user = $_COOKIE['login'];
      // ustalenie aktualnej ścieżki dla unsera
      $sciezka = $user;
      setcookie('sciezka', $sciezka, time() + 60*60*3);
      */

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
          // ustalenie aktualnej ścieżki dla usera
          //$sciezka = ($_COOKIE['sciezka']);
          $sciezka = ($_SESSION['sciezka']);
          $plikcookie = ($_COOKIE['plik']);
          //setcookie('sciezka', $sciezka, time() + 60*60*3);

          $rezultat = mysqli_query ($polaczenie, "SELECT proby, blad_log FROM $db_name.logi WHERE login = '$user'");
          $wiersz = mysqli_fetch_array ($rezultat);
          $proby = $wiersz [0];
          $blad_log = $wiersz [1];
          /*
          $id = $wiersz$nazwa_katalogu [0];
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
    echo '</br>';
    // listowanie katalogów

    // z7:
/*
    if ($handle = opendir('.')) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
              if (is_dir($file)) {
              //  echo '</br><a href = "/" ';
                //echo "<dir>".$file."\n";
                echo "$file\n";
                echo " [dir]";
                echo '  <a href = "wyslij.php">Otwórz</a>';



                echo "</br>";
              //  echo '<button id = "button" onclick="">Otwórz</button> </br>';

              //  setcookie('sciezka', $sciezka, time() + 60*60*3);
              }else{
                //echo "$file\n";
                echo "$file";
                // Opcja pobierz

                echo "</br>";
              }
              ///  echo "$file\n";
              //  echo "</br>";
            }

        }
        closedir($handle);
    }
*/
    // listowanie katalogu użytkownika
/*
    //  $user = $_SESSION['user']; //user login,
      $user = $_COOKIE['login'];
*/
  //TODO if sciezka jest pusta to $sciezka = $user
    $sciezka = $user;
    echo "</br> Pliki ".$user.": </br>";
    print "<TABLE CELLPADDING=5 BORDER=1>";

    if ($handle = opendir($sciezka)) {  //nie rozroznia katalogu
        while (false !== ($file = readdir($handle))) {
            if ($file != $sciezka && $file != "..") {
              if (is_dir($file)) {
              //  echo '</br><a href = "/" ';
                //echo "<dir>".$file."\n";
                print "<tr><td>";
                echo "$file\n";
                echo " [dir]";
                print "</td><td>";
                echo '  <a href = "wyslij.php">Otwórz</a>';
                print "</td></tr>";
              //  echo "</br>";
              }else{
                //echo "$file\n";
                print "<tr><td>";
                echo "$file";
                // Opcja pobierz
                  print "</td><td>";
                  print '
                  <form method="post" action="pobierz.php">
                  <input type="hidden" name="plik';
                  //echo $file;
                  print '" value="';
                  echo $file;
                  print '"/>';
                  print '<input type="submit" value="Pobierz" name="submit"></form>';

                  // Opcja usuń
                    print "</td><td>";
                    print '
                    <form method="post" action="usun.php">
                    <input type="hidden" name="plik';
                    //echo $file;
                    print '" value="';
                    echo $file;
                    print '"/>';
                    print '<input type="submit" value="Usun" name="submit"></form>';

                  print "</td></tr>";
              //  echo "</br>";
              }
              ///  echo "$file\n";
              //  echo "</br>";
            }

        }
        closedir($handle);
    }
    print "</TABLE>";
    echo "</br></br></br>";
    print '<div id="lista_plikow">';
  //  print '<form method="POST" action="logowanie.php">';

    if ($handle = opendir($sciezka)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                echo '<input type="radio" name="plik" id = "plik" value="$file">';
                echo "$file\n";
                echo '</input>';
                echo "</br>";
            }
        }
        closedir($handle);
    }

    $file = 'jakisplik.txt'; //terst dla ustalonego pliku
    print '<input type="button" id = "button" value="Otworz"  onclick="open();"/>';
  //  print '</form>';
    print '</div>';
    echo '<a href = "pobierz.php">Pobierz</a>';
    echo "  ";
    echo '<a href = "utworz.php">Utwórz</a>';
    echo "  ";
    echo '<a href = "usun.php">Usuń</a>';

    print '
    <form method="post" action="pobierz.php">
    <input type="hidden" name="plik';
    //echo $file;
    print '" value="';
    echo $file;
    print '"/>';
    print '<input type="submit" value="Pobierz" name="submit"></form>';

    /*
    $sciezka = $user;
    echo "</br> Pliki ".$user.": </br>";

    print '<form method="POST" action="logowanie.php">';

    if ($handle = opendir($sciezka)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                echo "$file\n";
                echo "</br>";
            }
        }
        closedir($handle);
    }
    print '</form>';
    */
/*
Przykład #1 Przykład użycia scandir()e
<?php
$dir    = '/tmp';
$files1 = scandir($dir);
$files2 = scandir($dir, 1);

print_r($files1);
print_r($files2);
?>
*/

?>


<?php
if(isset($_SESSION['blad']))    echo $_SESSION['blad'];

?>
    <script>

    function open(){
            var button = document.getElementById('button');
            //var plik = document.getElementById('plik');
            button.addEventListener('click', function(e) {
            var lista_plikow = document.getElementsByName('plik');
            var plik_value;
            alert("Hej!");
            for(var i = 0; i < lista_plikow.length; i++){
                if(lista_plikow[i].checked){
                    plik_value = lista_plikow[i].value;
                    document.cookie = "plik=" + plik_value +";";
                    //document.cookie = "sciezka=John Doe";
                    //document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                }
            };
          })
          }
/*
            var rates = document.getElementsByName('rate');
var rate_value;
for(var i = 0; i < rates.length; i++){
    if(rates[i].checked){
        rate_value = rates[i].value;
    }
}
*/
  /*
            button.addEventListener('click', function(e) {
              if(plik)
              //alert("Hej!");
              //document.cookie = "sciezka=John Doe";
            });
            */



    </script>

</body>
</html>
