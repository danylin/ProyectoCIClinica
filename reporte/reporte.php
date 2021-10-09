<!DOCTYPE html>
<html >
<head>
    <?php
    include("../include/titulo.php")
    ?>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <img class="navbar-brand" src="../img/logotipo_auna.png" alt="logotipo auna">
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item active"><a class="nav-link" href="../usuario2.php">EVENTOS <i class="fa fa-plus-square" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="../usuario/Usuarios.php">USUARIOS <i class="fa fa-user" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="../include/logout.php">SALIR <i class="fas fa-sign-out-alt"></i></a></li>
          </ul>
        </div>
      </nav>
    </header>
    <section>
        <?php
        include("../include/bd_usuario.php");
        $nroEvento=$_GET['codigo'];
        $sql="SELECT a.fecha_programacion,a.codigo_cierre, CONCAT(a.nombre_paciente,' ',a.apellido_paciente) paciente,b.nombre,a.nombre_responsable
        FROM evento_acc_db a 
        INNER JOIN eventos_db b ON
        a.id_evento=b.id_evento
        WHERE a.id_accion=$nroEvento;";
        $resultado=mysqli_query($conexion,$sql);
        $row=mysqli_fetch_array($resultado);
        ?>
        <div id="reporteEvento">
            <h3>Reporte de Evento</h3>
        </div>
        <div id="informacio-general">
            <div class="container-flex">
                <div class="row">
                    <div class="col-sm-2"><p>Nro de Encuentro</p></div>
                    <div class="col-sm-2"><?php echo $row['codigo_cierre'] ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-2"><p>Fecha</p></div>
                    <div class="col-sm-2"><?php echo $row['fecha_programacion'] ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-2"><p>Paciente</p></div>
                    <div class="col-sm-2"><?php echo $row['paciente'] ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-2"><p>Procedimiento</p></div>
                    <div class="col-sm-2"><?php echo $row['nombre'] ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-2"><p>Cirujano Principal</p></div>
                    <div class="col-sm-2"><?php echo $row['nombre_responsable'] ?></div>
                </div>
            </div>
        </div>
        <div>
            <table class="table table-light">
                <thead>
                    <th>Codigo de Material</th>
                    <th>Descripcion del Material</th>
                    <th>Cantidad</th>
                    <th>Tipo</th>
                </thead>
                <tbody>
            <?php
            $materiales="SELECT id_material,nombre,(cantidad-devolucion) resultado
            FROM despacho_db
            WHERE id_evento_acc=$nroEvento";
            $resultado=mysqli_query($conexion,$materiales);
            while ($row=mysqli_fetch_array($resultado)){
                echo "<tr>";
                echo "<td>".$row['id_material']."</td>";
                echo "<td>".$row['nombre']."</td>";
                echo "<td>".$row['resultado']."</td>";
                echo "</tr>";
            }
            ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>