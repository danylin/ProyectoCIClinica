<!DOCTYPE html>
<html>
<?php
include("include/titulo.php");
session_start();
?>
<body>
    <header>
      <nav>
        <ul>
          <li><img src="img/logotipo_auna.png" alt="logotipo auna"></li>
          <div class="navegacion">
          <li><a href="usuario2.php">CREACION DE EVENTOS</a></li>
          <li><a href="registro.php">CREACION DE USUARIO</a></li>
          <li><a href="#">DESPACHO</a></li>
          <li><a href="#">REPORTES</a></li>
          <li><a href="include/logout.php">SALIR</a></li>
          </div>
        </ul>
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