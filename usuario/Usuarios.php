<!DOCTYPE html>
<html>
<?php
include("../include/titulo.php");
?>
<body>
  <header>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <img class="navbar-brand" src="../img/logotipo_auna.png" alt="logotipo auna">
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item active"><a class="nav-link" href="../usuario2.php">CREACION DE EVENTOS <i class="fa fa-plus-square" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="#">CREACION DE USUARIO <i class="fa fa-user" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="../despacho/despacho.php">DESPACHO <i class="fa fa-archive" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="#">REPORTES <i class="fa fa-file" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="include/logout.php">SALIR <i class="fas fa-sign-out-alt"></i></a></li>
          </ul>
        </div>
      </nav>
  </header>
      <section>
        <div class='btn btn-info' onclick='location="Registro_Usuario.php"'> Nuevo Usuario <i class="fas fa-plus"></i></div>
        <div class="usuarios-actuales">
          <h3>Usuarios Actuales</h3>
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
                include("../include/bd_usuario.php");
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
                    echo 
                    "<td>
                    <form action='EliminarU.php?dni=".$row['dni']."' method='post'>
                    <button class='btn btn-primary' type='submit' value=1 name='tipo'>Editar</button>
                    <button class='btn btn-danger' type='submit' value=2 name='tipo' >Eliminar</button>
                    </form>
                    </td>";
                    echo "</tr>";
                }
                ?>
              </tbody>
            </table>
        </div>
      </div>  
      </section>
  </html>