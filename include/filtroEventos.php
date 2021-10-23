<?php
                include("bd_usuario.php");
                session_start();
                $id=$_SESSION['id_sede'];
                $estado=$_POST['estado'];
                $sql="SELECT a.id_accion,a.codigo_cierre,a.id_estado,a.nombre_responsable,a.id_evento,a.descripcion_evento, a.fecha,a.nombre_paciente,a.apellido_paciente,a.fecha_programacion,b.estado,usuarios_db.usuario
                FROM evento_acc_db a
                INNER JOIN estados_db b on b.id_estado=a.id_estado
                INNER JOIN usuarios_db on a.dni_usuario =usuarios_db.dni 
                INNER JOIN sede__db_area on sede__db_area.id=usuarios_db.id_sede 
                WHERE sede__db_area.id=$id and a.id_estado=$estado
                ORDER BY a.fecha_programacion desc;";
                $resultado=mysqli_query($conexion,$sql);
                while($row=mysqli_fetch_array($resultado)){
                ?>
                <tr class='fila' onclick='redireccion(<?php echo $row["id_estado"]; ?>,<?php echo $row["id_accion"]; ?>)'>
                <?php
                    echo "<td style='display:none;'>". $row['id_accion']."</td>";
                    echo "<td>". $row['fecha_programacion']."</td>";
                    echo "<td>". $row['nombre_paciente']."</td>";
                    echo "<td>". $row['apellido_paciente']."</td>";
                    echo "<td>". $row['estado']."</td>";
                    echo "<td>". $row['nombre_responsable']."</td>";
                    echo "<td>". $row['descripcion_evento']."</td>";
                    echo "<td style='display:none;'>". $row['codigo_cierre']."</td>";
                    echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
                    echo "<div class='editarEvento'><button class='btn btn-info' id='editarEvento'><i class='fas fa-edit'></i></button></div>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>