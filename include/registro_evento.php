<?php
    session_start();
    include("bd_usuario.php");
    $usuario=$_SESSION['id'];
    $paciente=$_POST['nombre'];
    $pacienteApellido=$_POST['apellido'];
    $descripcion=$_POST['descripcion'];
    $fecha=$_POST['fecha'];
    $evento=$_POST['evento'];
    $responsanble=$_POST['responsable'];
    $codigoCierre=$_POST['encuentro'];
    $sql="INSERT INTO evento_acc_db(fecha,dni_usuario,id_evento,fecha_programacion,nombre_paciente,apellido_paciente,descripcion_evento,nombre_responsable,id_estado,codigo_cierre) 
    values(NOW(),'$usuario',$evento,'$fecha','$paciente','$pacienteApellido','$descripcion','$responsanble',1,$codigoCierre);";
    $resultado=mysqli_query($conexion,$sql);
    header("location:../usuario2.php");
?>