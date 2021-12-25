<?php
// El presente archivo tiene por objetivo filtrar los eventos segun el estado en que se encuentren es de decir: Programado, En Proceso, Cerrado o Suspendido
                include("bd_usuario.php");
                session_start();
                $id=$_SESSION['id_sede'];
                $tipoUsuario=$_SESSION['tipousuario'];
                $estado=$_POST['estado'];
                $sql="SELECT a.id_accion,TIME_FORMAT(a.hora,'%H:%i') horaF,a.codigo_cierre,a.hora,a.id_estado,a.nombre_responsable,a.id_evento,a.descripcion_evento, a.fecha,a.nombre_paciente,a.apellido_paciente,a.fecha_programacion,b.estado,sop__usuarios_db.usuario
                FROM sop__evento_acc_db a
                INNER JOIN sop__estados_db b on b.id_estado=a.id_estado
                INNER JOIN sop__usuarios_db on a.dni_usuario =sop__usuarios_db.dni 
                INNER JOIN sede__db_area on sede__db_area.id=sop__usuarios_db.id_sede 
                WHERE sede__db_area.id=$id and a.id_estado=$estado
                ORDER BY a.fecha_programacion,horaF,a.apellido_paciente asc;";
                $resultado=mysqli_query($conexion,$sql);
                while($row=mysqli_fetch_array($resultado)){
                    if ($estado!=3){
                ?>
                    <tr class='fila' onclick='redireccion(<?php echo $row["id_estado"]; ?>,<?php echo $row["id_accion"]; ?>,<?php echo $row["id_evento"]; ?>)'>
                <?php
                }elseif($tipoUsuario==3 && $estado==3){
                ?>
                    <tr class='fila' onclick='reabrir(<?php echo $row["id_accion"]; ?>)'>
                <?php
                }else{
                ?>
                    <tr class='filaFinalizada'>
                <?php
                }
                    echo "<td class='numeroFila'></td>";
                    echo "<td>". $row['id_accion']."</td>";
                    echo "<td>". $row['fecha_programacion']."</td>";
                    echo "<td>". $row['horaF']."</td>";
                    echo "<td>". $row['nombre_paciente']."</td>";
                    echo "<td>". $row['apellido_paciente']."</td>";
                    echo "<td>". $row['estado']."</td>";
                    echo "<td style='display:none'>". $row['id_evento']."</td>";
                    echo "<td>". $row['nombre_responsable']."</td>";
                    echo "<td>". $row['descripcion_evento']."</td>";
                    echo "<td style='display:none;'>". $row['codigo_cierre']."</td>";
                if ($estado!=3){
                    echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
                    echo "<div class='editarEvento'><button class='btn btn-info' id='editarEvento' onclick='editar(this)'><i class='fas fa-edit'></i></button></div>";
                    echo "</td>";
                }else{
                    echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
                    echo "<div class='editarEvento'><button class='btn btn-info' id='editarEvento' onclick='reporte(this)'><i class='fas fa-file-alt'></i></button></div>";
                    echo "</td>";
                }
                    echo "<td style='display:none;'>". $row['id_evento']."</td>";
                    echo "</tr>";
                }
                    
?>