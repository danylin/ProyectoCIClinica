<div class="overlay" id='overlay1'>
    <div class="popup">
        <div id="encabezado_popup">
            <h3>Registrar Evento</h3>
            <a onclick="cerrar()" id="cerrar_Popup"><i class="fas fa-times"></i></a>
        </div>
        <form action="include/registro_evento.php" method="post" id="formEvento">
            <div class="container-flex">
                <div class="row">
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
                    <div class="col-sm-12"><p>Responsable <br> <input type="text" name="responsable" id="responsable" required autocomplete='off'></p></div> 
                    <div class="col-sm-12"><p>Descripcion del Evento <br> <textarea name="descripcion" id="descr-evento" cols="30" rows="3" required></textarea></p></div>      
                </div>
                <div>
                    <input type="hidden" name="verificadorEditar" id="verificadorEditar">
                    <input type="hidden" name="id_accion" id="id_accion">
                    <button type="submit" form='formEvento' id='btnRegistrar'>Registrar</button>
                    <button type="submit" form='formEvento' id='btnEditar'>Editar</button>
                </div>
            </div>
        </form>
    </div>
</div> 
<div class="usuarios">
    <div class="container-table">
        <div class="table-title">
            <h3>Eventos</h3>
            <div id='cajaOpciones'>
                <button class='btn btn-info' id='nuevoEvento'onclick='mostrar(0)'>Nuevo Evento</button>
                <div class='filtros'>
                    <div id='input_buscar'>
                       Filtros: <select name="filtroEleccion" id="filtroEleccion">
                       <option selected disabled>Tipo Evento</option>
                            <option value="1" >Programado</option>
                            <option value="2">En Proceso</option>
                            <option value="3">Cerrado</option>
                            <option value="4">Suspendido</option>
                        </select>
                        <input type="search" name="filtroBusqueda" id="filtroBusqueda" onkeyup="filtrado()"placeholder="Buscar por Apellido">
                        <p id='desde'>Desde: <input type="date" name="" id="fechaDesde" >
                        Hasta:<input type="date" name="" id="fechaHasta">
                    </p>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-light" id='tabla_eventos'>
            <thead>
                <th scope="col" onclick="sortTable(1)">Fecha de Programacion</th>
                <th scope="col" onclick="sortTable(2)">Nombre del Paciente</th>
                <th scope="col" onclick="sortTable(3)">Apellidos del Paciente</th>
                <th scope="col" onclick="sortTable(4)">Estado</th>
                <th scope="col" onclick="sortTable(5)">Responsable</th>
                <th scope="col" onclick="sortTable(6)">Descripción</th>
            </thead>
            <tbody id='tabla_contenido'>
                <?php
                $id=$_SESSION['id_sede'];
                include("bd_usuario.php");
                $sql="SELECT a.id_accion,a.codigo_cierre,a.id_estado,a.nombre_responsable,a.id_evento,a.descripcion_evento, a.fecha,a.nombre_paciente,a.apellido_paciente,a.fecha_programacion,b.estado,sop__usuarios_db.usuario
                FROM sop__evento_acc_db a
                INNER JOIN sop__estados_db b on b.id_estado=a.id_estado
                INNER JOIN sop__usuarios_db on a.dni_usuario =sop__usuarios_db.dni 
                INNER JOIN sede__db_area on sede__db_area.id=sop__usuarios_db.id_sede 
                WHERE sede__db_area.id=$id and (a.id_estado=1 or a.id_estado=2)
                ORDER BY a.fecha_programacion desc;";
                $resultado=mysqli_query($conexion,$sql);
                while($row=mysqli_fetch_array($resultado)){
                ?>
                <tr class='fila' onclick='redireccion(<?php echo $row["id_estado"]; ?>,<?php echo $row["id_accion"]; ?>)'>
                <?php
                    echo "<td style='display:none;'>". $row['id_accion']."</td>";
                    echo "<td>". $row['fecha_programacion']."</td>";
                    echo "<td>". $row['nombre_paciente']."</td>";
                    echo "<td>". $row['apellido_paciente']."</td>";
                    echo "<td>". $row['estado']."</td>";
                    echo "<td>". $row['nombre_responsable']."</td>";
                    echo "<td>". $row['descripcion_evento']."</td>";
                    echo "<td onclick='event.cancelBubble=true; return false;' id='except'>";
                    echo "<div class='editarEvento'><button class='btn btn-info' id='editarEvento'><i class='fas fa-edit'></i></button></div>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<script> 
function redireccion(a,b){
    window.location="despacho/comprobar.php?estado="+a+"&codigo="+b;
}
function cerrar(){
    document.getElementById("overlay1").style.visibility = "hidden";
        $('#nombre').val('');
        $('#apellido').val('');
        $('#form-fecha').val('');
        $('#responsable').val('');
        $('#evento option:selected').val('');
        $('#descr-evento ').val('');
  };
  function mostrar(n){
      var btnRegistrar=document.getElementById("btnRegistrar");
      var btnEditar=document.getElementById("btnEditar");
      var valorEditar=document.getElementById("verificadorEditar");
      if(n==1){
        btnRegistrar.style.display='none';
        btnEditar.style.display='block'
        valorEditar.value=1;
        console.log(valorEditar.value);
    }else{
        btnRegistrar.style.display='block';
        btnEditar.style.display='none'
        valorEditar.value=0;
        console.log(valorEditar.value);
    }
    document.getElementById("overlay1").style.visibility = "visible";
  };
  $('#filtroEleccion').on('change',function(){
        $("#tabla_eventos tr td").remove(); 
        var estado=$('#filtroEleccion').val();
        console.log(estado);
          $.ajax({
            type:'POST',
            url:'include/filtroEventos.php',
            data:{estado:estado},
            success: function(data){
                $('#tabla_contenido').append(data);
            }
        });
      });
    $('#except .editarEvento button').on('click',function(){
        var row=$(this).closest('tr');
        var nombre=$(row).find("td").eq(2).html(),
        apellido=$(row).find("td").eq(3).html(),
        evento=$(row).find("td").eq(4).html(),
        fecha=$(row).find("td").eq(1).html(),
        id=$(row).find("td").eq(0).html(),
        responsable=$(row).find("td").eq(5).html();
        descripcion=$(row).find("td").eq(6).html();
        mostrar(1);
        $('#id_accion').val(id);
        $('#nombre').val(nombre);
        $('#apellido').val(apellido);
        $('#form-fecha').val(fecha);
        $('#responsable').val(responsable);
        $('#evento option:selected').val(evento);
        $('#descr-evento ').val(descripcion);
    });
    $('#busqueda').on('keyup',function(){
        var valor=$(this).val().toLowerCase();
        $('#tabla_contenido tr').filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(valor)>-1);
        });
    });
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
    var fecha = new Date(); //Fecha actual
    var mes = fecha.getMonth()+1; //obteniendo mes
    var dia = fecha.getDate(); //obteniendo dia
    var year = fecha.getFullYear(); //obteniendo año
    if(dia<10)
        dia='0'+dia; 
    if(mes<10)
        mes='0'+mes 
    document.getElementById('form-fecha').min=year+"-"+mes+"-"+dia;
    document.getElementById('fechaDesde').value=year+"-"+mes+"-"+dia;
    document.getElementById('fechaHasta').value=year+"-"+mes+"-"+dia;
    $("#tabla_contenido tr").each(function() {
    var from=$('#fechaDesde').val();
    var to=$('#fechaHasta').val();
    var row = $(this);
    var date = row.find("td").eq(1).html();
    var show = true;
    if (from && date < from)
      show = false;
    
    if (to && date > to)
      show = false;

    if (show)
      row.show();
    else
      row.hide();
  }); 
  };
    function filtrado(){
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("filtroBusqueda");
        filter = input.value.toUpperCase();
        table = document.getElementById("tabla_eventos");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[3];
            if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
            }
        }
    }
</script>
<script>
    $('#fechaDesde').on('change',function(){
        $("#tabla_contenido tr").each(function() {
    var from=$('#fechaDesde').val();
    var to=$('#fechaHasta').val();
    var row = $(this);
    var date = row.find("td").eq(1).html();
    var show = true;
    if (from && date < from)
      show = false;
    
    if (to && date > to)
      show = false;

    if (show)
      row.show();
    else
      row.hide();
  });
    })
    $('#fechaHasta').on('change',function(){
        $("#tabla_contenido tr").each(function() {
    var from=$('#fechaDesde').val();
    var to=$('#fechaHasta').val();
    var row = $(this);
    var date = row.find("td").eq(1).html();
    var show = true;
    if (from && date < from)
      show = false;
    
    if (to && date > to)
      show = false;

    if (show)
      row.show();
    else
      row.hide();
  });
    })
</script>