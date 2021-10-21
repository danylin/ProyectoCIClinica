<?php
include("../include/bd_usuario.php");
$palabraClave=$_POST['nombre'];
$devolucion=$_POST['devolucion'];
$cManual="SELECT *FROM material__db WHERE descripcion LIKE '%$palabraClave%' LIMIT 10";
$consulta=mysqli_query($conexion,$cManual);
while($fila=mysqli_fetch_array($consulta)){
    echo "<tr onclick='registrar(this,$devolucion)' id='filas'>";
    echo "<td id='except'>";
    echo $fila['codigo'];
    echo "</td>";
    echo "<td>".$fila['descripcion']."</td>";
    echo "<td style='display:none'>".$fila['tipo']."</td>";
    echo "</tr>";
}
?>
<script>
    function registrar(e,devolucion){
            var id=$(e).find("td").eq(0).html();
            var descripcion=$(e).find("td").eq(1).html();
            var tipo=$(e).find("td").eq(2).html();
            if(devolucion==1){
                $('#mensaje').prepend('<tr style="background-color: rgba(241, 91, 91, 0.3);"><td>'+id+'<input type="hidden" name="hidden_codigo[]" id="codigo" class="codigo" value='+id+'></td><td>'+descripcion+'<input type="hidden" name="hidden_nombre[]" id="nombre" class="nombre" value="'+descripcion+'"></td><td><input type="number" min=1 max=50 value=1 name="cantidad_Material[]"></td><td><input type="checkbox" name="chk1" id="chkEliminar" value=0 onchange="isChecked(this)"></td><td style="display:none"> <input type="text" value='+tipo+' name="tipo[]"></td></tr>');
            } else {
                $('#mensaje').prepend('<tr><td>'+id+'<input type="hidden" name="hidden_codigo[]" id="codigo" class="codigo" value='+id+'></td><td>'+descripcion+'<input type="hidden" name="hidden_nombre[]" id="nombre" class="nombre" value="'+descripcion+'"></td><td><input type="number" min=1 max=50 value=1 name="cantidad_Material[]"></td><td><input type="checkbox" name="chk1" id="chkEliminar" value=0 onchange="isChecked(this)" ></td><td style="display:none"> <input type="text" value='+tipo+' name="tipo[]"></td></tr>');
            }
            cerrar2();
        }; 
</script>