<?php
    include("../include/bd_usuario.php");
    $idEvento=$_GET['codigo'];
    for($count = 0; $count<count($_POST['hidden_codigo']); $count++)
    {
    $codigo=$_POST['hidden_codigo'][$count];
    $cantidad=$_POST['cantidad_Material'][$count];
    $query = " INSERT INTO despacho_db (id_material,id_evento_acc,cantidad) VALUES ($codigo,$idEvento,$cantidad)";
    $consulta=mysqli_query($conexion,$query);
    }
    $cambio="UPDATE evento_acc_db SET id_estado=2 WHERE id_accion=$idEvento;";
    $actualizar=mysqli_query($conexion,$cambio);
    header("location:../usuario2.php");
?>