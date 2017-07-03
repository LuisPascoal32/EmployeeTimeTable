<?php
session_start();


$login = $_POST['email'];
$senha = $_POST['password'];

echo $login . $senha ;
if ($login == "aideal_leixoes@hotmail.com" && $senha == "qw12eridkfa") {
    echo "yo";
    $_SESSION['email'] = $login;
    header('location:index.php');
} else {
    session_destroy();
    header('location:login.php'); //redirecciona para pagina de login
}
