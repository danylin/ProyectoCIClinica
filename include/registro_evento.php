<?php
    session_start();
    include("bd_usuario.php");
    $usuario=$_SESSION['id'];
    $paciente=$_POST['nombre'];
    $descripcion=$_POST['descripcion'];
    $fecha=$_POST['fecha'];
    $evento=$_POST['evento'];
    $responsanble=$_POST['responsable'];
    $sql="INSERT INTO evento_acc_db(fecha,dni_usuario,id_evento,fecha_programacion,nombre_paciente,descripcion_evento,nombre_responsable,id_estado) 
    values(NOW(),'$usuario',$evento,'$fecha','$paciente','$descripcion','$responsanble',1);";
    $resultado=mysqli_query($conexion,$sql);
    header("location:../usuario2.php");
?>