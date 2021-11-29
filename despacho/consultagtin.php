<?php
//La presente pagina seleccionara los codigos GTIN y CRF de los materiales seleccionados
include("../include/bd_usuario.php");
if(strpos($_POST['codigo'],"_")){ //Esta condicional determina si el material fue ingresado manualmente o se encuentra en la base de datos material__db
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