<?php
include("../include/bd_usuario.php");
$palabraClave=$_POST['nombre'];
$cManual="SELECT *FROM material__db WHERE descripcion LIKE '%$palabraClave%' LIMIT 10";
$consulta=mysqli_query($conexion,$cManual);
while($fila=mysqli_fetch_array($consulta)){
    echo "<tr>";
    echo "<td>".$fila['codigo']."</td>";
    echo "<td>".$fila['descripcion']."</td>";
    echo "</tr>";
}
?>