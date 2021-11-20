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
    $hora=$_POST['hora'];
    $responsable=$_POST['responsable'];
    if ($verificador==0){
        $sql="INSERT INTO sop__evento_acc_db(fecha,hora,dni_usuario,id_evento,fecha_programacion,nombre_paciente,apellido_paciente,descripcion_evento,nombre_responsable,id_estado) 
        values(NOW(),'$hora',$usuario,$evento,'$fecha','$paciente','$pacienteApellido','$descripcion','$responsable',1);";
        $resultado=mysqli_query($conexion,$sql);
    } else{
        $sql="UPDATE sop__evento_acc_db
        SET fecha_programacion='$fecha',hora='$hora',nombre_paciente='$paciente',apellido_paciente='$pacienteApellido',descripcion_evento='$descripcion',nombre_responsable='$responsable'
        WHERE id_accion=$id_accion;";
        $resultado=mysqli_query($conexion,$sql);
    };
    if($_SESSION['tipousuario']==1){
        header("location:../usuario1.php");
    } else{
        header("location:../usuario2.php");
    }
    
?>