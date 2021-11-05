<?php
session_start();
$idEstado=$_GET['estado'];
$codigo=$_GET['codigo'];
$evento=$_GET['tipoEvento'];
if($evento==1){
  $tipoEvento="Quimioterapia";
}else {
  $tipoEvento="Cirugia";
}
if($idEstado==3){
    echo '<script language="javascript">';
    echo 'if(confirm("¿Desea observar el reporte por Subtipo?")){
      window.open("../reporte/pdf_subTipo.php?codigo='.$codigo.'&tipoEvento='.$tipoEvento.'","_blank");
    } else{
      window.open("../reporte/pdf.php?codigo='.$codigo.'","_blank");
    }';
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