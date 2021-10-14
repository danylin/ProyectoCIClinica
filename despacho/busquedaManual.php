<?php
include("../include/bd_usuario.php");
$palabraClave=$_POST['nombre'];
$cManual="SELECT *FROM material__db WHERE descripcion LIKE '%$palabraClave%' LIMIT 10";
$consulta=mysqli_query($conexion,$cManual);
while($fila=mysqli_fetch_array($consulta)){
    echo "<tr onclick='registrar(this)' id='filas'>";
    echo "<td id='except'>";
    echo $fila['codigo'];
    echo "</td>";
    echo "<td>".$fila['descripcion']."</td>";
    echo "</tr>";
}
?>
<script>
    function registrar(e){
            var id=$(e).find("td").eq(0).html();
            var descripcion=$(e).find("td").eq(1).html();
            $('#tabla_elementos tr:last').after('<tr><td>'+id+'<input type="hidden" name="hidden_codigo[]" id="codigo" class="codigo" value='+id+'></td><td>'+descripcion+'<input type="hidden" name="hidden_nombre[]" id="nombre" class="nombre" value="'+descripcion+'"></td><td><input type="number" min=1 max=50 value=1 name="cantidad_Material[]"></td></tr>');
        }; 
</script>