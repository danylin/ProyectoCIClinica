
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
                    <div class="col-sm-3"><p>Fecha Programada <br> <input type="date" min="2021-09-24" name="fecha" id="form-fecha"></p></div> 
                    <div class="col-sm-3"><p>Descripcion del Evento <br> <textarea name="descripcion" id="descr-evento" cols="30" rows="3"></textarea> </p></div>      
                </div>
           <div><p><input type="submit" value="Registrar"></p></div>
            </div>
        </form>
    </div>
</div> 
<div class="usuarios">
    <div class="container-table">
        <div class="table-title"><h3>Eventos Actuales</h3></div>
        <table class="table table-light">
            <thead>
                <th scope="col">Id</th>
                <th scope="col">Fecha de Ingreso</th>
                <th scope="col">Nombre del Paciente</th>
                <th scope="col">Fecha de Programacion</th>
                <th scope="col">Estado</th>
                <th scope="col">Usuario</th>
            </thead>
        <tbody>
            <?php
            $id=$_SESSION['id_sede'];
            include("bd_usuario.php");
            $sql="SELECT a.id_accion, a.fecha,a.nombre_paciente,a.fecha_programacion,b.estado,usuarios_db.usuario
            FROM estados_db b
            INNER JOIN evento_acc_db a on b.id_estado=a.id_estado
            INNER JOIN usuarios_db on a.dni_usuario =usuarios_db.dni 
            INNER JOIN sede__db_area on sede__db_area.id=usuarios_db.id_sede 
            WHERE sede__db_area.id=$id and (a.id_estado=1 or a.id_estado=3);";
            $resultado=mysqli_query($conexion,$sql);
            while($row=mysqli_fetch_array($resultado)){
                echo "<tr>";
                echo "<th scope='row'>". $row['id_accion']."</th>";
                echo "<td>". $row['fecha']."</td>";
                echo "<td>". $row['nombre_paciente']."</td>";
                echo "<td>". $row['fecha_programacion']."</td>";
                echo "<td>". $row['estado']."</td>";
                echo "<td>". $row['usuario']."</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
        </table>
    </div>
</div>
<script>
    $("#form-fecha").datepicker({
    changeMonth: true, 
    changeYear: true, 
    minDate: 0,
    maxDate: 'today',
    dateFormat: 'yy-mm-dd',
    onSelect: function(dateText) {
        $sD = new Date(dateText);
        $("input#form-fecha").datepicker('option', 'minDate', min);
        } 
    });
</script>