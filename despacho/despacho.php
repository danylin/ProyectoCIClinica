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
        $('#formManual').submit(function(event) {
          event.preventDefault();
          var nombre=$('#nombreManual').val();
          var cantidad=$('#cantidadManual').val();
          $.ajax({
            type:'POST',
            url:'creacionDespacho.php',
            data:{nombre:nombre,cantidad:cantidad},
            success: function(data){
                $('#mensaje').append(data);
                $('#formManual')[0].reset();
            }
        });
        });
      });
      $('#tabla_elementos').dataTable({
          "pageLength": 5
      }); 
    </script>
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
          echo "<td><button type='button' class='btn btn-success' id='btnDevolucion'>Devolución</button></td>";
          echo "</tr>";
          ?>
        </table>
      </div>
      <div class="form-group">
        <label>Codigo</label>
        <input type="text" id='codigo' name="codigo" class="form-control" autofocus="autofocus" required >
      </div>
      <br>
    </form>
    <div class="form-group">
        <input type="submit" form='formMaterial' id="enviar" class="btn btn-success" value="Buscar">
        <button class="btn btn-success" onclick="ingresoManual()">Ingreso Manual</button>
        <button class="btn btn-success" onclick="busquedaManual()">Búsqueda Manual</button>
    </div>
    <form action="registrarDespacho.php?codigo=<?php echo $evento ?>" method="POST" id="registro_Despacho">
      <table class="table table-striped" id="tabla_elementos">
        <thead>
          <th>Codigo</th>
          <th>Descripcion</th>
          <th>Cantidad</th>
          <th> <input type='hidden' id='devolucion' value='' name='devolucion'> </th>
        </thead>
        <tbody id="mensaje">
        </tbody>  
      </table>
      <button type="submit" form="registro_Despacho" class="btn btn-success">Registrar</button>
    </form>
    <form action="" id="formManual">
      <div class="overlay" id="overlay1">
        <div class="popup">
          <div id="encabezado_popup">
            <h3>Ingreso Manual</h3>
            <a onclick="cerrar1()" id="cerrar_Popup"><i class="fas fa-times"></i></a>
          </div>
          <p>Nombre del Producto: <br><input type="text" id="nombreManual" name="nombreManual"></p>
          <p>Cantidad <br><input type="number" id="cantidadManual" name="cantidadManual"></p>
          <button type="submit" form='formManual' onclick="cerrar1()">Registrar</button>
        </div>
      </div>
    </form>
    <form action="" id="formBusqueda">
      <div class="overlay" id="overlay2">
        <div class="popup">
          <div id="encabezado_popup">
            <h3>Busqueda Manual</h3>
            <a onclick="cerrar2()" id="cerrar_Popup"><i class="fas fa-times"></i></a>
          </div>
          Nombre del Producto: <input type="search" name="busqueda" id="busqueda">
          <table id="materialesDespacho">
            <thead>
              <th>Nombre</th>
              <th>Cantidad</th>
            </thead>
            <tbody>
              <?php
                $consultaProductos="SELECT TOP 50 *FROM material__db";
                $resultadoProductos=mysqli_query($conexion,$consultaProductos);
                while($filaP=mysqli_fetch_array($resultadoProductos)){
                  echo "<tr>";
                  echo "<td>".$fila['codigo']."</td>";
                  echo "<td>".$fila['descripcion']."</td>";
                  echo "</tr>";
                }
              ?>
            </tbody>
          </table>
          <button type="submit" form='formBusqueda' onclick="cerrar2()">Registrar</button>
        </div>
      </div>
    </form>
    </section>
</body>
<script>
  function ingresoManual(){
    document.getElementById("overlay1").style.visibility = "visible";
  };
  function cerrar1(){
    document.getElementById("overlay1").style.visibility = "hidden";
  }
  function busquedaManual(){
    document.getElementById("overlay2").style.visibility = "visible";
  };
  function cerrar2(){
    document.getElementById("overlay2").style.visibility = "hidden";
  };
  var contar=0;
        $('#btnDevolucion').on('click',function(){
          if(contar==0){
            $('.tituloDespacho').css('background-color','red');
            contar=1;
            $('#devolucion').val(1);
          } else{
            $('.tituloDespacho').css('background-color','white');
            contar=0;
            $('#devolucion').val(0);
          }
      });
</script>
</html>

