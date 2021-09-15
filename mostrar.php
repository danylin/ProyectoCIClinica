<?php
    error_reporting(0);
    session_start();
    include("include/bd_usuario.php");
    if (isset($_POST['clave'])){
        $usuario=$_POST['usuario'];
        $pass=$_POST['clave'];
        $sql="SELECT*FROM usuarios_db where usuario='$usuario' and clave='$pass';";
        $resultado=mysqli_query($conexion,$sql);
        $row=mysqli_fetch_array($resultado);
    }
   else{
    $usuario=$_POST['usuario'];
    $sql="SELECT*FROM usuarios_db where dni=$usuario;";
    $resultado=mysqli_query($conexion,$sql);
    $row=mysqli_fetch_array($resultado);
   }
   $_SESSION['id']=$row['dni'];
   $_SESSION['usuario']=$row['usuario'];
   $_SESSION['nombre']=$row['nombre'];
   $_SESSION['apellido']=$row['apellido'];
    if ($row['id_tipo']==1) {
        header("location:usuario1.php");
     }
    elseif($row['id_tipo']==2) {
        header("location:usuario2.php");
     }
     elseif($row['id_tipo']==3) {
        header("location:usuario3.php");
     }
     else{
         include("index.php");
         echo "<p class='formulario' id='error'> Error. Usuario no registrado o incorrecto. </p>";
     }
?>