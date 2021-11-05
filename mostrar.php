<?php
    error_reporting(0);
    session_start();
        include("include/bd_usuario.php");
        if (isset($_POST['clave'])){
            $usuario=$_POST['usuario'];
            $pass=$_POST['clave'];
            $sql="SELECT*FROM sop__usuarios_db where usuario='$usuario' and clave='$pass';";
            $resultado=mysqli_query($conexion,$sql);
            $row=mysqli_fetch_array($resultado);
        }
    else{
        $usuario=$_POST['usuario'];
        $sql="SELECT*FROM sop__usuarios_db where clave='$usuario';";
        $resultado=mysqli_query($conexion,$sql);
        $row=mysqli_fetch_array($resultado);
    }
    
    $_SESSION['id']=$row['dni'];
    $_SESSION['usuario']=$row['usuario'];
    $_SESSION['nombre']=$row['nombre'];
    $_SESSION['apellido']=$row['apellido'];
    $_SESSION['id_sede']=$row['id_sede'];
    $_SESSION['tipousuario']=$row['id_tipo'];

        if ($row['id_tipo']==1) {
            header("location:usuario1.php");
        }
        elseif($row['id_tipo']==2) {
            header("location:usuario2.php");
        }
        elseif($row['id_tipo']==3) {
            header("location:usuario2.php");
        }
        else{
            if(isset($_POST['clave'])){
                include("ingreso_manual.php");
                echo "<p class='formulario' id='error'> Error. Usuario no registrado o incorrecto. </p>";
            }
            else{
                include("index.php");
                echo "<p class='formulario' id='error'> Error. Usuario no registrado o incorrecto. </p>";
            }
        }
?>