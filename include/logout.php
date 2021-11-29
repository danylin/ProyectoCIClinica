<?php
//El presente archivo tiene por objetivo desloguear al usuario actual y regresarlo al menu de ingreso de sesion.
session_start();
unset($_SESSION['id']);
unset($_SESSION['usuario']);
unset($_SESSION['nombre']);
unset($_SESSION['apellido']);
header("location:../index.php");
?>