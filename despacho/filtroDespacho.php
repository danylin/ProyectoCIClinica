<?php
include("../include/bd_usuario.php");
$subtipo=$_POST['subtipo'];
$evento=$_GET['evento'];
$sqlMateriales="SELECT*FROM sop__despacho_db Where id_evento_acc=$evento and subtipo='$subtipo' order by nombre asc ;";
$consultaMateriales=mysqli_query($conexion,$sqlMateriales);
while($filaConsulta=mysqli_fetch_array($consultaMateriales)){
    if($filaConsulta['devolucion']==0){
        echo "<tr>";
        echo "<td>".$filaConsulta['id_material']."</td>";
        echo "<td>".$filaConsulta['nombre']."</td>";
        echo "<td><input type='number' id='cantidadSelect' value=".$filaConsulta['cantidad']."></td>";
        echo "<td>".$filaConsulta['tipo']."</td>";
        echo "<td><input type='checkbox' name='chk1' id='chkEliminar' value=0 onchange='isChecked(this)' ></td>";
        echo "<td><input type='hidden' id='update' value='1'></td>";
        echo "<td style='display:none'><input type='hidden' id='devolucionItem' value='0'></td>";
        echo "</tr>";
      }else{
        echo "<tr>";
        echo "<td>".$filaConsulta['id_material']."</td>";
        echo "<td>".$filaConsulta['nombre']."</td>";
        echo "<td><input type='number' id='cantidadSelect' value=".$filaConsulta['cantidad']."></td>";
        echo "<td>".$filaConsulta['tipo']."</td>";
        echo "<td><input type='checkbox' name='chk1' id='chkEliminar' value=0 onchange='isChecked(this)' ></td>";
        echo "<td><input type='hidden' id='update' value='1'></td>";
        echo "<td style='display:none'><input type='hidden' id='devolucionItem' value='0'></td>";
        echo "</tr>";
        echo "<tr style='background-color: rgba(241, 91, 91, 0.3);'>";
        echo "<td>".$filaConsulta['id_material']."</td>";
        echo "<td>".$filaConsulta['nombre']."</td>";
        echo "<td><input type='number' id='cantidadSelect' value=".$filaConsulta['devolucion']."></td>";
        echo "<td>".$filaConsulta['tipo']."</td>";
        echo "<td><input type='checkbox' name='chk1' id='chkEliminar' value=0 onchange='isChecked(this)' ></td>";
        echo "<td><input type='hidden' id='update' value='1'></td>";
        echo "<td style='display:none'><input type='hidden' id='devolucionItem' value='1'></td>";
        echo "</tr>";
      }
}
?>