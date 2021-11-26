<?php
session_start();
@header("Content-Disposition: attachment; filename=Extraccion.csv");
$tipoEvento=$_POST['tipoEvento'];
$id=$_SESSION['id_sede']
$sql="SELECT a.id_accion,a.fecha_programacion,a.codigo_cierre,CONCAT(a.nombre_paciente," ",a.apellido_paciente) 'Nombre y Apellidos del Paciente',c.nombre 'Evento',TIME_FORMAT(a.hora,'%H:%i') hora,a.nombre_responsable,a.descripcion_evento,b.estado,sop__usuarios_db.usuario
FROM sop__evento_acc_db a
INNER JOIN sop__estados_db b on b.id_estado=a.id_estado
INNER JOIN sop__usuarios_db on a.dni_usuario =sop__usuarios_db.dni 
INNER JOIN sede__db_area on sede__db_area.id=sop__usuarios_db.id_sede 
INNER JOIN sop__eventos_db c on c.id_evento=a.id_evento
ORDER BY a.fecha_programacion,b.estado,c.nombre;";
$resultado=mysqli_query($conexion,$sql);
 while($row=mysql_fetch_array($resultado))
 {
  $data.=$row['name'].",";
  $data.=$row['age'].",";
  $data.=$row['country']."\n";
 }

 echo $data;
 exit();
?>