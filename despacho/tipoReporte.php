<?php
session_start();
include("../include/bd_usuario.php");
$id=$_GET['codigo'];
$encuentro=$_GET['encuentro'];
$actualizar="UPDATE sop__evento_acc_db SET codigo_cierre=$encuentro,id_estado=3, fecha_cierre=DATE(NOW()) WHERE id_accion=$id";
$resultado=mysqli_query($conexion,$actualizar);
    if($_SESSION['tipousuario']==1){
    echo '<script>';
     echo  'window.location="../usuario1.php"';
     echo '</script>';
    }else{
      echo '<script>';
      echo 'window.location="../usuario2.php"';
      echo '</script>';
    }
?>