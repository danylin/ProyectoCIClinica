<!DOCTYPE html>
<html >
<head>
    <?php
    include("../include/titulo.php")
    ?>
<link rel="stylesheet" href="../estilos.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js" integrity="sha512-tVYBzEItJit9HXaWTPo8vveXlkK62LbA+wez9IgzjTmFNLMBO1BEYladBw2wnM3YURZSMUyhayPCoLtjGh84NQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
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
        <button onclick='generarPDF(<?php echo $_GET["codigo"]; ?>,<?php echo $_GET["encuentro"]; ?> )' id='botonGenerar'>Generar PDF</button>
        <div id="reporteResultado">
            <?php
            include("../include/bd_usuario.php");
            $nroEvento=$_GET['codigo'];
            $nroEncuentro=$_GET['encuentro'];
            $encuentro="UPDATE evento_acc_db SET codigo_cierre=$nroEncuentro,id_estado=3 WHERE id_accion=$nroEvento";
            $resultado=mysqli_query($conexion,$encuentro);
            $sql="SELECT a.fecha_programacion,a.codigo_cierre, CONCAT(a.nombre_paciente,' ',a.apellido_paciente) paciente,b.nombre,a.nombre_responsable
            FROM evento_acc_db a 
            INNER JOIN eventos_db b ON
            a.id_evento=b.id_evento
            WHERE a.id_accion=$nroEvento;";
            $cantidadConsulta="SELECT SUM(cantidad-devolucion) total FROM despacho_db WHERE id_evento_acc=$nroEvento;";
            $itemsConsulta="SELECT  COUNT(nombre) total FROM despacho_db WHERE id_evento_acc=$nroEvento;";
            $resultado=mysqli_query($conexion,$sql);
            $cantidadTotal=mysqli_query($conexion,$cantidadConsulta);
            $cantidadItems=mysqli_query($conexion,$itemsConsulta);
            $row=mysqli_fetch_array($resultado);
            $resultadoCantidad=mysqli_fetch_array($cantidadTotal);
            $totalItems=mysqli_fetch_array($cantidadItems);
            ?>
            <div id="reporteEvento">
                <h3>Reporte de Evento</h3>
            </div>
            <div id="informacio-general">
                    <table>
                        <tr>
                            <td>Nro de Encuentro</td>
                            <td><?php echo $row['codigo_cierre'] ?></td>
                        </tr>
                        <tr>
                            <td>Fecha</td>
                            <td><?php echo $row['fecha_programacion'] ?></td>
                        </tr>
                        <tr>
                            <td>Paciente</td>
                            <td><?php echo $row['paciente'] ?></td>
                        </tr>
                        <tr>
                            <td>Procedimiento</td>
                            <td><?php echo $row['nombre'] ?></td>
                        </tr>
                        <tr>
                            <td>Cirujano Principal</td>
                            <td><?php echo $row['nombre_responsable'] ?></td>
                        </tr>
                        <tr>
                            <td>Número de Items</td>
                            <td><?php echo $totalItems['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Cantidad Total Utilizada</td>
                            <td><?php echo $resultadoCantidad['total'] ?></td>
                        </tr>
                    </table>
            </div>
            <div id='registroElementos'>
                <table id="elementos">
                    <thead>
                        <th>Codigo de Material</th>
                        <th>Descripcion del Material</th>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                    </thead>
                    <tbody>
                <?php
                $materiales="SELECT id_material,nombre,(cantidad-devolucion) resultado,tipo
                FROM despacho_db
                WHERE id_evento_acc=$nroEvento";
                $resultado=mysqli_query($conexion,$materiales);
                while ($row=mysqli_fetch_array($resultado)){
                    echo "<tr>";
                    echo "<td>".$row['id_material']."</td>";
                    echo "<td>".$row['nombre']."</td>";
                    echo "<td>".$row['resultado']."</td>";
                    echo "<td>".$row['tipo']."</td>";
                    echo "</tr>";
                }
                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
<script>
    function generarPDF(a,b) {
            window.open('pdf.php?codigo='+a+'&encuentro='+b);
    }
</script>
</html>