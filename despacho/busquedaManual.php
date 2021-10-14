<?php
include("../include/bd_usuario.php");
$palabraClave=$_POST['nombre'];
$cManual="SELECT *FROM material__db WHERE descripcion LIKE '%$palabraClave%' LIMIT 10";
$consulta=mysqli_query($conexion,$cManual);
while($fila=mysqli_fetch_array($consulta)){
    
    
    echo "<tr  onclick='registrar();'>";
    echo "<td>";
    echo "<div id='codigoManual'>";
    echo "<p>".$fila['codigo']."</p>";
    echo "</div>";
    echo "</td>";
    echo "<td>".$fila['descripcion']."</td>";
    echo "</tr>";
   

}
?>
<script>
    function registrar(){
        var row=$('#codigoManual p').closest('tr');
        var codigo=$(row).find("td").eq(0).html();
        console.log(codigo);
    }
</script>