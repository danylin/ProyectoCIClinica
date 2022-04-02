<?php
include("../include/bd_usuario.php");
$codigo=$_POST['codigo'];
for($longitud=1;$longitud<=strlen($codigo);$longitud++){
    $prueba=substr($codigo,0,$longitud);
    $sql="SELECT codigo FROM material__db WHERE gtin='$prueba'";
    $resultado=mysqli_query($conexion,$sql);
    $row=mysqli_fetch_array($resultado);
    $tipo='';
    if(!empty($row)){
        break;
    }
}
echo $row['codigo'];
?>