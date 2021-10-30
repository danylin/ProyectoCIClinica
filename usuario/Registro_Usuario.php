<?php
include("../include/titulo.php");
session_start();
if(isset($_POST['dni'])){
  header("Location:Usuarios.php");
} 
?>
<link rel="stylesheet" href="../estilos.css">
<body>
<header>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <img class="navbar-brand" src="../img/logotipo_auna.png" alt="logotipo auna" width="75px">
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
          <?php include("../include/barraNavegacion.php") ?>
          </ul>
        </div>
      </nav>
  </header>
        <div class="registro">
          <form class="formu-registro" action="" method="post">
              <div class="container" id='form-registro'>
                <h3>Registro de Usuario</h3>
                <div class='row'>
                  <p class='col-sm-6' id='dni'>DNI <br> <input type="text" name='dni' maxlength=8 autocomplete=off></p>
                  <p class='col-sm-6' id='usuario'>Usuario <br> <input type="text" name='usuario' autocomplete=off></p>
                </div>
                <div class='row'>
                  <p class='col-sm-6' id='contraseña'>Contraseña <br> <input type="password" name='contraseña'></p>
                  <p class='col-sm-6' id='nombre'>Nombre <br> <input type="text" name='nombre' autocomplete=off></p>                
                </div>
                <div class="row">
                  <p class='col-sm-6' id='apellido'>Apellido <br> <input type="text" name='apellido' autocomplete=off></p>
                <?php
                      include("../include/bd_usuario.php"); 
                      error_reporting(0);
                      $sql="SELECT*FROM tipo_db;";
                      $resultado=mysqli_query($conexion,$sql);
                      echo "<p class='col-sm-6'> Tipo de Usuario <br> <select name='cargo'>";
                      while($row=mysqli_fetch_array($resultado)){
                        echo "<option value=".$row['id_tipo'].">". $row['id_tipo'] ."</option>";
                      }
                      echo "</select> </p> </div>";
                      echo "<div class='row'>";
                      $sql="SELECT*FROM sede__db_area;";
                      $resultado=mysqli_query($conexion,$sql);
                      echo "<p  class='col-sm-12'> Sede <br> <select name='sede'>";
                      echo "<option value='none' selected disabled> Elija una sede </option>";
                      while($row=mysqli_fetch_array($resultado)){
                        echo "<option value=".$row['id']." >". $row['sede'] ."</option>";
                      }
                      echo "</select> </p>";
                      echo "<p class='col-sm-12' id='checkbox_list'> Eventos <br>";
                      echo "<input type='checkbox' name='chk1' value=1 ><label for='chk1'>Quimioterapia</label><br>";
                      echo "<input type='checkbox' name='chk2' value=1 ><label for='chk2'>Cirugía</label><br>";
                      echo "<input type='checkbox' name='chk3' value=1 ><label for='chk3'>P. Médico</label><br>";
                      echo "<input type='checkbox' name='chk4' value=1 ><label for='chk4'>C. Logístico</label><br>";
                      echo "</p> </div>";
              ?> 
                </div>      
            <input type="submit" id='boton' value="Registrar" onclick='mostrar()'>
            <input type="button" id='boton' value="Volver" onclick="location.href='Usuarios.php'">
            <?php
              $dni=$_POST['dni'];
              $usuario=$_POST['usuario'];
              $contraseña=$_POST['contraseña'];
              $nombre=$_POST['nombre'];
              $apellido=$_POST['apellido'];
              $sede=$_POST['sede'];
              $cargo=$_POST['cargo'];
              if (isset($_POST['chk1'])){
                $quimio=$_POST['chk1'];
              }
              else{
                $quimio=0;
              }
              if (isset($_POST['chk2'])){
                $cirugia=$_POST['chk2'];
              }
              else{
                $cirugia=0;
              }
              if (isset($_POST['chk3'])){
                $medico=$_POST['chk3'];
              }
              else{
                $medico=0;
              }
              if (isset($_POST['chk4'])){
                $logistico=$_POST['chk4'];
              }
              else{
                $logistico=0;
              }
              
              $sql="INSERT INTO usuarios_db values ($dni,'$usuario','$contraseña','$nombre','$apellido',$sede,$cargo,$quimio,$cirugia,$medico,$logistico);";
              $resultado=mysqli_query($conexion,$sql);
            ?>
          </form>
        </div>
</body>
