$(document).ready(function() {
    var valorAnterior;
    var cantidad;
    $('#gtin').on('click',function(event){
      event.preventDefault();
    });
      setInterval(function(){ 
        var table = document.getElementById("mensaje");
        var subtipo=document.getElementById("subtipo").value;
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
            tipo.push(row.cells[3].innerText);
            update.push(row.cells[5].children[0].value);
            devObjeto.push(row.cells[6].children[0].value);
           if(row.cells[5].children[0].value==0){
            row.cells[5].children[0].value=1;
           }
        }
        $.ajax({
            type:'POST',
            url:'registrarDespacho.php?evento=<?php echo $evento ?>',
            data:{codigo:codigo,descripcion:descripcion,cantidad:cantidad,tipo:tipo,subtipo:subtipo,devObjeto:devObjeto,update:update,evento:evento},
           });
        }, 35000);
        $('#btnGuardado').on('click',function(event){
          event.preventDefault();
        var table = document.getElementById("mensaje");
        var subtipo=document.getElementById("subtipo").value;
        var evento=document.getElementById("tipoEvento").value;
        var codigo=[];
        var descripcion=[];
        var cantidad=[];
        var tipo=[];
        var update=[];
        var devObjeto=[];
        if (subtipo=='Todos'){
          if (evento!="Procedimiento Medico" || evento!="Control Logistico"){
            alert('Elija un subtipo de producto antes de registrarlo');
          }
        }else{
          for (var i = 0, row; row = table.rows[i]; i++) {
            codigo.push(row.cells[0].innerText);
            descripcion.push(row.cells[1].innerText);
            cantidad.push(row.cells[2].children[0].value);
            tipo.push(row.cells[3].innerText);
            update.push(row.cells[5].children[0].value);
            devObjeto.push(row.cells[6].children[0].value);
           if(row.cells[5].children[0].value==0){
            row.cells[5].children[0].value=1
           }
        }
        $.ajax({
            type:'POST',
            url:'registrarDespacho.php?evento=<?php echo $evento ?>',
            data:{codigo:codigo,descripcion:descripcion,cantidad:cantidad,tipo:tipo,subtipo:subtipo,devObjeto:devObjeto,update:update,evento:evento},
            success: function(data){
              alert('Guardado con Exito');
            }
           });
        }
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
      var tipoEvento=$('#subtipo').val();
      var evento=document.getElementById("tipoEvento").value;
      $.ajax({
        type:'POST',
        url:'creacionDespacho.php',
        data:{codigo:codigo,devolucion:devolucion,tipoEvento:tipoEvento,evento:evento},
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
      var tipoEvento=$('#subtipo').val();
      var evento=document.getElementById("tipoEvento").value;
      $.ajax({
        type:'POST',
        url:'creacionDespacho.php',
        data:{nombre:nombre,cantidad:cantidad,devolucion:devolucion,tipoEvento:tipoEvento,evento:evento},
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
      document.getElementById("codigo").focus();
  });
  $('#busqueda').on('keyup',function(){
    var filas;
    var nombre=$('#busqueda').val();
    var devolucion=$('#devolucion').val();
    var tipoEvento=$('#tipoEvento').val();
    var subtipo=$('#subtipo').val();
    $("#resultadoBusqueda tr").remove(); 
      $.ajax({
        type:'POST',
        url:'busquedaManual.php',
        data:{nombre:nombre,devolucion:devolucion,tipoEvento:tipoEvento,subtipo:subtipo},
        success: function(data){
            $('#resultadoBusqueda').prepend(data);
        }
    });
  });
$('#llenadoEncuentro1').on('click',function(){
  if(confirm("Está a punto de cerrar el evento. Despues de ello no podrá modificarlo.¿Está seguro de cerrar el evento?")){
    var row=$('#except .botonReporte button').closest('tr');
    var id=$(row).find("td").eq(3).html();
    var encuentro=$('#encuentro').val();
    window.location="tipoReporte.php?codigo="+id+"&encuentro="+encuentro;
  }
});
  });