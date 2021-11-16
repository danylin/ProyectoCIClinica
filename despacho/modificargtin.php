<?php
include("../include/bd_usuario.php");
$gtin=$_POST['gtin'];
$crf=$_POST['crf'];
$codigoGTIN=$_POST['codigoGTIN'];
$sql="UPDATE material__db SET gtin=$gtin, crf=$crf WHERE codigo=$codigoGTIN";
$actualizar=mysqli_query($conexion,$sql);
?>