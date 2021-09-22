<!DOCTYPE html>
<html>
<?php
include("include/titulo.php");
session_start();
?>
<body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <img class="navbar-brand" src="img/logotipo_auna.png" alt="logotipo auna" 
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item active"><a class="nav-link" href="usuario2.php">CREACION DE EVENTOS <i class="fa fa-plus-square" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="usuario/Usuarios.php">CREACION DE USUARIO <i class="fa fa-user" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="despacho/despacho.php">DESPACHO <i class="fa fa-archive" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="#">REPORTES <i class="fa fa-file" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="include/logout.php">SALIR <i class="fas fa-sign-out-alt"></i></a></li>
          </ul>
        </div>
      </nav>
    </header>
    <div class= "sesion">
      <h2>Bienvenido(a) a la Sesion <?php echo $_SESSION['nombre'] . " " . $_SESSION['apellido'] ?> </h2>
    </div>
    <section>
      <?php
        include("include/creacion_evento.php")
      ?>
    </section>
</body>
</html>