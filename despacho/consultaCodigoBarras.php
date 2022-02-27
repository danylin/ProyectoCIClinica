<?php
include("../include/bd_usuario.php");
$codigo=$_POST['codigo'];
$sql="SELECT codigo FROM material__db WHERE gtin=$codigo";
$resultado=mysqli_query($conexion,$sql);
$row=mysqli_fetch_array($resultado);
echo $row['codigo'];
?>