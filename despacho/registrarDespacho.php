<?php
    include("../include/bd_usuario.php");
    $idEvento=$_GET['codigo'];
    for($count = 0; $count<count($_POST['hidden_codigo']); $count++)
    {
    $codigo=$_POST['hidden_codigo'][$count];
    $cantidad=$_POST['cantidad_Material'][$count];
    $nombre=$_POST['hidden_nombre'][$count];
    if ($_POST['devolucion']==1){
        $query = " UPDATE despacho_db SET devolucion=$cantidad WHERE id_material=$codigo and id_evento_acc=$idEvento";
    }else{
        $query = " INSERT INTO despacho_db (id_material,id_evento_acc,cantidad,nombre) VALUES ($codigo,$idEvento,$cantidad,'$nombre')";
    }
    $consulta=mysqli_query($conexion,$query);
    }
    $cambio="UPDATE evento_acc_db SET id_estado=2 WHERE id_accion=$idEvento;";
    $actualizar=mysqli_query($conexion,$cambio);
    header("location:../usuario2.php");
?>
