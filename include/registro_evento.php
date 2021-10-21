<?php
    session_start();
    include("bd_usuario.php");
    $usuario=$_SESSION['id'];
    $id_accion=$_POST['id_accion'];
    $verificador=$_POST['verificadorEditar'];
    $paciente=$_POST['nombre'];
    $pacienteApellido=$_POST['apellido'];
    $descripcion=$_POST['descripcion'];
    $fecha=$_POST['fecha'];
    $evento=$_POST['evento'];
    $responsable=$_POST['responsable'];
    if ($verificador==0){
        $sql="INSERT INTO evento_acc_db(fecha,dni_usuario,id_evento,fecha_programacion,nombre_paciente,apellido_paciente,descripcion_evento,nombre_responsable,id_estado) 
        values(NOW(),$usuario,$evento,'$fecha','$paciente','$pacienteApellido','$descripcion','$responsable',1);";
        $resultado=mysqli_query($conexion,$sql);
    } else{
        $sql="UPDATE evento_acc_db
        SET fecha_programacion='$fecha',nombre_paciente='$paciente',apellido_paciente='$pacienteApellido',descripcion_evento='$descripcion',nombre_responsable='$responsable'
        WHERE id_accion=$id_accion;";
        $resultado=mysqli_query($conexion,$sql);
    };
    header("location:../usuario2.php");
?>