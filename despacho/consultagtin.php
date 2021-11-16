<?php
include("../include/bd_usuario.php");
$codigo=$_POST['codigo'];
$sql="SELECT gtin, crf FROM material__db WHERE codigo=$codigo";
$resultado=mysqli_query($conexion,$sql);
$row=mysqli_fetch_array($resultado);
echo json_encode($row);
?>