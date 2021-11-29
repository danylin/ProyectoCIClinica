<?php
//La presente pagina modificara los valores proporcionados al formulario GTIN/CRF
include("../include/bd_usuario.php");
$crf=$_POST['crf'];
$gtin=$_POST['codigoG'];
if(strpos($_POST['codigoGTIN'],"_")){
    $codigoGTIN=$_POST['codigoGTIN'];
    $sql="UPDATE sop__materialsc_db SET gtin='$gtin', crf='$crf' WHERE id_sc='$codigoGTIN'";
}else{
    $codigoGTIN=(int)$_POST['codigoGTIN'];
    $sql="UPDATE material__db SET gtin='$gtin', crf='$crf' WHERE codigo=$codigoGTIN";
}
$actualizar=mysqli_query($conexion,$sql);
?>