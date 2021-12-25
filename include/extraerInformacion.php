<?php
session_start();
include("bd_usuario.php");
header("Content-Disposition: attachment; filename=Extraccion.xls");
$id=$_SESSION['id_sede'];
$tipoEvento=$_POST['tipoEvento'];
if(isset($_POST['sede'])){
    $sede=$_POST['sede'];
};
if(isset($_POST['usuarioEx'])){
    $usuario=$_POST['usuarioEx'];
};
if(isset($_POST['materialEx'])){
    $material=$_POST['materialEx'];
};
$fechaDesde=$_POST['fechaDesde'];
$fechaHasta=$_POST['fechaHasta'];
$sql="SELECT a.id_accion,a.fecha_programacion,a.codigo_cierre,CONCAT(a.nombre_paciente,' ',a.apellido_paciente) 'Nombre y Apellidos del Paciente',c.nombre 'Evento',TIME_FORMAT(a.hora,'%H:%i') hora,a.descripcion_evento,a.fecha_cierre,b.estado,sop__usuarios_db.usuario,d.nombre,d.cantidad,d.devolucion,(d.cantidad-d.devolucion) 'Total'
FROM sop__evento_acc_db a
RIGHT JOIN sop__despacho_db d on a.id_accion=d.id_evento_acc
INNER JOIN sop__estados_db b on b.id_estado=a.id_estado
INNER JOIN sop__usuarios_db on a.dni_usuario =sop__usuarios_db.dni 
INNER JOIN sede__db_area on sede__db_area.id=sop__usuarios_db.id_sede 
INNER JOIN sop__eventos_db c on c.id_evento=a.id_evento
WHERE a.fecha_programacion between '$fechaDesde' and '$fechaHasta'";
if($tipoEvento!=0){
    $sql.=" and a.id_evento=$tipoEvento";
}
if (isset($_POST['sede'])){
    if ($_POST['sede']!=0){
        $sql.=" and sede__db_area.id=$sede";
    }
}
if (isset($_POST['usuarioEx'])){
    $sql.=" and sop__usuarios_db.dni=$usuario";
}
if (isset($_POST['materialEx'])){
    $sql.=" and d.id_material=$material";
}
$sql.=" ORDER BY a.id_accion,a.fecha_programacion;";
?>
<table>
    <tr>
        <th>Id del Evento</th>
        <th>Fecha Programacion</th>
        <th>Codigo de Cierre</th>
        <th>Paciente</th>
        <th>Evento</th>
        <th>Hora de Operacion</th>
        <th>Descripcion del Evento</th>
        <th>Fecha de Cierre</th>
        <th>Material Utilizado</th>
        <th>Cantidad Entregada</th>
        <th>Cantidad Devuelta</th>
        <th>Total Utilizada</th>
    </tr>
<?php 
    $resultado=mysqli_query($conexion,$sql);
    while($row=mysqli_fetch_array($resultado))
    {
?>
    <tr>
        <td><?php echo $row['id_accion']; ?></td>
        <td><?php echo $row['fecha_programacion']; ?></td>
        <td><?php echo $row['codigo_cierre']; ?></td>
        <td><?php echo $row['Nombre y Apellidos del Paciente']; ?></td>
        <td><?php echo $row['Evento']; ?></td>
        <td><?php echo $row['hora'] ?></td>
        <td><?php echo $row['descripcion_evento'] ?></td>
        <td><?php echo $row['fecha_cierre'] ?></td>
        <td><?php echo $row['nombre'] ?></td>
        <td><?php echo $row['cantidad'] ?></td>
        <td><?php echo $row['devolucion'] ?></td>
        <td><?php echo $row['Total'] ?></td>
    </tr>
<?php } mysqli_free_result($resultado); ?>
</table>