<!DOCTYPE html>
<html>
<head>
  <?php
  session_start();
  include("../include/bd_usuario.php");
  $idSesion=$_SESSION['id'];
  $evento=$_GET['codigo'];
  $sql="SELECT*FROM sede__db_area WHERE id=".$_SESSION['id_sede'];
  $consulta=mysqli_query($conexion,$sql);
  $row=mysqli_fetch_array($consulta);
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
      var codigoGTIN;
      function GTIN(fila){
      document.getElementById("overlay4").style.visibility = "visible";
      var table = document.getElementById("mensaje"); 
      var row=$(fila).closest('tr');
      codigoGTIN=$(row).find("td").eq(0).html();
      $.ajax({
              type:'POST',
              url:'consultagtin.php',
              data:{codigo:codigoGTIN},
              success: function(data){
                data=JSON.parse(data);
                $('.popup #codigogtin').val(data['gtin']);
                $('.popup #codigocrf').val(data['crf']);
                $('#codigoNombreEncabezado').text(data['CodNombre'])
              }
          });  
      }
    $(document).ready(function() {
      $('#llenadoGTIN').on("click",function(e){
      e.preventDefault();
      var codigoG=$('#codigogtin').val();
      var crf=$('#codigocrf').val();
      console.log(codigoG);
      console.log(crf);
      console.log(codigoGTIN);
      if(confirm("¿Está seguro de modificar estos campos?")){
        $.ajax({
        type:'POST',
        url:'modificargtin.php',
        data:{codigoG:codigoG,crf:crf,codigoGTIN:codigoGTIN},
        success: function(data){
          alert('Guardado con Exito');
          document.getElementById("overlay4").style.visibility = "hidden";
          document.getElementById("codigo").focus();
        }
       });
      };
      });
    var valorAnterior;
    var cantidad;
    $('#gtin').on('click',function(event){
      event.preventDefault();
    });
    // El presente apartado se realiza el guardado de los elementos en el sistema
    $('#btnGuardado').on('click',function(event){
          event.preventDefault();
        var table = document.getElementById("mensaje");
        var evento=document.getElementById("tipoEvento").value;
        var codigo=[];
        var descripcion=[];
        var cantidad=[];
        var tipo=[];
        var update=[];
        var devObjeto=[];
        for (var i = 0, row; row = table.rows[i]; i++) {
            codigo.push(row.cells[0].innerText);
            descripcion.push(row.cells[1].innerText);
            cantidad.push(row.cells[2].children[0].value);
            console.log(cantidad)
            tipo.push(row.cells[3].innerText);
            update.push(row.cells[5].children[0].value);
            devObjeto.push(row.cells[6].children[0].value);
           if(row.cells[5].children[0].value==0){
            row.cells[5].children[0].value=2
           }
        }
        $.ajax({
            type:'POST',
            url:'registrarDespacho.php?evento=<?php echo $evento ?>',
            data:{codigo:codigo,descripcion:descripcion,cantidad:cantidad,tipo:tipo,devObjeto:devObjeto,update:update,evento:evento},
            success: function(data){
              $('#mensaje').prepend(data);
              alert('Guardado con Exito');  
              document.getElementById("codigo").focus();
              location.reload();
            }
           });
        });
    $("#codigo").keyup(function(event) {
      event.preventDefault();
      if (event.keyCode === 13) {
          $("#enviar").trigger("click");
          $('#codigo').val("");
      }
  });
  $(document).keydown(function(e) {
    if(e.which == 71 && e.altKey) {
      $("#btnGuardado").trigger("click");
    }
});
    $('#formMaterial').submit(function(event) {
      event.preventDefault();
      var codigo=$('#codigo').val();
      var devolucion=$('#devolucion').val();
      var evento=document.getElementById("tipoEvento").value;
      var table = document.getElementById("mensaje");
      var cuentaDevolucion=0;
      var codigoC;
      if(codigo.length>8){
        if(codigo.includes("$")){
          codigoC=codigo.substring(0,8);
        }else{
          $.ajax({
          type:'POST',
          async: false,
          url:'consultaCodigoBarras.php',
          data:{codigo:codigo},
          success: function(data){
            codigoC=data;
            }
          });
        }
      }else{
        codigoC=codigo
      }
      if (table.rows.length==0 && devolucion==1){
          cuentaDevolucion=1;
      }else{
          if(devolucion==1){
            for (var i = 0, row; row = table.rows[i]; i++){
              if ((row.cells[0].innerText).includes(codigoC)){
                cuentaDevolucion=0;
                break
             }else{
              cuentaDevolucion=1;
             }
            }
          }
        }
      if (cuentaDevolucion==1){
        alert("El articulo a devolver no esta en el listado. Verifique e intente de nuevo.")
      }else{
        $.ajax({
        type:'POST',
        url:'creacionDespacho.php?codEvento=<?php echo $evento ?>',
        data:{codigo:codigo,devolucion:devolucion,evento:evento},
        success: function(data){
            $('#mensaje').prepend(data);
            $('#formMaterial')[0].reset();
            document.getElementById("codigo").focus();
          }
        });
      }
    });
    $('#formManual').submit(function(event) {
      event.preventDefault();
      var nombre=$('#nombreManual').val();
      var cantidad=$('#cantidadManual').val();
      var devolucion=$('#devolucion').val();
      var codgtin=$('#gtin').val();
      var crf=$('#crf').val();
      var evento=document.getElementById("tipoEvento").value;
      $.ajax({
        type:'POST',
        url:'creacionDespacho.php',
        data:{nombre:nombre,cantidad:cantidad,devolucion:devolucion,evento:evento,codgtin:codgtin,crf:crf},
        success: function(data){
            $('#mensaje').prepend(data);
            $('#formManual')[0].reset();
            document.getElementById("codigo").focus();
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
      document.getElementById("codigo").focus();
  });
  $('#busquedaInput').on('keyup',function(){
    var filas;
    var nombre=$('#busquedaInput').val();
    var devolucion=$('#devolucion').val();
    var tipoEvento=$('#tipoEvento').val();
    $("#resultadoBusqueda tr").remove(); 
      $.ajax({
        type:'POST',
        url:'busquedaManual.php',
        data:{nombre:nombre,devolucion:devolucion,tipoEvento:tipoEvento},
        success: function(data){
            $('#resultadoBusqueda').prepend(data);
        }
    });
  });
  $('#llenadoEncuentro1').on('click',function(){
    $("#btnGuardado").trigger("click");
    if(confirm("Está a punto de cerrar el evento. Despues de ello no podrá modificarlo.¿Está seguro de cerrar el evento?")){
      var row=$('#except .botonReporte button').closest('tr');
      var id=$(row).find("td").eq(3).html();
      var encuentro=$('#encuentro').val();
      window.location="tipoReporte.php?codigo="+<?php echo $evento?>+"&encuentro="+encuentro;
    }
  });
});
</script>
<script>
  var cuenta=0;
 function isChecked(checkbox) {
    var button = document.getElementById('btnEliminar');
    checkbox.value=1;
    if (checkbox.checked === true) {
        button.disabled = "";
        checkbox.value=1;
        cuenta=cuenta+1;
    }else {
        if(cuenta<2){
          button.disabled = "disabled";
          checkbox.value=0;
          cuenta=0;
        }else{
          checkbox.value=0;
          cuenta=cuenta-1;
          console.log(cuenta);
        }
    }
}
function eliminar(){
  if(confirm("¿Estas seguro de eliminar estos datos?")){
    var table = document.getElementById("mensaje");
    var button = document.getElementById('btnEliminar');
    var evento=$('#tituloEvento').find("td").eq(3).html();
    for (var i = table.rows.length-1; i>-1 ; i--) {
      var codigo=table.rows[i].cells[0].innerText;
      var eliminar=table.rows[i].cells[4].children[0].value;
      var devolucion=table.rows[i].cells[6].children[0].value;
      var cantidad=table.rows[i].cells[2].children[0].value;
      if(eliminar==1){
        $.ajax({
            type:'POST',
            url:'eliminacionMaterial.php',
            data:{codigo:codigo,evento:evento,devolucion:devolucion,cantidad:cantidad},
        });
        if(devolucion==0){
          table.deleteRow(i);
        }else{
          table.deleteRow(i);
        }
      }
    }
    button.disabled = "disabled";
    document.getElementById("codigo").focus();
  }
};
</script>
  </head>
<body>
    <header>
    <nav class="navbar navbar-expand-lg" style="height:80px;">
          <img class="navbar-brand" src="../img/logotipo_auna.png" alt="logotipo auna" width="85px"><b><?php echo $row['sede'] ?></b> 
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
            <th>Cerrar Evento</th>
          </thead>
          <?php
          $sql="SELECT id_accion,CONCAT(nombre_paciente,' ',apellido_paciente) nombre_completo ,nombre_responsable,a.nombre FROM sop__evento_acc_db 
          INNER JOIN sop__eventos_db a on sop__evento_acc_db.id_evento=a.id_evento
          WHERE (id_estado=1 or id_estado=2) and id_accion=$evento;";
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
            echo "<div class='botonReporte'><button class='btn btn-success' id='reporte' onclick='encuentro();'>Cerrar </button></div>";
            echo "</tr>";
          ?>
        </table>
      </div>
    </form>
    <div class="form-group" id="busquedaCodigo">
      <label>Codigo del Producto</label>
      <input type="text" id='codigo' name="codigo" class="form-control" autofocus="autofocus" size="10"required autocomplete=off>
       <div id="divBusqueda"><button class="btn btn-info" onclick="busquedaManual()" id="botonBusquedaManual">Búsqueda Manual</button> </div>
       <div id='botonesEdicion'>
        <button class="btn btn-info" id="btnEliminar" onclick='eliminar()' disabled>Eliminar</button>
        <button type="submit" id='btnGuardado' form="registro_Despacho" class="btn btn-info">Guardar</button>
        </div>
      </div>
    <div class="form-group">
      <div id="ingresos">
        <input type="submit" form='formMaterial' id="enviar" class="btn btn-success" value="Buscar" style="display:none">
      </div>
    </div>
    <form action="registrarDespacho.php?codigo=<?php echo $evento ?>" method="POST" id="registro_Despacho">
      <table class="table" id="tabla_elementos">
        <thead>
          <th>Codigo</th>
          <th style='text-align:left;width:450px'>Descripcion</th>
          <th>Cantidad</th>
          <th>Tipo</th>
          <th>¿Eliminar?<input type='hidden' id='devolucion' value='' name='devolucion'></th>
          <th></th>
          <th>GTIN/CRF</th>
        </thead>
        <tbody id="mensaje">
          <?php
          $sqlMateriales="SELECT*FROM sop__despacho_db Where id_evento_acc=$evento  order by nombre asc ;";
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
              echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
              echo "<div class='mostrarGTIN'><button id='mostrarGTIN' onclick='GTIN(this)'>GTIN</button></div>";
              echo "</td>";
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
              echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
              echo "<div class='mostrarGTIN'><button id='mostrarGTIN' onclick='GTIN(this)'>GTIN</button></div>";
              echo "</td>";
              echo "</tr>";
              echo "<tr style='background-color: rgba(241, 91, 91, 0.3);'>";
              echo "<td>".$filaConsulta['id_material']."</td>";
              echo "<td style='text-align:left'>".$filaConsulta['nombre']."</td>";
              echo "<td><input type='number' id='cantidadSelect' value=".$filaConsulta['devolucion']."></td>";
              echo "<td>".$filaConsulta['tipo']."</td>";
              echo "<td><input type='checkbox' name='chk1' id='chkEliminar' value=0 onchange='isChecked(this)' ></td>";
              echo "<td><input type='hidden' id='update' value='1'></td>";
              echo "<td style='display:none'><input type='hidden' id='devolucionItem' value='1'></td>";
              echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
              echo "<div class='mostrarGTIN'><button id='mostrarGTIN' onclick='GTIN(this)'>GTIN</button></div>";
              echo "</td>";
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
          <p>Nombre del Producto:<br><input type="text" id="nombreManual" name="nombreManual"></p>
          <p>Cantidad<br><input type="number" id="cantidadManual" name="cantidadManual"></p>
          <div>GTIN <br><input type="text" id="gtin" placeholder='GTIN' autocomplete="off"><br></div>
          <div>CRF <br><input type="text" id="crf" placeholder='CRF' autocomplete="off"> <br></div>
          <button class="btn btn-success" form='formManual' onclick="cerrar1()">Registrar</button>
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
          <div>Nombre del Producto: <input type="search" name="busqueda" id="busquedaInput" autocomplete="off"></div> 
          <table class="table" id="materialesDespacho">
            <thead style="background-color:rgba(119, 122, 120,0.5);">
              <th>Codigo</th>
              <th>Descripción del Material</th>
            </thead>
            <tbody id="resultadoBusqueda" style="background-color:white;">
            </tbody>
          </table>
          <button class="btn btn-success" id='btnIngresoManual' onclick="ingresoManual(event)">Ingreso Manual</button>
        </div>
      </div>
    </form>
    <div class="overlay" id="overlay3">
        <div class="popup">
          <div id="encabezado_encuentro">
            <h3>Ingrese Numero de Encuentro</h3>
            <a onclick="cerrar3()" id="cerrar_Popup"><i class="fas fa-times"></i></a>
          </div>
          <div><input type="text" name="encuentro" id="encuentro" placeholder='Numero de Encuentro' autocomplete="off" required> <br></div>
          <div id="botonesEncuentro">
            <button class='btn btn-danger' id='llenadoEncuentro1'>Cerrar Evento</button>
        </div>
        </div>
      </div>
      <div class="overlay" id="overlay4">
        <div class="popup">
          <div id="encabezado_encuentro" style="padding:auto">
            <div style="text-align:center">
            <h4 id="codigoNombreEncabezado">
            </h4>
            </div>
            <a onclick="cerrar4()" id="cerrar_Popup"><i class="fas fa-times"></i></a>
          </div>
          <div><input type="text" id="codigogtin" placeholder='GTIN' autocomplete="off"><br></div>
          <div><input type="text" id="codigocrf" placeholder='CRF' autocomplete="off"> <br></div>
          <div id="botonesEncuentro">
            <button class='btn btn-danger' id='llenadoGTIN'>Guardar</button>
        </div>
        </div>
      </div>
    </section>
    <script>
      window.addEventListener("keydown",function(event){
      if(event.key=="F7"){
        $("#btnGuardado").trigger("click");
        if(<?php echo $_SESSION['tipousuario']?>==1){
          window.location="../usuario1.php";
        }else{
          window.location="../usuario2.php";
        }
      }
    });
 
  function ingresoManual(event){
    event.preventDefault();
    cerrar2();
    document.getElementById("overlay1").style.visibility = "visible";
  };
  function cerrar1(){
    document.getElementById("overlay1").style.visibility = "hidden";
    document.getElementById("codigo").focus();
  }
  function busquedaManual(){
    document.getElementById('btnIngresoManual').style.visibility="visible";
    document.getElementById("overlay2").style.visibility = "visible";
    document.getElementById("busquedaInput").focus();
  };
  function cerrar2(){
    document.getElementById('btnIngresoManual').style.visibility="hidden";
    document.getElementById("overlay2").style.visibility = "hidden";
                document.getElementById('busquedaInput').value='';
            $("#resultadoBusqueda tr").remove(); 
            document.getElementById("codigo").focus();
  };
  function encuentro(){
    document.getElementById("overlay3").style.visibility = "visible";

  };
  function cerrar3(){
    document.getElementById("overlay3").style.visibility = "hidden";
    document.getElementById("codigo").focus();
  };
  function cerrar4(){
    document.getElementById("overlay4").style.visibility = "hidden";
    document.getElementById("codigo").focus();
  };
</script>
</body>
</html>

