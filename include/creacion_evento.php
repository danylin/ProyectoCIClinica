<!-- El apartado de creacion_evento.php abarca dos divs importantes 
El overlay (el cual se repetira en varias ocasiones con el fin de utilizar un unico estilo css) sera activado
con un boton el cual habilitara el formulario de creacion de eventos-->
<div class="overlay" id='overlay1' >
    <div class="popup">
        <div id="encabezado_popup">
            <h3 id='tituloRegistro'>Datos del Evento</h3>
            <a onclick="cerrar()" id="cerrar_Popup"><i class="fas fa-times"></i></a>
        </div>
  <!-- El formulario formEvento habilitara al usuario tanto el registro como la edicion de datos del evento seleccionado -->
        <form action="include/registro_evento.php" method="post" id="formEvento">
            <div class="container-flex" >
                <div class="row" >
                <div class="col-sm-6"><p>Nombre del Paciente <br> <input type="text" name="nombre" id="nombre" autocomplete="off" required></p></div>
                <div class="col-sm-6"><p>Apellidos del Paciente <br> <input type="text" name="apellido" id="apellido" autocomplete="off" required></p></div>  
                <?php
                    include("include/bd_usuario.php"); 
                    $sql="SELECT*FROM sop__eventos_db;";
                    $sql2="SELECT*FROM sop__usuarios_db WHERE dni=".$_SESSION['id'];
                    $resultado=mysqli_query($conexion,$sql);
                    $resultado2=mysqli_query($conexion,$sql2);
                    $row2=mysqli_fetch_array($resultado2);
                    echo "<div class='col-sm-6'> <p> Evento <br> <select name='evento' id='evento' required>";
                    while($row=mysqli_fetch_array($resultado)){
                        /*Se verifica que eventos estan asociados al usuario en la variable "row2",
                        en el caso de la variable "row" se obtendran los nombres de los eventos en la tabla sop__eventos_db
                        */
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
                    <div class="col-sm-6"><p>Médico Tratante <br> <input type="text" name="responsable" id="responsable" required autocomplete='off'></p></div> 
                    <div class="col-sm-6"><p>Hora <br> <input type="time" name="hora" id="hora" autocomplete='off'></p></div> 
                    <div class="col-sm-12"><p>Descripcion del Evento <br> <textarea name="descripcion" id="descr-evento" cols="30" rows="3" required></textarea></p></div>      
                </div>
                <div id='botonesGuardado'>
                    <input type="hidden" name="verificadorEditar" id="verificadorEditar">
                    <input type="hidden" name="id_accion" id="id_accion">
                    <button type="submit" class='btn btn-success' form='formEvento' id='btnRegistrar'>Registrar</button>
                    <button type="submit" class='btn btn-success' form='formEvento' id='btnEditar'>Editar</button>
                </div>
            </div>
        </form>
    </div>
</div> 
<!-- El overlay2 cumple las misma caracteristicas del overlay anterior, en este caso se dara al usuario la eleccion de reportes
para los eventos marcados como finalizados (id_estado=3) -->
<div class="overlay" id="overlay2">
        <div class="popup">
          <div id="encabezado_encuentro">
            <h3 style="padding-left:32%">Reportes</h3>
            <a onclick="cerrar2()" id="cerrar_Popup"><i class="fas fa-times"></i></a>
          </div>
              <table class="table table-light">
                  <thead>
                      <th style="background-color:rgba(119, 122, 120,0.5);">Tipo de Reporte</th>
                  </thead>
                  <tbody>
                      <tr class="fila" onclick="reportes(0)"><td>De Movimiento General</td></tr>
                      <tr class="fila" onclick="reportes(1)"><td>De Movimiento por SubEvento</td></tr>
                  </tbody>
              </table>
        </div>
  </div>
<div class="overlay" id="overlay3">
  <div class="popup">
    <div id="encabezado_encuentro">
      <h3 style="padding-left:5%">Extraccion de Información</h3>
      <a onclick="cerrar3()" id="cerrar_Popup"><i class="fas fa-times"></i></a>
    </div>
    <div id="informacion">
      <form id="extraerInformacion" action="include/extraerInformacion.php" method="post">
        <div class="mb-3">
        Tipo de Evento: <select name="tipoEvento" id="tipoEventoExtraccion">
          <option value="0">Todos los Eventos</option>
          <option value="2">Cirugia</option>
          <option value="1">Quimioterapia</option>
          <option value="3">Procedimiento Medico</option>
          <option value="4">Control Logistico</option>
        </select>
        </div>
        <div class="mb-3">
          Desde: <input type="date" name="fechaDesde" id="fechaDesdeEx">
        </div>
        <div class="mb-3">Hasta: <input type="date" name="fechaHasta" id="fechaHastaEx"></div>
        <div class="mb-3">
        <input type="checkbox" id="chkSede">
          <?php
          include("bd_usuario.php");
          $sql="SELECT*FROM sede__db_area WHERE id in (1,2,3,4,5,6,7,17,18,21,24);";
          $resultado=mysqli_query($conexion,$sql);
          echo "Sede: <select name='sede' id='sedeEx' disabled>";
          echo "<option value=0> Todas las Sedes </option>";
          while($row=mysqli_fetch_array($resultado)){
          echo "<option value=".$row['id']." >". $row['sede'] ."</option>";
          }
          echo "</select>";
          ?>
        </div>
        <div class="mb-3">
          <input type="checkbox" id="chkUsuario">
          Usuario: <input type="input" name="usuarioEx" id="usuarioEx" disabled>
        </div>
        <div class="mb-3">
          <input type="checkbox" id="chkMaterialEx">
          CodigoMaterial: <input type="input" name="materialEx" id="materialEx" disabled>
        </div>
        <button class="btn btn-danger" form='extraerInformacion' type="submit">Extraer</button>
      </form>
    </div>
  </div>
</div>
<div class="usuarios">
<!-- El presente div mostrara cada evento subdividido por su status:
Programados, en proceso, finalizados y suspendidos. -->
    <div class="container-table">
        <div class="table-title">
            <div id="usuarioEncabezado">
            <p><b>Usuario: <?php echo $_SESSION['nombre'] . " " . $_SESSION['apellido']?></b></p>
            <h3 id="registroEventosTitulo">Registro de Eventos</h3>
            </div>
            <div id='cajaOpciones' >
              <div id="evento">
                <button class='btn btn-info' id='nuevoEvento'onclick='mostrar(0)'>Nuevo Evento</button>
              </div>
                <div class='filtros'>
                        Status de Evento: <select name="filtroEleccion" id="filtroEleccion">
                        <option selected disabled>Status de Evento</option>
                              <option value="1" >Programado</option>
                              <option value="2" selected>En Proceso</option>
                              <option value="3">Finalizado</option>
                              <option value="4">Suspendido</option>
                          </select>
                      Desde: <input type="date" name="" id="fechaDesde" >
                      Hasta:<input type="date" name="" id="fechaHasta">
                      <button class="btn btn-info" onclick="mostrarExtraccion()">Extraer Informacion</button>
                </div>
            </div>
        </div>
        <table class="table table-light" id='tabla_eventos'>
            <thead>
                <th scope="col" onclick="sortTable(0)">N° Fila</th>
                <th scope="col" onclick="sortTable(1)">Id Evento</th>
                <th scope="col" onclick="sortTable(2)">Fecha de Programacion</th>
                <th scope="col" onclick="sortTable(3)">Hora</th>
                <th scope="col" onclick="sortTable(4)">Nombre del Paciente</th>
                <th scope="col" onclick="sortTable(5)">Apellidos del Paciente</th>
                <th scope="col" onclick="sortTable(6)">Estado</th>
                <th style="display:none" scope="col"></th>
                <th scope="col" onclick="sortTable(8)">Médico Tratante</th>
                <th scope="col" onclick="sortTable(9)">Descripción</th>
                
            </thead>
            <tbody id='tabla_contenido'>
                <?php
                /*
                El tbody se definirá con la conjuncion de multiples bases de datos con el fin de llenar los apartados de:
                Nro de fila, id del Evento, la fecha de programacion, la hora de programacion, el nombre y apellidos del paciente,
                el estado actual del evento y finalmente el medico tratante y una breve descripcion del evento
                */
                $id=$_SESSION['id_sede'];
                $sql="SELECT a.id_accion,TIME_FORMAT(a.hora,'%H:%i') hora,a.codigo_cierre,a.id_estado,a.nombre_responsable,a.id_evento,a.descripcion_evento, a.fecha,a.nombre_paciente,a.apellido_paciente,a.fecha_programacion,b.estado,sop__usuarios_db.usuario
                FROM sop__evento_acc_db a
                INNER JOIN sop__estados_db b on b.id_estado=a.id_estado
                INNER JOIN sop__usuarios_db on a.dni_usuario =sop__usuarios_db.dni 
                INNER JOIN sede__db_area on sede__db_area.id=sop__usuarios_db.id_sede 
                WHERE sede__db_area.id=$id and a.id_estado=2
                ORDER BY a.fecha_programacion,hora,a.apellido_paciente asc;";
                $resultado=mysqli_query($conexion,$sql);
                while($row=mysqli_fetch_array($resultado)){
                ?>
                <tr class='fila' onclick='redireccion(<?php echo $row["id_estado"]; ?>,<?php echo $row["id_accion"];?>),""'>
                <?php
                    echo "<td class='numeroFila'></td>";
                    echo "<td>". $row['id_accion']."</td>";
                    echo "<td>". $row['fecha_programacion']."</td>";
                    echo "<td>". $row['hora']."</td>";
                    echo "<td>". $row['nombre_paciente']."</td>";
                    echo "<td>". $row['apellido_paciente']."</td>";
                    echo "<td>". $row['estado']."</td>";
                    echo "<td style='display:none'>". $row['id_evento']."</td>";
                    echo "<td>". $row['nombre_responsable']."</td>";
                    echo "<td>". $row['descripcion_evento']."</td>";
                    echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
                    echo "<div class='editarEvento'><button class='btn btn-info' id='editarEvento' onclick='editar(this)'><i class='fas fa-edit'></i></button></div>";
                    echo "</td>";
                    echo "<td style='display:none;'>". $row['id_evento']."</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<script>
 //Las siguienes funciones permiten la visualizacion del apartado de eleccion de reportes asi como mostrar un pdf correspondiente a la eleccion del usuario
var codigoEvento;
var subTipo;
  function reporte(a){
    document.getElementById("overlay2").style.visibility = "visible";
    codigoEvento=$(a).closest('tr').find("td").eq(1).html();
    subTipo=$(a).closest('tr').find("td").eq(9).html();
  };
  function reportes(n){
      if (n==0){
        window.open("reporte/pdf.php?codigo="+codigoEvento);
      }else{
        window.open("reporte/pdf_subTipo.php?codigo="+codigoEvento+"&tipoEvento="+subTipo);
      }
  }
   // Las siguientes funciones modifican la visibilidad de los formularios de Extraccion y de Registro de Eventos
  function mostrarExtraccion(){
    document.getElementById("overlay3").style.visibility = "visible";
  }
    function cerrar3(){
    document.getElementById("overlay3").style.visibility = "hidden";
  };
  function cerrar2(){
    document.getElementById("overlay2").style.visibility = "hidden";
  };
function redireccion(a,b,c){
    window.location="despacho/comprobar.php?estado="+a+"&codigo="+b+"&tipo="+c;
}
// La presente funcion a la vez que cierra el formulario de registro de eventos elimina los valores contenidos en ellos.
function cerrar(){
    document.getElementById("overlay1").style.visibility = "hidden";
        $('#nombre').val('');
        $('#apellido').val('');
        $('#form-fecha').val('');
        $('#responsable').val('');
        $('#evento').val(1).change();
        $('#descr-evento ').val('');
  };
function reabrir(idEvento){
if(confirm("¿Desea reabrir este evento?")){
  $.ajax({
            type:'POST',
            url:'include/reabrir.php',
            data:{idEvento:idEvento},
            success: function(data){
              document.location.reload(true);
            }
        });
  }
}
/* La presente funcion tiene como objetivo relacionar los botones numericos
con los eventos mostrados en pantalla. ADVERTENCIA. SOLO ESTA DISPONIBLE LOS NUMEROS DESDE EL 1 HASTA EL 9*/
  $(document).keydown(function(e) {
    var btnApretado
    var btnApretado=0
    switch(e.key){
      case '1':
        btnApretado=1;
        break;
      case '2':
        btnApretado=2;
        break;
      case '3':
        btnApretado=3;
        break;
      case '4':
        btnApretado=4;
        break;
      case '5':
        btnApretado=5;
        break;
      case '6':
        btnApretado=6;
        break;
      case '7':
        btnApretado=7;
        break;
      case '8':
        btnApretado=8;
        break;
      case '9':
        btnApretado=9;
        break;
      }
      $("#tabla_eventos tbody tr").each(function(){
        $(this).find("td").css("background-color", "inherit");
          if(btnApretado!=0){
            if(btnApretado==$(this).find(".numeroFila").html()){
              $(this).find("td").css("background-color", "skyblue");
              $(this).trigger("click");
            }
          }
        });
      });
/* La funcion mostrar ocultará y mostrará los botones correspondiente a editar y registrar.
Esto se verifica con la variable "valorEditar" que sera enviada mediante un click en los botones
referenciados en las variables btnRegistrar y btnEditar*/
  function mostrar(n){
      var btnRegistrar=document.getElementById("btnRegistrar");
      var btnEditar=document.getElementById("btnEditar");
      var valorEditar=document.getElementById("verificadorEditar");
      if(n==1){
        btnRegistrar.style.display='none';
        btnEditar.style.display='block'
        valorEditar.value=1;
    }else{
        btnRegistrar.style.display='block';
        btnEditar.style.display='none'
        valorEditar.value=0;
    }
    document.getElementById("overlay1").style.visibility = "visible";
  };

/* En el evento de cambio en las fechas de filtrado se utilizara la siguiente funcion
que compara los valores de la fecha programada en conjunto con los filtros antes mencionados */ 
  $('#filtroEleccion').on('change',function(){
    $("#tabla_contenido tr").remove(); 
        var estado=$('#filtroEleccion').val();
          $.ajax({
            type:'POST',
            url:'include/filtroEventos.php',
            data:{estado:estado},
            success: function(data){
              var contador=1
                $('#tabla_contenido').prepend(data);
                $("#tabla_eventos tbody tr").each(function() {
                var from=$('#fechaDesde').val(); // Variable Date Desde
                var to=$('#fechaHasta').val(); // Variable Date Hasta
                var row = $(this);
                var date = row.find("td").eq(2).html();
                var show = true;
                if (from && date < from)
                show = false;
                if (to && date > to)
                show = false; /*Se realiza una validacion en caso que no cumpla con las condiciones estipuladas es decir,
                que las variables from y to contengan algun valor y que la variable date obtenida de la columna 3 de los eventos
                sea mayor o menor segun la comparacion*/
                if (show){
                row.show();
                $(this).find(".numeroFila").html(contador);
                contador++;
                }
                else{
                  row.hide(); /*Finalmente se verifica el valor booleano de la variable show para mostrar o ocultar la fila correspondiente
                  ademas se agrega el valor de un contador para enumerar la fila, esto con el fin de al presionar el numero correspodiente se acceda
                  de manera rapida a dicho evento*/
                }
              }); 
            }
        });
      });
    /*La funcion editar se activara llenando los campos con los datos 
    del evento seleecionado.*/
    function editar(id){
        var row=$(id).closest('tr');
        var nombre=$(row).find("td").eq(4).html(),
        apellido=$(row).find("td").eq(5).html(),
        evento=$(row).find("td").eq(7).html(),
        fecha=$(row).find("td").eq(2).html(),
        id=$(row).find("td").eq(1).html(),
        responsable=$(row).find("td").eq(8).html();
        descripcion=$(row).find("td").eq(9).html();
        hora=$(row).find("td").eq(3).html();
        mostrar(1); //Esta funcion se encuentra en la linea de codigo 273
        $('#id_accion').val(id);
        $('#nombre').val(nombre);
        $('#apellido').val(apellido);
        $('#form-fecha').val(fecha);
        $('#responsable').val(responsable);
        $('#evento').val(evento).change();
        $('#descr-evento ').val(descripcion);
        $('#hora').val(hora);
    };
    function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("tabla_eventos");
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
      $('#chkMaterialEx').change(function() {
        if(this.checked) {
          $('#materialEx').prop('disabled',false);
        }else{
          $('#materialEx').prop('disabled',true);
        }    
      });
      $('#chkSede').change(function() {
        if(this.checked) {
          $('#sedeEx').prop('disabled',false);
        }else{
          $('#sedeEx').prop('disabled',true);
        }    
      });
      $('#chkUsuario').change(function() {
        if(this.checked) {
          $('#usuarioEx').prop('disabled',false);
        }else{
          $('#usuarioEx').prop('disabled',true);
        }    
      });
    // Al iniciar la ventana se cargara la fecha actual asi como la fecha dos dias despues. 
    var contador=1
    var fechaDesde = new Date(); //Fecha actual
    var fechaHasta= fechaDesde;
    var mes = fechaDesde.getMonth()+1; //obteniendo mes del valor Desde
    var dia = fechaDesde.getDate(); //obteniendo dia del valor Desde
    var year = fechaDesde.getFullYear(); //obteniendo año del valor Desde
    fechaHasta.setDate(fechaHasta.getDate()+2);
    var mesH = fechaHasta.getMonth()+1; //obteniendo mes del valor Hasta
    var diaH = fechaHasta.getDate(); //obteniendo dia del valor Hasta
    var yearH = fechaHasta.getFullYear(); //obteniendo año del valor Hasta
    if(dia<10)
        dia='0'+dia; 
    if(mes<10)
        mes='0'+mes;
    if(diaH<10)
        diaH='0'+diaH; 
    if(mesH<10)
        mesH='0'+mesH  
    document.getElementById('form-fecha').min=year+"-"+mes+"-"+dia;// Dentro del formulario de registro y edicion se restringe la fecha minima a la actual
    document.getElementById('fechaDesde').value=year+"-"+mes+"-"+dia;
    document.getElementById('fechaHasta').value=yearH+"-"+mesH+"-"+diaH;
    document.getElementById('fechaDesdeEx').value=year+"-"+mes+"-"+dia;
    document.getElementById('fechaHastaEx').value=yearH+"-"+mesH+"-"+diaH;
    $("#tabla_contenido tr").each(function() {
    var from=$('#fechaDesde').val();
    var to=$('#fechaHasta').val();
    var row = $(this);
    var date = row.find("td").eq(2).html();
    var show = true;
    if (from && date < from)
      show = false;
    if (to && date > to)
      show = false;
    if (show){
      row.show();
      $(this).find(".numeroFila").html(contador);
      contador++;
      console.log(contador)
    }
    else{
      row.hide();
    }     
      }); 
    }
</script>
<script>
    $('#fechaDesde').on('change',function(){
    var contador=1
    $("#tabla_contenido tr").each(function() {
    var from=$('#fechaDesde').val();
    var to=$('#fechaHasta').val();
    var row = $(this);
    var date = row.find("td").eq(2).html();
    var show = true;
    if (from && date < from)
      show = false;
    
    if (to && date > to)
      show = false;

      if (show){
      row.show();
      $(this).find(".numeroFila").html(contador);
      contador++;
    }
    else{
      row.hide();
    }     
  });
    })
    $('#fechaHasta').on('change',function(){
      var contador=1
    $("#tabla_contenido tr").each(function() {
    var from=$('#fechaDesde').val();
    var to=$('#fechaHasta').val();
    var row = $(this);
    var date = row.find("td").eq(2).html();
    var show = true;
    if (from && date < from)
      show = false;
    
    if (to && date > to)
      show = false;
      if (show){
      row.show();
      $(this).find(".numeroFila").html(contador);
      contador++;
    }
    else{
      row.hide();
    }     
  });
    })
</script>