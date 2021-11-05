<?php
include("../include/bd_usuario.php");
$id=$_POST['codigo'];
$evento=$_POST['evento'];
$devolucion=$_POST['devolucion'];
if ($devolucion==1){
    $sql="UPDATE sop__despacho_db SET devolucion=0 WHERE id_material=$id and id_evento_acc=$evento";
}else {
    $sql="DELETE FROM sop__despacho_db WHERE id_material=$id and id_evento_acc=$evento";
}
$eliminacion=mysqli_query($conexion,$sql);
?>