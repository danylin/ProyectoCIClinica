<?php
    include("include/bd_usuario.php");
    $usuario=$_POST['usuario'];
    $pass=$_POST['clave'];
    $sql="SELECT*FROM usuario where usuario='$usuario' and clave='$pass';";
    $resultado=mysqli_query($conexion,$sql);
    $row=mysqli_fetch_array($resultado);
    if ($row) {
        header("location:usuarios.php");
     }
     else{
         include("index.php");
         echo "<p class='formulario' id='error'> Error. Usuario no registrado o incorrecto. </p>";
     }
    ?>