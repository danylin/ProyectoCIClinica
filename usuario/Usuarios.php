<!DOCTYPE html>
<html lang="es">
<?php
include("../include/titulo.php");
session_start();
include("../include/bd_usuario.php");
$sql="SELECT*FROM sede__db_area WHERE id=".$_SESSION['id_sede'];
$consulta=mysqli_query($conexion,$sql);
$row=mysqli_fetch_array($consulta);
?>
<link rel="stylesheet" href="../estilos.css">
<body>
  <header>
      <nav class="navbar navbar-expand-lg" style="height:80px;">
          <img class="navbar-brand" src="../img/logotipo_auna.png" alt="logotipo auna" width="85px"><b><?php echo $row['sede'] ?></b> 
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item active"><a class="nav-link" href="../usuario2.php" id="textoNavegador">Eventos <i class="fa fa-plus-square" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="textoNavegador">Usuarios <i class="fa fa-user" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="../include/logout.php" id="textoNavegador">Salir <i class="fas fa-sign-out-alt"></i></a></li>
          </ul>
        </div>
      </nav>
  </header>
      <section>
        <div id="usuarioEncabezado">
        <div class='btn btn-info' onclick='location="Registro_Usuario.php"'> Nuevo Usuario <i class="fas fa-plus"></i></div>
        <h3 style="padding-left:30%;">Usuarios Actuales</h3>
        </div>
        <div class="usuarios-actuales">
          <table class="table navbar-light bg-light" id="tablaUsuarios">
            <thead>
              <th scope="col">DNI</th>
              <th scope="col">Usuario</th>
              <th scope="col">Nombre</th>
              <th scope="col">Apellido</th>
              <th scope="col">Sede</th>
              <th scope="col">Tipo</th>
              <th scope="col">Evento</th>
              <th scope="col">Accion</th>
            </thead>
              <tbody>
                <?php
                include("../include/bd_usuario.php");
                $sql="SELECT dni,usuario,nombre,apellido,a.sede 'sede',id_tipo,Evento1,Evento2,Evento3,Evento4 FROM sop__usuarios_db INNER JOIN sede__db_area a on sop__usuarios_db.id_sede=a.id;";
                $resultado=mysqli_query($conexion,$sql);
                while($row=mysqli_fetch_array($resultado)){
                    echo "<tr>";
                    echo "<td scope='row'>". $row['dni']."</td>";
                    echo "<td>". $row['usuario']."</td>";
                    echo "<td>". $row['nombre']."</td>";
                    echo "<td>". $row['apellido']."</td>";
                    echo "<td>". $row['sede']."</td>";
                    echo "<td>". $row['id_tipo']."</td>";
                    echo "<td>";
                    if($row["Evento1"]==1){
                    echo "Quimioterapia <br>";
                    }
                    if($row["Evento2"]==1){
                      echo "Cirugia <br>";
                    }
                    if($row["Evento3"]==1){
                      echo "Procedimiento Medico <br>";
                    }
                    if($row["Evento4"]==1){
                      echo "Control Logistico <br>";
                    }
                    echo "</td>";
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