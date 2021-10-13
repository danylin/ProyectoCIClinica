<?php
    session_start();
    include("bd_usuario.php");
    $usuario=$_SESSION['id'];
    $id_accion=$_POST['id_accion'];
    $verificacion=$_POST['verificadorEditar'];
    $paciente=$_POST['nombre'];
    $pacienteApellido=$_POST['apellido'];
    $descripcion=$_POST['descripcion'];
    $fecha=$_POST['fecha'];
    $evento=$_POST['evento'];
    $responsable=$_POST['responsable'];
    $codigoCierre=$_POST['encuentro'];
    if($verificacion==0){
        $sql="INSERT INTO evento_acc_db(fecha,dni_usuario,id_evento,fecha_programacion,nombre_paciente,apellido_paciente,descripcion_evento,nombre_responsable,id_estado,codigo_cierre) 
        values(NOW(),'$usuario',$evento,'$fecha','$paciente','$pacienteApellido','$descripcion','$responsable',1,$codigoCierre);";
        $resultado=mysqli_query($conexion,$sql);
    } else{
        $sql="UPDATE evento_acc_db 
        SET nombre_responsable='$responsable',fecha_programacion='$fecha',nombre_paciente='$paciente',apellido_paciente='$pacienteApellido',descripcion_evento='$descripcion',codigo_cierre=$codigoCierre
        WHERE id_accion=$id_accion;";
        $resultado=mysqli_query($conexion,$sql);
    }
    header("location:../usuario2.php");
?>