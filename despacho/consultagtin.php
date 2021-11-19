<?php
include("../include/bd_usuario.php");
if(strpos($_POST['codigo'],"_")){
    $codigo=$_POST['codigo'];
    $sql="SELECT CONCAT(id_sc,'-',nombre) CodNombre,gtin, crf FROM sop__materialsc_db WHERE id_sc='$codigo'";
}else{
    $codigo=(int)$_POST['codigo'];
    $sql="SELECT CONCAT(codigo,'-',descripcion) CodNombre, gtin, crf FROM material__db WHERE codigo=$codigo";
}
$resultado=mysqli_query($conexion,$sql);
$row=mysqli_fetch_array($resultado);
echo json_encode($row);
?>