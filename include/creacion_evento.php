
<div class="cre-evento" id='cre-evento'>
    <div class="formu-registro">
        <h3>Registrar Evento</h3>
        <form action="include/registro_evento.php" method="post" >
            <div class="container-flex">
                <div class="row">
                <div class="col-sm-3"><p>Nombre del Paciente <br> <input type="text" name="nombre" id="nombre" autocomplete="off"></p></div>
                <div class="col-sm-3"><p>Apellidos del Paciente <br> <input type="text" name="apellido" id="apellido" autocomplete="off"></p></div>  
                <?php
                    include("include/bd_usuario.php"); 
                    $sql="SELECT*FROM eventos_db;";
                    $sql2="SELECT*FROM usuarios_db WHERE dni=".$_SESSION['id'];
                    $resultado=mysqli_query($conexion,$sql);
                    $resultado2=mysqli_query($conexion,$sql2);
                    $row2=mysqli_fetch_array($resultado2);
                    echo "<div class='col-sm-3'> <p> Evento <br> <select name='evento'>";
                    while($row=mysqli_fetch_array($resultado)){
                        if ($row2['Evento1']==1 and $row['id_evento']==1) {
                            echo "<option value=".$row['id_evento'].">". $row['nombre'] ."</option>";
                        }
                         elseif($row2['Evento2']==1 and $row['id_evento']==2) {
                            echo "<option value=".$row['id_evento'].">". $row['nombre'] ."</option>";
                        }
                        elseif($row2['Evento3']==1 and $row['id_evento']==3){
                            echo "<option value=".$row['id_evento'].">". $row['nombre'] ."</option>";
                        }                  
                        elseif($row2['Evento4']==1 and $row['id_evento']==4) {
                            echo "<option value=".$row['id_evento'].">". $row['nombre'] ."</option>";
                        }    
                     }
                    echo "</select> </p> </div>";
                ?>
                    <div class="col-sm-3"><p>Fecha Programada <br> <input type="date" name="fecha" id="form-fecha"></p></div> 
                    <div class="col-sm-12"><p>Responsable <br> <input type="text" name="responsable" id="responsable"></p></div> 
                    <div class="col-sm-12"><p>Descripcion del Evento <br> <textarea name="descripcion" id="descr-evento" cols="30" rows="3"></textarea> </p></div>      
                </div>
           <div><p><input type="submit" value="Registrar"></p></div>
            </div>
        </form>
    </div>
</div> 
<div class="usuarios">
    <div class="container-table">
        <div class="table-title">
            <h3>Eventos Actuales</h3>
        </div>
        <div class='filtros'>
            <select id="selector">
                    <option value=0>Id</option>
                    <option value=1>Fecha de Ingreso</option>
                    <option value=2>Nombre del Paciente</option>
                    <option value=3>Fecha de Programacion</option>
                    <option value=6>Responsable</option>
                </select>
                <button onclick="sortTable(document.getElementById('selector').value)">Ordenar</button>
            <div id='input_buscar'>
                <input type="search" name="" id="busqueda" placeholder="Buscar">
            </div>
        </div>
        <table class="table table-light" id='tabla-eventos'>
            <thead>
                <th scope="col" >Id</th>
                <th scope="col" >Fecha de Ingreso</th>
                <th scope="col" >Nombre del Paciente</th>
                <th scope="col" >Apellidos del Paciente</th>
                <th scope="col" >Fecha de Programacion</th>
                <th scope="col" >Estado</th>
                <th scope="col" >Usuario</th>
                <th scope="col" >Responsable</th>
            </thead>
            <tbody id='tabla_contenido'>
                <?php
                $id=$_SESSION['id_sede'];
                include("bd_usuario.php");
                $sql="SELECT a.id_accion,a.nombre_responsable, a.fecha,a.nombre_paciente,a.apellido_paciente,a.fecha_programacion,b.estado,usuarios_db.usuario
                FROM estados_db b
                INNER JOIN evento_acc_db a on b.id_estado=a.id_estado
                INNER JOIN usuarios_db on a.dni_usuario =usuarios_db.dni 
                INNER JOIN sede__db_area on sede__db_area.id=usuarios_db.id_sede 
                WHERE sede__db_area.id=$id and (a.id_estado=1 or a.id_estado=2)
                ORDER BY a.fecha_programacion desc;";
                $resultado=mysqli_query($conexion,$sql);
                while($row=mysqli_fetch_array($resultado)){
                ?>
                <tr class='fila' onclick='javascript:location.href="despacho/despacho.php?codigo=<?php echo $row["id_accion"]; ?>";'>
                <?php
                    echo "<td scope='row'>". $row['id_accion']."</td>";
                    echo "<td>". $row['fecha']."</td>";
                    echo "<td>". $row['nombre_paciente']."</td>";
                    echo "<td>". $row['apellido_paciente']."</td>";
                    echo "<td>". $row['fecha_programacion']."</td>";
                    echo "<td>". $row['estado']."</td>";
                    echo "<td>". $row['usuario']."</td>";
                    echo "<td>". $row['nombre_responsable']."</td>";
                    echo "<td><button onclick='event.cancelBubble=true; return false;' class='btn btn-success' id='editButton' value=".$row['id_accion'].">Editar</button></td>";
                    echo "</tr>";
                }
                ?>
                
            </tbody>
        </table>
    </div>
</div>
<script> 
   $('#editButton').on('click',function(){
    alert("Hola Mundo");

   });
            
    $('#busqueda').on('keyup',function(){
        var valor=$(this).val().toLowerCase();
        $('#tabla_contenido tr').filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(valor)>-1);
        });
    });
    function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("tabla-eventos");
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
        shouldSwitch = false;
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
        if (dir == "asc") {
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            shouldSwitch = true;
            break;
            }
        } else if (dir == "desc") {
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            shouldSwitch = true;
            break;
            }
        }
        }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount ++;
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
        }
    }
    }
    window.onload = function(){
    var fecha = new Date(); //Fecha actual
    var mes = fecha.getMonth()+1; //obteniendo mes
    var dia = fecha.getDate(); //obteniendo dia
    var year = fecha.getFullYear(); //obteniendo año
    if(dia<10)
        dia='0'+dia; 
    if(mes<10)
        mes='0'+mes 
    document.getElementById('form-fecha').min=year+"-"+mes+"-"+dia;
    }

</script>