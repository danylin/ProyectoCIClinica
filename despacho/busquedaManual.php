<?php
include("../include/bd_usuario.php");
$palabraClave=$_POST['nombre'];
$devolucion=$_POST['devolucion'];
$tipoEvento=$_POST['tipoEvento'];
$cManual="SELECT *FROM material__db WHERE descripcion LIKE '%$palabraClave%' LIMIT 10";
$consulta=mysqli_query($conexion,$cManual);
while($fila=mysqli_fetch_array($consulta)){
    echo "<tr onclick='registrar(this,$devolucion)' id='filas'>";
    echo "<td id='except'>";
    echo $fila['codigo'];
    echo "</td>";
    echo "<td>".$fila['descripcion']."</td>";
    echo "</tr>";
}
?>
<script>
    function registrar(e,devolucion){
            var id=$(e).find("td").eq(0).html();
            var descripcion=$(e).find("td").eq(1).html();
            var tipo='';
            var tipoEvento='<?php echo $tipoEvento ?>';
            if(devolucion==1){
                if (tipoEvento=="Cirugia"){
                    $('#mensaje').prepend('<tr style="background-color: rgba(241, 91, 91, 0.3);"><td>'+id+'<input type="hidden" name="hidden_codigo[]" id="codigo" class="codigo" value='+id+'></td><td>'+descripcion+'<input type="hidden" name="hidden_nombre[]" id="nombre" class="nombre" value="'+descripcion+'"></td><td><input type="number" min=1 max=50 value=1 name="cantidad_Material[]"></td><td>'+tipo+' <input type="hidden" value='+tipo+' name="tipo[]"></td><td></td><td><input type="checkbox" name="chk1" id="chkEliminar" value=0 onchange="isChecked(this)"></td></tr>');
                } else if(tipoEvento=="Quimioterapia"){
                    $('#mensaje').prepend('<tr style="background-color: rgba(241, 91, 91, 0.3);"><td>'+id+'<input type="hidden" name="hidden_codigo[]" id="codigo" class="codigo" value='+id+'></td><td>'+descripcion+'<input type="hidden" name="hidden_nombre[]" id="nombre" class="nombre" value="'+descripcion+'"></td><td><input type="number" min=1 max=50 value=1 name="cantidad_Material[]"></td><td>'+tipo+' <input type="hidden" value='+tipo+' name="tipo[]"><td></td><td><input type="checkbox" name="chk1" id="chkEliminar" value=0 onchange="isChecked(this)" ></td></tr>');
                }
            } else {
                if (tipoEvento=="Cirugia"){
                    $('#mensaje').prepend('<tr><td>'+id+'<input type="hidden" name="hidden_codigo[]" id="codigo" class="codigo" value='+id+'></td><td>'+descripcion+'<input type="hidden" name="hidden_nombre[]" id="nombre" class="nombre" value="'+descripcion+'"></td><td><input type="number" min=1 max=50 value=1 name="cantidad_Material[]"></td><td>'+tipo+' <input type="hidden" value='+tipo+' name="tipo[]">'+tipo+'</td><td><select name="subtipos[]"><option value="Material de Anestesia">Material de Anestesia</option><option value="Medicación de Anestesia">Medicación de Anestesia</option><option value="Dispensación regular">Dispensación regular</option><option value="Adicionales">Adicionales</option></select></td><td><input type="checkbox" name="chk1" id="chkEliminar" value=0 onchange="isChecked(this)" ></td></tr>');
                }else if(tipoEvento=="Quimioterapia"){
                    $('#mensaje').prepend('<tr><td>'+id+'<input type="hidden" name="hidden_codigo[]" id="codigo" class="codigo" value='+id+'></td><td>'+descripcion+'<input type="hidden" name="hidden_nombre[]" id="nombre" class="nombre" value="'+descripcion+'"></td><td><input type="number" min=1 max=50 value=1 name="cantidad_Material[]"></td><td >'+tipo+' <input type="hidden" value='+tipo+' name="tipo[]">'+tipo+'</td><td><select name="subtipos[]"><option value="Hidratación prequimioterapia">Hidratación prequimioterapia</option><option value="Dispensación regular">Dispensación regular</option><option value="Alta postquimioterapia">Alta postquimioterapia</option></select></td><td><input type="checkbox" name="chk1" id="chkEliminar" value=0 onchange="isChecked(this)" ></td></tr>');
                }
            }
            cerrar2();
        }; 
</script>