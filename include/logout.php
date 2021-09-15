<?php
session_start();
unset($_SESSION['id']);
unset($_SESSION['usuario']);
unset($_SESSION['nombre']);
unset($_SESSION['apellido']);
header("location:../index.php");
?>