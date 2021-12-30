<?php
//El presente archivo envia los datos segun las iniciales del buscador en el formulario Busqueda Manual
include("../include/bd_usuario.php");
$palabraClave=$_POST['nombre']; //Esta variable guarda las palabras tipeadas por el usuario en la barra de busqueda
$devolucion=$_POST['devolucion'];
$tipoEvento=$_POST['tipoEvento'];
$cManual="SELECT *FROM material__db WHERE descripcion LIKE '%$palabraClave%' LIMIT 10";
$consulta=mysqli_query($conexion,$cManual);
while($fila=mysqli_fetch_array($consulta)){
    echo "<tr onclick='registrar(this,$devolucion)' id='filas' class='fila'>";
    echo "<td id='except'>";
    echo $fila['codigo'];
    echo "</td>";
    echo "<td style='text-align:left'>".$fila['descripcion']."</td>";
    echo "</tr>";
}
?>
<script>
    //La presente funcion registra en la base de datos sop__despacho_db el material seleccionado
    function registrar(e,devolucion){
            var id=$(e).find("td").eq(0).html();
            var descripcion=$(e).find("td").eq(1).html();
            var tipo='';
    // Dentro de la siguiente condicional se deteminara si se esta ejecutando una devolucion o no.
            if(devolucion==1){
                    $('#mensaje').prepend('<tr class="nuevaEntradaD" style="background-color: rgba(241, 91, 91, 0.3);"><td>'+id+'</td><td style="text-align:left">'+descripcion+'<input type="hidden" name="hidden_nombre[]" id="nombre" class="nombre" value="'+descripcion+'"></td><td><input type="number" min=1 max=50 value=1 name="cantidad_Material[]"></td><td>'+tipo+'<input type="hidden" value='+tipo+' name="tipo[]"></td><td><input type="checkbox" name="chk1" id="chkEliminar" value=0 onchange="isChecked(this)"></td><td><input type="hidden" id="update" value="0"></td><td style="display:none"><input type="hidden" id="devolucionItem" value="1"</td><td onclick="event.cancelBubble=true; return false;" id="except"><div class="mostrarGTIN"><button id="mostrarGTIN" onclick="GTIN(this)">GTIN</button></div></td></tr>');
            } else {
                    $('#mensaje').prepend('<tr class="nuevaEntrada"><td>'+id+'</td><td style="text-align:left">'+descripcion+'<input type="hidden" name="hidden_nombre[]" id="nombre" class="nombre" value="'+descripcion+'"></td><td><input type="number" min=1 max=50 value=1 name="cantidad_Material[]"></td><td>'+tipo+'<input type="hidden" value='+tipo+' name="tipo[]"></td><td><input type="checkbox" name="chk1" id="chkEliminar" value=0 onchange="isChecked(this)"></td><td style="display:none"><input type="hidden" id="update" value="0"></td><td><input type="hidden" id="devolucionItem" value="0"</td><td onclick="event.cancelBubble=true; return false;" id="except"><div class="mostrarGTIN"><button id="mostrarGTIN" onclick="GTIN(this)">GTIN</button></div></td></tr>');
            }
            document.getElementById('busquedaInput').value='';
            $("#resultadoBusqueda tr").remove(); 
            cerrar2();
        }; 
</script>
