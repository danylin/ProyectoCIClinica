<!DOCTYPE html>
<html>
<head>
  <?php
  session_start();
  include("../include/bd_usuario.php");
  $idSesion=$_SESSION['id'];
  $evento=$_GET['codigo'];
  ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Control de Inventarios</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;400&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
          setInterval(function(){ 
            var table = document.getElementById("mensaje");
            var subtipo=document.getElementById("subtipo").value;
              for (var i = 0, row; row = table.rows[i]; i++) {
                var codigo=row.cells[0].innerText;
                var descripcion=row.cells[1].innerText;
                var cantidad=row.cells[2].children[0].value;
                var tipo=row.cells[3].innerText;
                var update=row.cells[5].children[0].value;
                var devObjeto=row.cells[6].children[0].value;
                $.ajax({
                type:'POST',
                url:'registrarDespacho.php?evento=<?php echo $evento ?>',
                data:{codigo:codigo,descripcion:descripcion,cantidad:cantidad,tipo:tipo,subtipo:subtipo,devObjeto:devObjeto,update:update},
               });
               if(update==0){
                row.cells[5].children[0].value=1
               }
              }
            }, 50000);
            $('#btnGuardado').on('click',function(event){
              event.preventDefault();
              var table = document.getElementById("mensaje");
            var subtipo=document.getElementById("subtipo").value;
              for (var i = 0, row; row = table.rows[i]; i++) {
                var codigo=row.cells[0].innerText;
                var descripcion=row.cells[1].innerText;
                var cantidad=row.cells[2].children[0].value;
                var tipo=row.cells[3].innerText;
                var update=row.cells[5].children[0].value;
                var devObjeto=row.cells[6].children[0].value;
                $.ajax({
                type:'POST',
                url:'registrarDespacho.php?evento=<?php echo $evento ?>',
                data:{codigo:codigo,descripcion:descripcion,cantidad:cantidad,tipo:tipo,subtipo:subtipo,devObjeto:devObjeto,update:update},
               });
               if(update==0){
                row.cells[5].children[0].value=1
               }
            }
            alert("Se han guardado los items con éxito");
            });
        $("#codigo").keyup(function(event) {
          event.preventDefault();
          if (event.keyCode === 13) {
              $("#enviar").trigger("click");
              $('#codigo').val("");
          }
      });
        $('#formMaterial').submit(function(event) {
          event.preventDefault();
          var codigo=$('#codigo').val();
          var devolucion=$('#devolucion').val();
          var tipoEvento=$('#tipoEvento').val();
          $.ajax({
            type:'POST',
            url:'creacionDespacho.php',
            data:{codigo:codigo,devolucion:devolucion,tipoEvento:tipoEvento},
            success: function(data){
                $('#mensaje').prepend(data);
                $('#formMaterial')[0].reset();
            }
        });
        });
        $('#formManual').submit(function(event) {
          event.preventDefault();
          var nombre=$('#nombreManual').val();
          var cantidad=$('#cantidadManual').val();
          var devolucion=$('#devolucion').val();
          var tipoEvento=$('#tipoEvento').val();
          $.ajax({
            type:'POST',
            url:'creacionDespacho.php',
            data:{nombre:nombre,cantidad:cantidad,devolucion:devolucion,tipoEvento:tipoEvento},
            success: function(data){
                $('#mensaje').prepend(data);
                $('#formManual')[0].reset();
            }
        });
        });
        var contar=0;
        $('#btnDevolucion').on('click',function(){
          if(contar==0){
              $('.tituloDespacho').toggleClass("backgroundRojo");
            contar=1;
            $('#devolucion').val(1);
            $('#devolucionVer').val(1);
            $('#btnDevolucion').html('Desactivar');
            $('#btnDevolucion').attr("class","btn btn-danger")
          } else{
              $('.tituloDespacho').toggleClass("backgroundRojo");
            contar=0;
            $('#devolucion').val(0);
            $('#devolucionVer').val(0);
            $('#btnDevolucion').html('Activar');
            $('#btnDevolucion').attr("class","btn btn-success")
          }
      });
      $('#busqueda').on('keyup',function(){
        $("#resultadoBusqueda tr").remove(); 
        var nombre=$('#busqueda').val();
        var devolucion=$('#devolucion').val();
        var tipoEvento=$('#tipoEvento').val();
          $.ajax({
            type:'POST',
            url:'busquedaManual.php',
            data:{nombre:nombre,devolucion:devolucion,tipoEvento:tipoEvento},
            success: function(data){
                $('#resultadoBusqueda').prepend(data);
            }
        });
      });
      $('#llenadoEncuentro2').on('click',function(){
        var row=$('#except .botonReporte button').closest('tr');
        var id=$(row).find("td").eq(3).html();
        var encuentro=$('#encuentro').val();
        window.open("../reporte/pdf.php?codigo="+id+"&encuentro="+encuentro,'_blank');
        window.location="../usuario2.php";
    });
    $('#llenadoEncuentro1').on('click',function(){
        var row=$('#except .botonReporte button').closest('tr');
        var id=$(row).find("td").eq(3).html();
        var encuentro=$('#encuentro').val();
        var tipoEvento=$('#tipoEvento').val();
        window.open("../reporte/pdf_subTipo.php?codigo="+id+"&encuentro="+encuentro+"&tipoEvento="+tipoEvento,'_blank');
        window.location="../usuario2.php";
    });
    $('#subtipo').on('change',function(){
      $("#mensaje tr").remove();
      var subtipo=$(this).val();
          $.ajax({
            type:'POST',
            url:'filtroDespacho.php?evento=<?php echo $evento ?>',
            data:{subtipo:subtipo},
            success: function(data){
                $('#mensaje').append(data);
            }
        });
    });
      });
    </script>
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
  function encuentro(){
    document.getElementById("overlay3").style.visibility = "visible";

  };
  function cerrar3(){
    document.getElementById("overlay3").style.visibility = "hidden";
  };
</script>
<script>
 function isChecked(checkbox) {
    var button = document.getElementById('btnEliminar');
    checkbox.value=1;
    if (checkbox.checked === true) {
        button.disabled = "";
        checkbox.value=1;
    } else {
        button.disabled = "disabled";
        checkbox.value=0;
    }
}
function eliminar(){
  if(confirm("¿Estas seguro de eliminar estos datos?")){
    var table = document.getElementById("mensaje");
    var button = document.getElementById('btnEliminar');
    var evento=$('#tituloEvento').find("td").eq(3).html();
    for (var i = 0, row; row = table.rows[i]; i++) {
      var codigo=row.cells[0].innerText;
      var eliminar=row.cells[4].children[0].value;
      if(eliminar==1){
      $.ajax({
            type:'POST',
            url:'eliminacionMaterial.php',
            data:{codigo:codigo,evento:evento},
        });
      table.deleteRow(i);
      }
    }
    button.disabled = "disabled";
  }
};
</script>
  </head>
<body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <img class="navbar-brand" src="../img/logotipo_auna.png" alt="logotipo auna" width="75px">
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <?php include("../include/barraNavegacion.php")?>
          </ul>
        </div>
      </nav>
    </header>
    <section>
    <form method="post" id="formMaterial">
      <h4 class='tituloDespacho'>Registro de Movimientos</h4>
      <div class="form-group">
        <table class='table table-light' id='tituloEvento'>
          <thead>
            <th>Nombre del Paciente</th>
            <th>Médico Tratante</th>
            <th>Evento</th>
            <th>¿Devolución?</th>
          </thead>
          <?php
          $sql="SELECT id_accion,CONCAT(nombre_paciente,' ',apellido_paciente) nombre_completo ,nombre_responsable,a.nombre FROM sop__evento_acc_db 
          INNER JOIN sop__eventos_db a on sop__evento_acc_db.id_evento=a.id_evento
          WHERE dni_usuario=$idSesion and (id_estado=1 or id_estado=2) and id_accion=$evento;";
          $consulta=mysqli_query($conexion,$sql);
          $row=mysqli_fetch_array($consulta);
          $tipoEvento=$row['nombre'];
            echo "<tr>";
            echo "<td>" . $row['nombre_completo']. "</td>";
            echo "<td>" . $row['nombre_responsable']. "</td>";
            echo "<td>" . $tipoEvento. "<input type='hidden' id='tipoEvento' value='".$tipoEvento."'</td>";
            echo "<td style='display:none;'>".$row['id_accion']."</td>";
            echo "<td><button type='button' class='btn btn-success' id='btnDevolucion'>Activar</button></td>";
            echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
            echo "<div class='botonReporte'><button class='btn btn-success' id='reporte' onclick='encuentro();'><i class='fas fa-file-alt'></i></button></div>";
            echo "</tr>";
          ?>
        </table>
      </div>
    </form>
    <div class="form-group" id="busquedaCodigo">
    Subtipo de Producto<select id="subtipo">
      <?php
       if($tipoEvento=="Cirugia"){
        echo "<option value='Material de Anestesia'>Material de Anestesia</option>";
        echo "<option value='Medicación de Anestesia'>Medicación de Anestesia</option>";
        echo "<option value='Dispensación regular'>Dispensación regular</option>";
        echo "<option value='Adicionales'>Adicionales</option>";
      } elseif($tipoEvento=="Quimioterapia"){
        echo "<option value='Hidratación prequimioterapia'>Hidratación prequimioterapia</option>";
        echo "<option value='Dispensación regular'>Dispensación regular</option>";
        echo "<option value='Alta postquimioterapia'>Alta postquimioterapia</option>";
      }
      ?>
      </select>  <br>
        <label>Codigo del Producto</label>
        <input type="text" id='codigo' name="codigo" class="form-control" autofocus="autofocus" size="10"required autocomplete=off>
      </div>
    <div class="form-group">
      <div id="ingresos">
        <input type="submit" form='formMaterial' id="enviar" class="btn btn-success" value="Buscar" style="display:none">
        <button class="btn btn-info" onclick="ingresoManual()">Ingreso Manual</button>
        <button class="btn btn-info" onclick="busquedaManual()">Búsqueda Manual</button>
      </div>
        <div id='botonesEdicion'>
        <button type="submit" id='btnGuardado' form="registro_Despacho" class="btn btn-info">Guardar</button>
        <button class="btn btn-info" id="btnEliminar" onclick='eliminar()' disabled>Eliminar</button>
        </div>
    </div>
    
    <form action="registrarDespacho.php?codigo=<?php echo $evento ?>" method="POST" id="registro_Despacho">
      <table class="table" id="tabla_elementos">
        <thead>
          <th>Codigo</th>
          <th style='text-align:left;width:450px'>Descripcion</th>
          <th>Cantidad</th>
          <th>Tipo</th>
          <th> <input type='hidden' id='devolucion' value='' name='devolucion'> </th>
        </thead>
        <tbody id="mensaje">
          <?php
          $sqlMateriales="SELECT*FROM sop__despacho_db Where id_evento_acc=$evento order by nombre asc ;";
          $consultaMateriales=mysqli_query($conexion,$sqlMateriales);
          while($filaConsulta=mysqli_fetch_array($consultaMateriales)){
            if($filaConsulta['devolucion']==0){
              echo "<tr>";
              echo "<td>".$filaConsulta['id_material']."</td>";
              echo "<td style='text-align:left'>".$filaConsulta['nombre']."</td>";
              echo "<td><input type='number' id='cantidadSelect' value=".$filaConsulta['cantidad']."></td>";
              echo "<td>".$filaConsulta['tipo']."</td>";
              echo "<td><input type='checkbox' name='chk1' id='chkEliminar' value=0 onchange='isChecked(this)' ></td>";
              echo "<td><input type='hidden' id='update' value='1'></td>";
              echo "<td style='display:none'><input type='hidden' id='devolucionItem' value='0'></td>";
              echo "</tr>";
            }else{
              echo "<tr>";
              echo "<td>".$filaConsulta['id_material']."</td>";
              echo "<td style='text-align:left'>".$filaConsulta['nombre']."</td>";
              echo "<td><input type='number' id='cantidadSelect' value=".$filaConsulta['cantidad']."></td>";
              echo "<td>".$filaConsulta['tipo']."</td>";
              echo "<td><input type='checkbox' name='chk1' id='chkEliminar' value=0 onchange='isChecked(this)' ></td>";
              echo "<td><input type='hidden' id='update' value='1'></td>";
              echo "<td style='display:none'><input type='hidden' id='devolucionItem' value='0'></td>";
              echo "</tr>";
              echo "<tr style='background-color: rgba(241, 91, 91, 0.3);'>";
              echo "<td>".$filaConsulta['id_material']."</td>";
              echo "<td style='text-align:left'>".$filaConsulta['nombre']."</td>";
              echo "<td><input type='number' id='cantidadSelect' value=".$filaConsulta['devolucion']."></td>";
              echo "<td>".$filaConsulta['tipo']."</td>";
              echo "<td><input type='checkbox' name='chk1' id='chkEliminar' value=0 onchange='isChecked(this)' ></td>";
              echo "<td><input type='hidden' id='update' value='1'></td>";
              echo "<td style='display:none'><input type='hidden' id='devolucionItem' value='1'></td>";
              echo "</tr>";
            }
          }
          ?>
        </tbody>  
      </table>
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
          <table class='table table-dark' id="materialesDespacho">
            <thead>
              <th>Nombre</th>
              <th>Cantidad</th>
            </thead>
            <tbody id="resultadoBusqueda">
            </tbody>
          </table>
        </div>
      </div>
    </form>
    <div class="overlay" id="overlay3">
        <div class="popup">
          <div id="encabezado_encuentro">
            <h3>Ingrese Numero de Encuentro</h3>
            <a onclick="cerrar3()" id="cerrar_Popup"><i class="fas fa-times"></i></a>
          </div>
          <div><input type="text" name="encuentro" id="encuentro" required> <br></div>
          <div id="botonesEncuentro">
            <button class='btn btn-success' id='llenadoEncuentro1'>Reporte por Subtipo</button>
            <button class='btn btn-success' id='llenadoEncuentro2'>Reporte por Tipo Material</button>
        </div>
        </div>
      </div>
    </section>
</body>
</html>

