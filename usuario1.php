<!DOCTYPE html>
<html>
  <head>
    <?php
    include("include/titulo.php");
    session_start();
    ?>
  </head>
<body>
<header>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <img class="navbar-brand" src="img/logotipo_auna.png" alt="logotipo auna">
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item active"><a class="nav-link" href="usuario2.php">EVENTOS <i class="fa fa-plus-square" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="include/logout.php">SALIR <i class="fas fa-sign-out-alt"></i></a></li>
          </ul>
        </div>
      </nav>
    </header>
    <section>
    <div class= "sesion" id="encabezado">
            <p>Usuario: <?php echo $_SESSION['nombre'] . " " . $_SESSION['apellido']?></p>
    </div>
      <?php
        include("include/creacion_evento.php")
      ?>
    </section>
</body>