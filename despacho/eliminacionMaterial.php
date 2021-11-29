<?php
//El presente apartado eliminará la fila elegida con los datos enviados
include("../include/bd_usuario.php");
$id=$_POST['codigo'];
$evento=$_POST['evento'];
$devolucion=$_POST['devolucion'];
if ($devolucion==1){//Si se eliminó una devolucion se actualizara la columna con una valor de 0
    $sql="UPDATE sop__despacho_db SET devolucion=0 WHERE id_material='$id' and id_evento_acc=$evento";
}else { //En caso que sea un material se borrara de la base de datos sop__despacho_db en conjunto con la devolucion
    $sql="DELETE FROM sop__despacho_db WHERE id_material='$id' and id_evento_acc=$evento";
}
$eliminacion=mysqli_query($conexion,$sql);
?>