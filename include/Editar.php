<?php
include("titulo.php");
?>
<link rel="stylesheet" href="../estilos.css">
<body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <img class="navbar-brand" src="../img/logotipo_auna.png" alt="logotipo auna">
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item active"><a class="nav-link" href="../usuario2.php">CREACION DE EVENTOS <i class="fa fa-plus-square" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="#">CREACION DE USUARIO <i class="fa fa-user" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="#">DESPACHO <i class="fa fa-archive" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="#">REPORTES <i class="fa fa-file" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="include/logout.php">SALIR <i class="fas fa-sign-out-alt"></i></a></li>
          </ul>
        </div>
      </nav>
    </header>
    <div class="registro">
          <form class="formu-registro" action="Registro_Usuario.php" method="post">
              <div class="container" id='form-registro'>
                <h3>Edicion de Usuario</h3>
                <div class='row'>
                  <p class='col-sm-6' id='dni'>DNI <br> <input type="text" name='dni' maxlength=8></p>
                  <p class='col-sm-6' id='usuario'>Usuario <br> <input type="text" name='usuario'></p>
                </div>
                <div class='row'>
                  <p class='col-sm-6' id='contraseña'>Contraseña <br> <input type="password" name='contraseña'></p>
                  <p class='col-sm-6' id='nombre'>Nombre <br> <input type="text" name='nombre'></p>                
                </div>
                <div class="row">
                  <p class='col-sm-6' id='apellido'>Apellido <br> <input type="text" name='apellido'></p>
                <?php
                      include("bd_usuario.php"); 
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
                      while($row=mysqli_fetch_array($resultado)){
                        echo "<option value=".$row['id']." >". $row['sede'] ."</option>";
                      }
                      echo "</select> </p> </div>";
              ?> 
                </div>      
            <input type="submit" id='boton' value="Editar" onclick="location.href='../Usuarios.php'">
            <input type="button" id='boton' value="Volver" onclick="location.href='../Usuarios.php'">
          </form>
        </div>
</body>
