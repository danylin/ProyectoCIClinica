<?php
    include ('../include/bd_usuario.php');
    $dni=$_GET['dni'];
    $valor=$_POST['tipo'];
    if($valor==1){
     header("location:Editar.php?dni=".$_GET['dni']."");
    }
    else{
        if(isset($dni)){
            $sql="DELETE from sop__usuarios_db where dni=$dni;";
            $eliminar= mysqli_query($conexion,$sql);
            header('location:Usuarios.php');
        }
    }
?>