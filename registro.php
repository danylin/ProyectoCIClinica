<!DOCTYPE html>
<html>
<?php
include("include/titulo.php");
?>
<body>
  <header>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <img class="navbar-brand" src="img/logotipo_auna.png" alt="logotipo auna">
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item active"><a class="nav-link" href="usuario2.php">CREACION DE EVENTOS <i class="fa fa-plus-square" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="registro.php">CREACION DE USUARIO <i class="fa fa-user" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="#">DESPACHO <i class="fa fa-archive" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="#">REPORTES <i class="fa fa-file" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="include/logout.php">SALIR <i class="fas fa-sign-out-alt"></i></a></li>
          </ul>
        </div>
      </nav>
  </header>
      <section>
      <div class="registro">
        <div class="formulario">
          <form class="formu-registro" action="registro.php" method="post">
              <h1>Registro</h1>
              <p class='form' id='dni'>DNI: <input type="text" name='dni'></p>
              <p class='form' id='usuario'>Usuario: <input type="text" name='usuario'></p>
              <p class='form' id='contraseña'>Contraseña: <input type="password" name='contraseña'></p>
              <p class='form' id='nombre'>Nombre: <input type="text" name='nombre'></p>
              <p class='form' id='apellido'>Apellido <input type="text" name='apellido'></p>
              <?php
                      include("include/bd_usuario.php"); 
                      error_reporting(0);
                      $sql="SELECT*FROM tipo_db;";
                      $resultado=mysqli_query($conexion,$sql);
                      echo "<p> Tipo: <select name='cargo'>";
                      while($row=mysqli_fetch_array($resultado)){
                        echo "<option value=".$row['id_tipo'].">". $row['id_tipo'] ."</option>";
                      }
                      echo "</select> </p>";
                      
                      $sql="SELECT*FROM sede__db_area;";
                      $resultado=mysqli_query($conexion,$sql);
                      echo "<p> Sede: <select name='sede'>";
                      while($row=mysqli_fetch_array($resultado)){
                        echo "<option value=".$row['id']." >". $row['sede'] ."</option>";
                      }
                      echo "</select> </p>";
              ?> 
            <input type="submit" id='boton' value="Registrar">
            <input type="button" id='boton' value="Volver" onclick="location.href='index.php'">
          </form>
          <?php
              include("include/bd_usuario.php"); 
              $dni=$_POST['dni'];
              $usuario=$_POST['usuario'];
              $contraseña=$_POST['contraseña'];
              $nombre=$_POST['nombre'];
              $apellido=$_POST['apellido'];
              $sede=$_POST['sede'];
              $cargo=$_POST['cargo'];
              $sql="INSERT INTO usuarios_db values ($dni,'$usuario','$contraseña','$nombre','$apellido',$sede,$cargo);";
              $resultado=mysqli_query($conexion,$sql);          
            ?>
        </div>
        <div class="usuarios-actuales">
          <table class="table table-light">
            <thead>
              <th scope="col">DNI</th>
              <th scope="col">Usuario</th>
              <th scope="col">Nombre</th>
              <th scope="col">Apellido</th>
              <th scope="col">Sede</th>
              <th scope="col">Tipo</th>
              <th scope="col">Accion</th>
            </thead>
              <tbody>
                <?php
                include("bd_usuario.php");
                $sql="SELECT dni,usuario,nombre,apellido,a.sede 'sede',id_tipo FROM usuarios_db INNER JOIN sede__db_area a on usuarios_db.id_sede=a.id;";
                $resultado=mysqli_query($conexion,$sql);
                while($row=mysqli_fetch_array($resultado)){
                    echo "<tr>";
                    echo "<th scope='row'>". $row['dni']."</th>";
                    echo "<td>". $row['usuario']."</td>";
                    echo "<td>". $row['nombre']."</td>";
                    echo "<td>". $row['apellido']."</td>";
                    echo "<td>". $row['sede']."</td>";
                    echo "<td>". $row['id_tipo']."</td>";
                    echo "<td><i class='fas fa-edit' onclick='editar()'></i></td>";
                    echo "</tr>";
                }
                ?>
              </tbody>
            </table>
        </div>
      </div>  
      </section>
  </html>