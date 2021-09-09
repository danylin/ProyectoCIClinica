<?php
    include("bd_usuario.php");
    $usuario=$_POST['usuario'];
    $pass=$_POST['clave'];
    $sql="SELECT*FROM usuarios_db where usuario='$usuario' and clave='$pass';";
    $resultado=mysqli_query($conexion,$sql);
    $row=mysqli_fetch_array($resultado);
    if ($row['id_cargo'==1]) {
        header("location:usuarios.php");
     }
    ?>