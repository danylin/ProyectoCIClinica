<?php
session_start();
$idEstado=$_GET['estado'];
$codigo=$_GET['codigo'];
if($idEstado==3){
    echo '<script language="javascript">';
    echo 'window.open("../reporte/pdf.php?codigo='.$codigo.'","_blank");';
    echo '</script>';
    if($_SESSION['tipousuario']==1){
        echo '<script language="javascript">';
        echo 'window.location="../usuario1.php"';
        echo '</script>';
      }else{
        echo '<script language="javascript">';
        echo 'window.location="../usuario2.php"';
        echo '</script>';
      }
}else{
    header("location:despacho.php?codigo=".$codigo);
}
?>