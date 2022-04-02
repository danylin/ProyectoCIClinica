<?php
include("bd_usuario.php");
$idEvento=$_POST['idEvento'];
$sql="UPDATE sop__evento_acc_db 
SET id_estado=4, fecha_cierre=''
WHERE id_accion=$idEvento";
$ejecucion=mysqli_query($conexion,$sql);
?>