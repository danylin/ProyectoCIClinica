<?php
// El presente fichero revisara los datos ingresados por el usuario con la base de datos con el fin de identificar su existencia asi como el tipo de usuario
    error_reporting(0);
    session_start();
        include("include/bd_usuario.php");
// Este apartado verificara si existe algun envio con el name 'clave' con el fin de identificar quien es la persona que manipulara el sistema
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
    // Se guardaran los datos del usuario en caso sea exitosa la conexion con el fin de mostrar en pantalla las caracteristicas del usuario
    $_SESSION['id']=$row['dni'];
    $_SESSION['usuario']=$row['usuario'];
    $_SESSION['nombre']=$row['nombre'];
    $_SESSION['apellido']=$row['apellido'];
    $_SESSION['id_sede']=$row['id_sede'];
    $_SESSION['tipousuario']=$row['id_tipo'];

    /* El id_tipo permitirá al sistema identificar que tipo de usuario es, con el fin
    de determinar que pantalla y opciones mostrar definidos en usuario1.php y usuario2.php
    */
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
        //En caso de error la pantalla de inicio mostrara el apartado de error. Se tendra que revisar la base de datos la existencia del usuario en caso de dudas
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