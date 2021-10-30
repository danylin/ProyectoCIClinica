<?php
    include("../include/bd_usuario.php");
    $idEvento=$_GET['codigo'];
    for($count = 0; $count<count($_POST['hidden_codigo']); $count++)
    {
    if(isset($_POST['tipo'][$count])){
        $tipo=$_POST['tipo'][$count];
    }else {
        $tipo='';
    }
    $codigo=$_POST['hidden_codigo'][$count];
    $cantidad=$_POST['cantidad_Material'][$count];
    $nombre=$_POST['hidden_nombre'][$count];
    $subtipo=$_POST['subtipos'][$count];
    if ($_POST['devolucion']==1){
        $query = " UPDATE sop__despacho_db SET devolucion=IF($cantidad<cantidad,$cantidad,cantidad) WHERE id_material=$codigo and id_evento_acc=$idEvento";
    }else{
        if($codigo=='00000000'){
            $nuevoProducto="INSERT INTO sop__materialsc_db(nombre) values('$nombre')";
            $consulta=mysqli_query($conexion,$nuevoProducto);
            $codigoNuevoProducto="SELECT DISTINCT *FROM sop__materialsc_db WHERE nombre='$nombre'";
            $consulta=mysqli_query($conexion,$codigoNuevoProducto);
            $fila=mysqli_fetch_array($consulta);
            $codigo=$fila['id'];
            $query = " INSERT INTO sop__despacho_db (id_material,id_evento_acc,cantidad,nombre,tipo,subtipo) VALUES ($codigo,$idEvento,$cantidad,'$nombre','$tipo','$subtipo')";
        }
        $query = " INSERT INTO sop__despacho_db (id_material,id_evento_acc,cantidad,nombre,tipo,subtipo) VALUES ($codigo,$idEvento,$cantidad,'$nombre','$tipo','$subtipo')";
    }
    $consulta=mysqli_query($conexion,$query);
    }
    $cambio="UPDATE sop__evento_acc_db SET id_estado=2 WHERE id_accion=$idEvento;";
    $actualizar=mysqli_query($conexion,$cambio);
    header("location:despacho.php?codigo=$idEvento");
?>
