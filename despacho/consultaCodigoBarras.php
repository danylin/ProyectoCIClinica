<?php
include("../include/bd_usuario.php");
$codigo=$_POST['codigo'];
if(strlen($codigo)==44){
    $codigo=16002388;
    $sql="SELECT codigo FROM material__db WHERE codigo=$codigo";
    $resultado=mysqli_query($conexion,$sql);
    $row=mysqli_fetch_array($resultado);
}else{
    $sql="SELECT codigo FROM material__db WHERE gtin=$codigo";
    $resultado=mysqli_query($conexion,$sql);
    $row=mysqli_fetch_array($resultado);
}
echo $row['codigo'];
?>