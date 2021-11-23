<!DOCTYPE html>
<html>
  <head>
    <!-- La presente pagina mostrara al usuario de tipo 2 y 3 los eventos disponibles en su respectiva clinica -->
  <?php
    include("include/titulo.php");
    include("include/bd_usuario.php");
    session_start();
    $sql="SELECT*FROM sede__db_area WHERE id=".$_SESSION['id_sede'];
    $consulta=mysqli_query($conexion,$sql);
    $row=mysqli_fetch_array($consulta);
    ?>     
  </head>
<body>
    <header>
      <nav class="navbar navbar-expand-lg" style="height:80px;">
          <img class="navbar-brand" src="img/logotipo_auna.png" alt="logotipo auna" width="85px"><b><?php echo $row['sede'] ?></b> 
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item active" ><a class="nav-link" href="usuario2.php"  id="textoNavegador">Eventos <i class="fa fa-plus-square" aria-hidden="true"></i></a></li>
            <li class="nav-item" ><a class="nav-link" href="usuario/Usuarios.php" id="textoNavegador">Usuarios <i class="fa fa-user" aria-hidden="true"></i></a></li>
            <li class="nav-item" ><a class="nav-link" href="include/logout.php" id="textoNavegador">Salir <i class="fas fa-sign-out-alt"></i></a></li>
          </ul>
        </div>
      </nav>
    </header>
    <section>
      <?php
        include("include/creacion_evento.php")
      ?>
    </section>
</body>
</html>
