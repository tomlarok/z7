<?php
  // Logowanie dla KLIENTA
    session_start();

    if ((!isset($_POST['login'])) || (!isset($_POST['password'])))
    {
        header('Location: index.php');
        exit();
    }

    require_once "connect.php";

    $ipaddress = $_SERVER["REMOTE_ADDR"]; // pobieranie nr IP od klienta

    $polaczenie = @new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno;
    }
    else
    {        // WARTOŚCI LOGIN i HASŁO Z FORMULARZA
        $login = $_POST['login'];
        $haslo = $_POST['password'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8"); //spr czy nie wstrzyknieto zapytania SQL, Wstawia encje HTMLa
        $haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");

      //function sprBlokade($login){
          $user = $login;
          $rezultat = mysqli_query ($polaczenie, "SELECT * FROM $db_name.logi WHERE login = '$user'");

          $wiersz = mysqli_fetch_array ($rezultat);
          $id = $wiersz [0];
          $data_godzina = $wiersz [1];
          $proby = $wiersz [2];
          $login = $wiersz [3];

          //$num_rows = mysqli_num_rows($slc);
          // Blokada konta
          if ($proby >= 3){
            $_SESSION['blad'] = '<span style="color:red">Konto zablokowane! Podałeś trzy razy błędne hasło!</span>';
            header('Location: index.php');
            exit();
            }
      //  }


        if ($rezultat = @$polaczenie->query(
        sprintf("SELECT * FROM users WHERE login='%s' AND haslo='%s'",
        mysqli_real_escape_string($polaczenie,$login),  //f zabezpiecza przez InjectSQL (- ' itp')
        mysqli_real_escape_string($polaczenie,$haslo))))
        {
            $ilu_userow = $rezultat->num_rows;
            if($ilu_userow>0)
            {

                            // dadanie ciacha
            //  $nick= $_POST['user'];
              $nick = $login;
              $zalogowany = true;
              setcookie('login', $nick, time() + 60*60*3);
              setcookie('zalogowany', $zalogowany, time() + 60*60*3);
                // Zalogowany w sesji
                $_SESSION['zalogowany'] = true;

                $wiersz = $rezultat->fetch_assoc();
                $_SESSION['id'] = $wiersz['id'];
                $_SESSION['user'] = $wiersz['login'];

                unset($_SESSION['blad']); //usuwanie zmiennej blad. Po loogwaniu jest niepotrzebna.
                $rezultat->free_result();


              //  header('Location: wyslij.php');
                // Zapis  do BD
                $user = $_SESSION['user']; //user login,
                /*
                 $upd = mysqli_query ($polaczenie, "UPDATE $db_name.logi SET data_godzina = NOW(), WHERE login = '$user' ");
                if($upd) echo "Rekord został zmieniony poprawnie ";
                        else echo "Błąd, nie udało się dodać nowego rekordu ";
                */
                $slc = mysqli_query ($polaczenie, "SELECT * FROM $db_name.logi WHERE login = '$user'");

                $num_rows = mysqli_num_rows($slc);
                if ($num_rows < 1){  // czy login jest w tabeli logi? czy jest to pierwsze logowanie?
                  $ins = mysqli_query ($polaczenie, "INSERT INTO $db_name.logi (data_godzina, login, proby) VALUES (NOW(), '$user', '0') ");
                  if($ins) echo "Rekord został dodany poprawnie. Log dodany.  ";
                      else echo "Błąd, nie udało się dodać nowego rekordu  ";
                    /*
                        if($ins) echo "Rejestracja zakończona poprawnie ";
                            else echo "Błąd rejestrcji ";
                            */
                  } else {
                    $upd = mysqli_query ($polaczenie, "UPDATE $db_name.logi SET data_godzina = NOW(), proby = 0 WHERE login = '$user' ");
                    if($upd) echo "Rekord został zmieniony poprawnie. Log daty aktualizowany ";
                            else echo "Błąd, nie udało się dodać nowego rekordu. Log daty  ";
                  }



                //$ins = mysqli_query ($polaczenie, "INSERT INTO $db_name.logi (data_godzina, login) VALUES (NOW(), '$user') ");


               /*
                $upd = mysqli_query ($polaczenie, "UPDATE $db_name.logi SET data_godzina = NOW(), IP = '$ipaddress' WHERE login = '$user' ");
                if($upd) echo "Rekord został zmieniony poprawnie ";
                        else echo "Błąd, nie udało się dodać nowego rekordu ";
                */
                //header('Refresh: 2; Location: wyslij.php');
              header('Location: wyslij.php');

            } else {

              //$user = $_SESSION['user']; //user login,
              mysqli_select_db ($polaczenie, $db_name);
              //$rezultat = mysqli_query ($polaczenie, "SELECT * FROM logi  WHERE login = '$user' ");

              $rezultat = mysqli_query ($polaczenie, "SELECT * FROM logi  WHERE login = '$login' ");


              $num_rows = mysqli_num_rows($rezultat);
              if ($num_rows < 1) // czy login jest w tabeli logi?
              {
                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                header('Location: index.php');
              }else{  // jeżeli jest login w tabeli

                $upd = mysqli_query ($polaczenie, "UPDATE $db_name.logi SET blad_log = NOW() WHERE login = '$login' ");
                if($upd) echo "Rekord został zmieniony poprawnie. Log daty nieudanego logowania zaaktualizowany ";
                        else echo "Błąd, nie udało się zmienić rekordu. Log daty nieudanego logowani niezmieniony ";

              /*
              function zmienProby($proby) {
                $proby = $proby +1; //$proby++;
                $upd = mysqli_query ($polaczenie, "UPDATE $db_name.logi SET proby = '$proby' WHERE login = '$user' ");
                if($upd) echo "Rekord został zmieniony poprawnie. Liczba błędnych prób logowania zwiększona  ";
                        else echo "Błąd, nie udało się zmienić rekordu. Liczba próbnie zmieniona  ";

                  $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                  header('Location: index.php');
              }
              */
              //$user = 'user';
              $wiersz = mysqli_fetch_array ($rezultat);
              $id = $wiersz [0];
              $data_godzina = $wiersz [1];
              $proby = $wiersz [2];
              $login = $wiersz [3];
              /*
                while ($wiersz = mysqli_fetch_array ($rezultat))
                {
                $id = $wiersz [0];
                $data_godzina = $wiersz [1];
                $proby = $wiersz [2];
                $login = $wiersz [3];
                }
                */
                if ($proby >= 3){
                  //echo"Podałeś trzy razy błędne hasło";
                  $_SESSION['blad'] = '<span style="color:red">Podałeś trzy razy błędne hasło!</span>';
                  header('Location: index.php');
                } else {
                  //zmienProby($proby);

                  //$proby = $proby + 1;
                  $proby++;
                  $upd = mysqli_query ($polaczenie, "UPDATE $db_name.logi SET proby = '$proby' WHERE login = '$user' ");
                  //if($upd) $_SESSION['blad'] = '<span style="color:red">Rekord został zmieniony poprawnie. Liczba błędnych prób logowania zwiększona  </span>';
                  if($upd) echo "Rekord został zmieniony poprawnie. Liczba błędnych prób logowania zwiększona  ";
                          //else $_SESSION['blad'] = '<span style="color:red">Błąd, nie udało się zmienić rekordu. Liczba prób nie zmieniona  </span>';
                          else echo "Błąd, nie udało się zmienić rekordu. Liczba prób nie zmieniona  ";

                    $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                    header('Location: index.php');

                }

              }


            }

        }

        $polaczenie->close();
    }

?>
