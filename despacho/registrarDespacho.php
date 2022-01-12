<?php
// El presente apartado 
    include("../include/bd_usuario.php");
    $idEvento=$_GET['evento'];
    $codigo=$_POST['codigo'];
    $cantidad=$_POST['cantidad'];
    $nombre=$_POST['descripcion'];
    $tipo=$_POST['tipo'];
    $devObjeto=$_POST['devObjeto'];
    $update=$_POST['update'];
    $contador; //Esta variable permitira saber si el material se repite mas de una vez
    for($i=count($codigo)-1;$i>=0;$i--){
        $contador=0;
        $pruebaExistencia="SELECT*FROM sop__despacho_db WHERE id_evento_acc=$idEvento and id_material='".$codigo[$i]."';";
        $pruebaConsulta=mysqli_query($conexion,$pruebaExistencia);
        while($despachos=mysqli_fetch_array($pruebaConsulta)){
            if($despachos['id_material']==$codigo[$i]){
                $contador=1; //Esto permitira leer el array y si existe actualmente un material dentro de sop__despacho_db 
            }
        }
        if($contador==1){
            if($update[$i]==0){
                if($devObjeto[$i]==1){ //Determinara si es devolucion o entrega
                    $consulta="SELECT*FROM sop__despacho_db  WHERE id_material='".$codigo[$i]."' and id_evento_acc=$idEvento;";
                    $consultaq=mysqli_query($conexion,$consulta);
                    $fila=mysqli_fetch_array($consultaq);
                    if($fila['devolucion']==0){
                        $query = "UPDATE sop__despacho_db SET devolucion=IF(cantidad<$cantidad[$i]+1,cantidad,$cantidad[$i]) WHERE id_material='".$codigo[$i]."' and id_evento_acc=$idEvento;";
                        $consulta=mysqli_query($conexion,$query);    
                    }else{
                        $query = "UPDATE sop__despacho_db SET devolucion=IF(cantidad<devolucion+1,cantidad,devolucion+1) WHERE id_material='".$codigo[$i]."' and id_evento_acc=$idEvento;";
                    }
                    $consulta=mysqli_query($conexion,$query);
                }else {
                    $query = "UPDATE sop__despacho_db SET cantidad=cantidad+1 WHERE id_material='".$codigo[$i]."' and id_evento_acc=$idEvento;";
                    $consulta=mysqli_query($conexion,$query);
                }
            }elseif($update[$i]==1){
                $consulta="SELECT*FROM sop__despacho_db  WHERE id_material='".$codigo[$i]."' and id_evento_acc=$idEvento;";
                $consultaq=mysqli_query($conexion,$consulta);
                $fila=mysqli_fetch_array($consultaq);
                    if($devObjeto[$i]==1){
                        if($cantidad[$i]!=$fila['devolucion']){
                            $query = "UPDATE sop__despacho_db SET devolucion=IF(cantidad<$cantidad[$i]+1,cantidad,$cantidad[$i]) WHERE id_material='".$codigo[$i]."' and id_evento_acc=$idEvento;";
                            $consulta=mysqli_query($conexion,$query);    
                        }
                    }else{
                        if($cantidad[$i]!=$fila['cantidad']){
                            $query = "UPDATE sop__despacho_db SET cantidad=$cantidad[$i] WHERE id_material='".$codigo[$i]."' and id_evento_acc=$idEvento;";
                            $consulta=mysqli_query($conexion,$query);
                        }
                    }
            }
        }else{ //Si no es un valor existente dentro de la base de datos se procedera de la siguiente manera
            if(strlen($codigo[$i])<8){
                $codigoNuevoProducto="SELECT DISTINCT *FROM sop__materialsc_db WHERE id_sc='".$codigo[$i]."';";
                $consulta=mysqli_query($conexion,$codigoNuevoProducto);
                $fila=mysqli_fetch_array($consulta);
                $codigo[$i]=$fila['id_sc'];
                $query = " INSERT INTO sop__despacho_db (id_material,id_evento_acc,cantidad,nombre,tipo,fecha_ingreso,hora_ingreso) VALUES ('".$codigo[$i]."',$idEvento,".$cantidad[$i].",'".$nombre[$i]."','".$tipo[$i]."',DATE(NOW()),TIME(NOW()));";
                }else{
                    $query = "INSERT INTO sop__despacho_db (id_material,id_evento_acc,cantidad,nombre,tipo,fecha_ingreso,hora_ingreso) VALUES ('".$codigo[$i]."',$idEvento,".$cantidad[$i].",'".$nombre[$i]."','".$tipo[$i]."',DATE(NOW()),TIME(NOW()));";
                }
            $consulta=mysqli_query($conexion,$query);
        }
    }
        $query = "UPDATE sop__evento_acc_db SET id_estado=2 WHERE id_accion=$idEvento;";
        $consulta=mysqli_query($conexion,$query);
?>