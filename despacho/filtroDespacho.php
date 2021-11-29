<?php
//El presente apartado mostrará los productos en base a la seleccion del subtipo de los mismo
include("../include/bd_usuario.php");
$subtipo=$_POST['subtipo'];
$evento=$_GET['evento'];
if($subtipo=="Todos"){ //En caso que fueran todos se mostrara el consolidado de los elementos
  $sqlMateriales="SELECT*FROM sop__despacho_db Where id_evento_acc=$evento order by nombre asc ;";
}else{ //En caso contrario se especificara a la consulta que subtipos mostrar
  $sqlMateriales="SELECT*FROM sop__despacho_db Where id_evento_acc=$evento and subtipo='$subtipo' order by nombre asc ;";
}
$consultaMateriales=mysqli_query($conexion,$sqlMateriales);

while($filaConsulta=mysqli_fetch_array($consultaMateriales)){
    if($filaConsulta['devolucion']==0){ //Se añdiran los elementos que cumplan con el criterio de seleccion con los siguientes datos en mencion
        echo "<tr>";
        echo "<td>".$filaConsulta['id_material']."</td>";
        echo "<td style='text-align:left'>".$filaConsulta['nombre']."</td>";
        echo "<td><input type='number' id='cantidadSelect' value=".$filaConsulta['cantidad']."></td>";
        echo "<td>".$filaConsulta['tipo']."</td>";
        echo "<td><input type='checkbox' name='chk1' id='chkEliminar' value=0 onchange='isChecked(this)' ></td>";
        echo "<td><input type='hidden' id='update' value='1'></td>";
        echo "<td style='display:none'><input type='hidden' id='devolucionItem' value='0'></td>";
        echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
        echo "<div class='mostrarGTIN'><button id='mostrarGTIN' onclick='GTIN(this)'>GTIN</button></div>";
        echo "</td>";
        echo "</tr>";
      }else{ //Aca se ingresara dos filas en caso que el material tenga devoluciones.
        echo "<tr>";
        echo "<td>".$filaConsulta['id_material']."</td>";
        echo "<td style='text-align:left'>".$filaConsulta['nombre']."</td>";
        echo "<td><input type='number' id='cantidadSelect' value=".$filaConsulta['cantidad']."></td>";
        echo "<td>".$filaConsulta['tipo']."</td>";
        echo "<td><input type='checkbox' name='chk1' id='chkEliminar' value=0 onchange='isChecked(this)' ></td>";
        echo "<td><input type='hidden' id='update' value='1'></td>";
        echo "<td style='display:none'><input type='hidden' id='devolucionItem' value='0'></td>";
        echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
        echo "<div class='mostrarGTIN'><button id='mostrarGTIN' onclick='GTIN(this)'>GTIN</button></div>";
        echo "</td>";
        echo "</tr>";
        //Devolucion del objeto
        echo "<tr style='background-color: rgba(241, 91, 91, 0.3);'>";
        echo "<td>".$filaConsulta['id_material']."</td>";
        echo "<td style='text-align:left'>".$filaConsulta['nombre']."</td>";
        echo "<td><input type='number' id='cantidadSelect' value=".$filaConsulta['devolucion']."></td>";
        echo "<td>".$filaConsulta['tipo']."</td>";
        echo "<td><input type='checkbox' name='chk1' id='chkEliminar' value=0 onchange='isChecked(this)' ></td>";
        echo "<td><input type='hidden' id='update' value='1'></td>";
        echo "<td style='display:none'><input type='hidden' id='devolucionItem' value='1'></td>";
        echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
        echo "<div class='mostrarGTIN'><button id='mostrarGTIN' onclick='GTIN(this)'>GTIN</button></div>";
        echo "</tr>";
      }
}
?>