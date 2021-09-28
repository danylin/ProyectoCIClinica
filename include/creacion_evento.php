
<div class="cre-evento">
    <div class="formu-registro">
        <h3>Registrar Evento</h3>
        <form action="include/registro_evento.php" method="post" >
            <div class="container-fluid">
                <div class="row">
                <div class="col-sm-3"><p>Nombre del Paciente <br> <input type="text" name="nombre" id="nombre" autocomplete="off"></p></div>  
                <?php
                    include("include/bd_usuario.php"); 
                    $sql="SELECT*FROM eventos_db;";
                    $resultado=mysqli_query($conexion,$sql);
                    echo "<div class='col-sm-3'> <p> Evento <br> <select name='evento'>";
                    while($row=mysqli_fetch_array($resultado)){
                      echo "<option value=".$row['id_evento'].">". $row['nombre'] ."</option>";
                    }
                    echo "</select> </p> </div>";
                ?>
                    <div class="col-sm-3"><p>Fecha Programada <br> <input type="date" min="0" name="fecha" id="form-fecha"></p></div> 
                    <div class="col-sm-3"><p>Descripcion del Evento <br> <textarea name="descripcion" id="descr-evento" cols="30" rows="3"></textarea> </p></div>      
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
        <table class="table table-light" id='tabla-eventos'>
            <thead>
                <th scope="col" onclick="sortTable(0)">Id</th>
                <th scope="col" onclick="sortTable(1)">Fecha de Ingreso</th>
                <th scope="col" onclick="sortTable(2)">Nombre del Paciente</th>
                <th scope="col" onclick="sortTable(3)">Fecha de Programacion</th>
                <th scope="col" onclick="sortTable(4)">Estado</th>
                <th scope="col" onclick="sortTable(5)">Usuario</th>
                <th scope="col" onclick="sortTable(6)">Responsable</th>
            </thead>
            <tbody>
                <?php
                $id=$_SESSION['id_sede'];
                include("bd_usuario.php");
                $sql="SELECT a.id_accion,a.nombre_responsable, a.fecha,a.nombre_paciente,a.fecha_programacion,b.estado,usuarios_db.usuario
                FROM estados_db b
                INNER JOIN evento_acc_db a on b.id_estado=a.id_estado
                INNER JOIN usuarios_db on a.dni_usuario =usuarios_db.dni 
                INNER JOIN sede__db_area on sede__db_area.id=usuarios_db.id_sede 
                WHERE sede__db_area.id=$id and (a.id_estado=1 or a.id_estado=3);";
                $resultado=mysqli_query($conexion,$sql);
                while($row=mysqli_fetch_array($resultado)){
                    echo "<tr class='fila'>";
                    echo "<td scope='row'>". $row['id_accion']."</td>";
                    echo "<td>". $row['fecha']."</td>";
                    echo "<td>". $row['nombre_paciente']."</td>";
                    echo "<td>". $row['fecha_programacion']."</td>";
                    echo "<td>". $row['estado']."</td>";
                    echo "<td>". $row['usuario']."</td>";
                    echo "<td>". $row['nombre_responsable']."</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
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
    var ano = fecha.getFullYear(); //obteniendo año
    if(dia<10)
        dia='0'+dia; //agrega cero si el menor de 10
    if(mes<10)
        mes='0'+mes //agrega cero si el menor de 10
    document.getElementById('form-fecha').min=ano+"-"+mes+"-"+dia;
    }
</script>