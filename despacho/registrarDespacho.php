<?php
// El presente apartado 
    include("../include/bd_usuario.php");
    $idEvento=$_GET['evento'];
    $codigo=$_POST['codigo'];
    $cantidad=$_POST['cantidad'];
    $nombre=$_POST['descripcion'];
    $tipo=$_POST['tipo'];
    $subtipo=$_POST['subtipo'];
    $devObjeto=$_POST['devObjeto'];
    $update=$_POST['update'];
    $contador; //Esta variable permitira saber si el material se repite mas de una vez
    for($i=0;$i<count($codigo);$i++){
        $pruebaExistencia="SELECT*FROM sop__despacho_db WHERE subtipo='$subtipo' and id_evento_acc=$idEvento and id_material='".$codigo[$i]."'";
        $pruebaConsulta=mysqli_query($conexion,$pruebaExistencia);
        while($despachos=mysqli_fetch_array($pruebaConsulta)){
            if($despachos['id_material']==$codigo[$i]){
                $contador=$contador+1; //Esto permitira leer el array y si existe actualmente un material dentro de sop__despacho_db 
            }
        }
        if($contador>0){ //Este condicional verificara si existe dicho elemento dentro de la base de datos
            if($update[$i]==0){ //El valor de update permitira actualizar el valor de devolucion o cantidad
                if($devObjeto[$i]==1){ //Determinara si es devolucion o entrega
                    $query = "UPDATE sop__despacho_db SET devolucion=IF(cantidad<devolucion+1,cantidad,devolucion+1) WHERE subtipo='$subtipo' and id_material='".$codigo[$i]."' and id_evento_acc=$idEvento";
                    $consulta=mysqli_query($conexion,$query);
                }else {
                    $query = "UPDATE sop__despacho_db SET cantidad=cantidad+1 WHERE subtipo='$subtipo' and id_material='".$codigo[$i]."' and id_evento_acc=$idEvento";
                    $consulta=mysqli_query($conexion,$query);
            }
        }
        $contador=0;
        }else{ //Si no es un valor existente dentro de la base de datos se procedera de la siguiente manera
            if($update[$i]==1){
                if($devObjeto[$i]==1){
                    $sql="SELECT*FROM sop__despacho_db WHERE subtipo='$subtipo' and id_material='".$codigo[$i]."' and id_evento_acc=$idEvento";
                    $resultado=mysqli_query($conexion,$sql);
                    while($filas=mysqli_fetch_array($resultado)){
                        if ($filas['id_material']==$codigo[$i]){
                            if($filas['cantidad']<$cantidad[$i]){
                                $query = "UPDATE sop__despacho_db SET devolucion=cantidad WHERE subtipo='$subtipo' and id_material='".$codigo[$i]."' and id_evento_acc=$idEvento";
                                $consulta=mysqli_query($conexion,$query);
                            }else{
                                $query = "UPDATE sop__despacho_db SET devolucion=".$cantidad[$i]." WHERE subtipo='$subtipo' and id_material='".$codigo[$i]."' and id_evento_acc=$idEvento";
                                $consulta=mysqli_query($conexion,$query);
                            }
                        }
                    }
                }else {
                    $query = "UPDATE sop__despacho_db SET cantidad=".$cantidad[$i]." WHERE subtipo='$subtipo' and id_material='".$codigo[$i]."' and id_evento_acc=$idEvento";
                    $consulta=mysqli_query($conexion,$query);
                }
            } else{
                if ($devObjeto[$i]==1){
                    $sql="SELECT*FROM sop__despacho_db WHERE subtipo='$subtipo' and id_material='".$codigo[$i]."' and id_evento_acc=$idEvento";
                    $resultado=mysqli_query($conexion,$sql);
                    while($filas=mysqli_fetch_array($resultado)){
                        if ($filas['id_material']==$codigo[$i]){
                            if($filas['cantidad']<$cantidad[$i]){
                                $query = "UPDATE sop__despacho_db SET devolucion=cantidad WHERE subtipo='$subtipo' and id_material='".$codigo[$i]."' and id_evento_acc=$idEvento";
                                $consulta=mysqli_query($conexion,$query);
                            }else{
                                $query = "UPDATE sop__despacho_db SET devolucion=".$cantidad[$i]." WHERE subtipo='$subtipo' and id_material='".$codigo[$i]."' and id_evento_acc=$idEvento";
                                $consulta=mysqli_query($conexion,$query);
                            }
                        }
                    }
                }else{
                    if(strlen($codigo[$i])<8){
                        $codigoNuevoProducto="SELECT DISTINCT *FROM sop__materialsc_db WHERE id_sc='".$codigo[$i]."'";
                        $consulta=mysqli_query($conexion,$codigoNuevoProducto);
                        $fila=mysqli_fetch_array($consulta);
                        $codigo[$i]=$fila['id_sc'];
                        $query = " INSERT INTO sop__despacho_db (id_material,id_evento_acc,cantidad,nombre,tipo,subtipo) VALUES ('".$codigo[$i]."',$idEvento,".$cantidad[$i].",'".$nombre[$i]."','".$tipo[$i]."','$subtipo')";
                    }else{
                        $query = " INSERT INTO sop__despacho_db (id_material,id_evento_acc,cantidad,nombre,tipo,subtipo) VALUES ('".$codigo[$i]."',$idEvento,".$cantidad[$i].",'".$nombre[$i]."','".$tipo[$i]."','$subtipo')";
                    }
                    $consulta=mysqli_query($conexion,$query);
                }
            }
        }
    }
        $query = "UPDATE sop__evento_acc_db SET id_estado=2 WHERE id_accion=$idEvento";
        $consulta=mysqli_query($conexion,$query);
?>
