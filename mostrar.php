<?php
    include("include/bd_usuario.php");
    $usuario=$_POST['usuario'];
    $pass=$_POST['clave'];
    $sql="SELECT*FROM usuarios_db where usuario='$usuario' and contraseña='$pass';";
    $resultado=mysqli_query($conexion,$sql);
    $row=mysqli_fetch_array($resultado);
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