<div class="cre-evento">
    <div class="reg-evento">
        <h3>Registrar Evento</h3>
        <form method="creacion_evento.php" action="post">
            <div class="container">
                <div class="row">
                <?php
                    include("include/bd_usuario.php"); 
                    error_reporting(0);
                    $sql="SELECT*FROM eventos_db;";
                    $resultado=mysqli_query($conexion,$sql);
                    echo "<div class='col-sm-4'> <p> Evento: <select name='evento'>";
                    while($row=mysqli_fetch_array($resultado)){
                      echo "<option value=".$row['id_evento'].">". $row['nombre'] ."</option>";
                    }
                    echo "</select> </p> </div>";
                ?>
                    <div class="col-sm-4"><p>Fecha Programada: <input type="date" name="fecha" id="form-fecha"></p></div> 
                    <div class="col-sm-4"><p>Nombre del Paciente: <input type="text" name="nombre" id="nombre"></p></div>
                </div>
            <div class="row">    
                <div class="col-sm-12"><p>Descripcion del Evento: <textarea name="descripcion" id="descr-evento" cols="30" rows="3"></textarea> </p></div> 
            </div>        
           <div><p><input type="submit" value="Ingresar"></p></div>
            </div>
        </form>
    </div>
</div> 
    <div class="container-table">
        <div class="table-title"><h3>Eventos Actuales</h3></div>
        <table class="table table-light">
            <thead>
                <th scope="col">id</th>
                <th scope="col">Fecha de Ingreso</th>
                <th scope="col">Usuario</th>
                <th scope="col">Nombre del Paciente</th>
            </thead>
        <tbody>
            <?php
            include("bd_usuario.php");
            $sql="SELECT*FROM evento_acc_db;";
            $resultado=mysqli_query($conexion,$sql);
            while($row=mysqli_fetch_array($resultado)){
                echo "<tr>";
                echo "<th scope='row'>". $row['id_accion']."</th>";
                echo "<td>". $row['fecha']."</td>";
                echo "<td>". $row['usuario']."</td>";
                echo "<td>". $row['nombre_paciente']."</td>";
                echo "<td>". $row['nombre_paciente']."</td>";
                echo "<td>". $row['nombre_paciente']."</td>";
                echo "<td>". $row['nombre_paciente']."</td>";
                echo "<td>". $row['nombre_paciente']."</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
        </table>
    </div>