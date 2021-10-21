<?php
include("../include/bd_usuario.php");
$id=$_POST['codigo'];
$evento=$_POST['evento'];
$sql="DELETE FROM despacho_db WHERE id_material=$id and id_evento_acc=$evento";
$eliminacion=mysqli_query($conexion,$sql);
?>