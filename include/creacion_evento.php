<div class="overlay" id='overlay1'>
    <div class="popup">
        <div id="encabezado_popup">
            <h3>Registrar Evento</h3>
            <a onclick="cerrar()" id="cerrar_Popup"><i class="fas fa-times"></i></a>
        </div>
        <form action="include/registro_evento.php" method="post" >
            <div class="container-flex">
                <div class="row">
                <div class="col-sm-6"><p>Nombre del Paciente <br> <input type="text" name="nombre" id="nombre" autocomplete="off" required></p></div>
                <div class="col-sm-6"><p>Apellidos del Paciente <br> <input type="text" name="apellido" id="apellido" autocomplete="off" required></p></div>  
                <?php
                    include("include/bd_usuario.php"); 
                    $sql="SELECT*FROM eventos_db;";
                    $sql2="SELECT*FROM usuarios_db WHERE dni=".$_SESSION['id'];
                    $resultado=mysqli_query($conexion,$sql);
                    $resultado2=mysqli_query($conexion,$sql2);
                    $row2=mysqli_fetch_array($resultado2);
                    echo "<div class='col-sm-6'> <p> Evento <br> <select name='evento' required>";
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
                    <div class="col-sm-6"><p>Fecha Programada <br> <input type="date" name="fecha" id="form-fecha" required></p></div> 
                    <div class="col-sm-12"><p>Responsable <br> <input type="text" name="responsable" id="responsable" required></p></div> 
                    <div class="col-sm-12"><p>Descripcion del Evento <br> <textarea name="descripcion" id="descr-evento" cols="30" rows="3" required></textarea></p></div>      
                </div>
                <div>
                    <p><input type="submit" value="Registrar"></p>
                </div>
            </div>
        </form>
    </div>
</div> 
<div class="usuarios">
    <div class="container-table">
        <div class="table-title">
            <h3>Eventos Actuales</h3>
            <button class='btn btn-info' onclick='mostrar()'>Nuevo Evento</button>
            <div class='filtros'>
                <div id='input_buscar'>
                    Desde: <input type="date" name="" id="fechaDesde" >
                    Hasta: <input type="date" name="" id="fechaHasta">
                </div>
            </div>
        </div>
        <table class="table table-light" id='tabla_eventos' data-page-length='25'>
            <thead>
                <th scope="col" onclick="sortTable(0)">Id</th>
                <th scope="col" onclick="sortTable(1)">Fecha de Registro</th>
                <th scope="col" onclick="sortTable(2)">Nombre del Paciente</th>
                <th scope="col" onclick="sortTable(3)">Apellidos del Paciente</th>
                <th scope="col" onclick="sortTable(4)">Fecha de Programacion</th>
                <th scope="col" onclick="sortTable(5)">Estado</th>
                <th scope="col" onclick="sortTable(6)">Usuario</th>
                <th scope="col" onclick="sortTable(7)">Responsable</th>
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
                    echo "<td>". $row['id_accion']."</td>";
                    echo "<td>". $row['fecha']."</td>";
                    echo "<td>". $row['nombre_paciente']."</td>";
                    echo "<td>". $row['apellido_paciente']."</td>";
                    echo "<td>". $row['fecha_programacion']."</td>";
                    echo "<td>". $row['estado']."</td>";
                    echo "<td>". $row['usuario']."</td>";
                    echo "<td>". $row['nombre_responsable']."</td>";
                    echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
                    echo "<div class='botonReporte'><button class='btn btn-success' id='reporte'>Generar Reporte</button></div>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

<script> 
function cerrar(){
    document.getElementById("overlay1").style.visibility = "hidden";
  };
  function mostrar(){
    document.getElementById("overlay1").style.visibility = "visible";
    };
    $('#except .botonReporte button').on('click',function(){
        var row=$(this).closest('tr');
        var id=$(row).find("td").eq(0).html();
        var estado=$(row).find("td").eq(5).html();
        if (estado=="Programado"){
            alert("Error. Este evento no está en proceso, asegurese de ingresar los elementos y que el estado del evento este en Proceso");
        }else{
            window.location="reporte/reporte.php?codigo="+id;
        }
        
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
    document.getElementById('fechaDesde').value=year+"-"+mes+"-"+dia;
    document.getElementById('fechaHasta').value=year+"-"+mes+"-"+dia;
    }

</script>