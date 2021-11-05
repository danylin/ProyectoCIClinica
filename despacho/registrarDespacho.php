<?php
    include("../include/bd_usuario.php");
    $idEvento=$_GET['evento'];
    $codigo=$_POST['codigo'];
    $cantidad=$_POST['cantidad'];
    $nombre=$_POST['descripcion'];
    $tipo=$_POST['tipo'];
    $subtipo=$_POST['subtipo'];
    $devObjeto=$_POST['devObjeto'];
        if($_POST['update']==1){
            if($devObjeto==1){
                $sql="SELECT*FROM sop__despacho_db WHERE id_material=$codigo and id_evento_acc=$idEvento";
                $resultado=mysqli_query($conexion,$sql);
                while($filas=mysqli_fetch_array($resultado)){
                    if ($filas['id_material']==$codigo){
                        if($filas['cantidad']<$cantidad){
                            $query = "UPDATE sop__despacho_db SET devolucion=cantidad WHERE id_material=$codigo and id_evento_acc=$idEvento";
                            $consulta=mysqli_query($conexion,$query);
                        }else{
                            $query = "UPDATE sop__despacho_db SET devolucion=$cantidad WHERE id_material=$codigo and id_evento_acc=$idEvento";
                            $consulta=mysqli_query($conexion,$query);
                        }
                    }
                }
            }else {
                $query = "UPDATE sop__despacho_db SET cantidad=$cantidad WHERE id_material=$codigo and id_evento_acc=$idEvento";
                $consulta=mysqli_query($conexion,$query);
            }
        } else{
            if ($devObjeto==1){
                $sql="SELECT*FROM sop__despacho_db WHERE id_material=$codigo and id_evento_acc=$idEvento";
                $resultado=mysqli_query($conexion,$sql);
                while($filas=mysqli_fetch_array($resultado)){
                    if ($filas['id_material']==$codigo){
                        if($filas['cantidad']<$cantidad){
                            $query = "UPDATE sop__despacho_db SET devolucion=cantidad WHERE id_material=$codigo and id_evento_acc=$idEvento";
                            $consulta=mysqli_query($conexion,$query);
                        }else{
                            $query = "UPDATE sop__despacho_db SET devolucion=$cantidad WHERE id_material=$codigo and id_evento_acc=$idEvento";
                            $consulta=mysqli_query($conexion,$query);
                        }
                    }
                }
            }else{
                if(strlen($codigo)<8){
                    $codigoNuevoProducto="SELECT DISTINCT *FROM sop__materialsc_db WHERE id='$codigo'";
                    $consulta=mysqli_query($conexion,$codigoNuevoProducto);
                    $fila=mysqli_fetch_array($consulta);
                    $codigo=$fila['id'];
                    $query = " INSERT INTO sop__despacho_db (id_material,id_evento_acc,cantidad,nombre,tipo,subtipo) VALUES ($codigo,$idEvento,$cantidad,'$nombre','$tipo','$subtipo')";
                }else{
                    $query = " INSERT INTO sop__despacho_db (id_material,id_evento_acc,cantidad,nombre,tipo,subtipo) VALUES ($codigo,$idEvento,$cantidad,'$nombre','$tipo','$subtipo')";
                }
                $consulta=mysqli_query($conexion,$query);
            }
        }
        $query = "UPDATE sop__evento_acc_db SET id_estado=2 WHERE id_accion=$idEvento";
        $consulta=mysqli_query($conexion,$query);
?>
