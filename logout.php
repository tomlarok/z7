<?php

    session_start();

    session_unset();  //niszczenie sesji
// niszczenie COOOKIES
    setcookie('zalogowany', '', time() - 60*60*3);

    header('Location: index.php');

?>
