<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Control de Inventarios</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;400&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#formMaterial').submit(function(event) {
          event.preventDefault();
          var codigo=$('#codigo').val();
          $.ajax({
            type:'POST',
            url:'creacionDespacho.php',
            data:{codigo:codigo},
            success: function(data){
                $('#mensaje').append(data);
                $('#formMaterial')[0].reset();
            }
        });
        });
      });
    </script>
  </head>
<body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <img class="navbar-brand" src="../img/logotipo_auna.png" alt="logotipo auna">
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item active"><a class="nav-link" href="../usuario2.php">CREACION DE EVENTOS <i class="fa fa-plus-square" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="../usuario/Usuarios.php">CREACION DE USUARIO <i class="fa fa-user" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="#">DESPACHO <i class="fa fa-archive" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="#">REPORTES <i class="fa fa-file" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="../include/logout.php">SALIR <i class="fas fa-sign-out-alt"></i></a></li>
          </ul>
        </div>
      </nav>
    </header>
    <section>
    <form method="post" id="formMaterial">
      <h4 class='tituloDespacho'>EVENTO</h4>
      <div class="form-group">
        <table class='table table-light'>
          <thead>
            <th>Nombre del Paciente</th>
            <th>Responsable</th>
            <th>Evento</th>
            <th>¿Devolución?</th>
          </thead>
          <?php
          session_start();
          include("../include/bd_usuario.php");
          $idSesion=$_SESSION['id'];
          $evento=$_GET['codigo'];
          $sql="SELECT id_accion,CONCAT(nombre_paciente,' ',apellido_paciente) nombre_completo ,nombre_responsable,a.nombre FROM evento_acc_db 
          INNER JOIN eventos_db a on evento_acc_db.id_evento=a.id_evento
          WHERE dni_usuario=$idSesion and (id_estado=1 or id_estado=2) and id_accion=$evento;";
          $consulta=mysqli_query($conexion,$sql);
          $row=mysqli_fetch_array($consulta);
          echo "<tr>";
          echo "<td>" . $row['nombre_completo']. "</td>";
          echo "<td>" . $row['nombre_responsable']. "</td>";
          echo "<td>" . $row['nombre']. "</td>";
          echo "<td><button type='button' onclick='cambiar()' class='btn btn-success' id='btnDevolucion'>Devolución</button></td>";
          echo "</tr>";
          ?>
        </table>
        
      </div>
      <div class="form-group">
        <label>Codigo</label>
        <input type="text" id='codigo' name="codigo" class="form-control" autofocus="autofocus" required >
      </div>
      <div class="form-group">
        <input type="submit" form='formMaterial' id="enviar" class="btn btn-success" value="Buscar">
      </div>
    </form>
    <form action="registrarDespacho.php?codigo=<?php echo $evento ?>" method="POST" id="registro_Despacho">
      <table class="table table-striped">
        <thead>
          <th>Codigo</th>
          <th>Descripcion</th>
          <th>Cantidad</th>
        </thead>
        <tbody id="mensaje">
          <?php
            $existencia="SELECT b.id_material,b.id_evento_acc,a.descripcion,cantidad FROM despacho_db b INNER JOIN material__db a
            on a.codigo=b.id_material
            WHERE id_evento_acc=$evento";
            $referencia=mysqli_query($conexion,$existencia);
            while($row=mysqli_fetch_array($referencia)){
              if(isset($row)){
                echo "<tr>";
                echo "<td>".$row['id_material']."</td>";
                echo "<td>".$row['descripcion']."</td>";
                echo "<td> <input type='number' min=1 max=50 value=".$row['cantidad']." name='cantidad_Material[]'> </td>";
                echo "</tr>";
              }
            }
          ?>
        </tbody>  
      </table>
      <button type="submit" form="registro_Despacho" class="btn btn-success">Registrar</button>
    </form>
    </section>
</body>
<script>
        $('#btnDevolucion').on('click',function(){
        $('.tituloDespacho').css('background-color','red');
      });
</script>
</html>

