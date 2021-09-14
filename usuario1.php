<!DOCTYPE html>
<html>
<?php
include("include/titulo.php");
?>
<body>
    <header>
      <nav>
        <ul>
          <li><img src="img/logotipo_auna.png" alt="logotipo auna"></li>
          <li><a href="#">CREACION DE EVENTOS</a></li>
          <li><a href="#">DESPACHO</a></li>
          <li><a href="#">REPORTES</a></li>
        </ul>
        <div class= "sesion">
            <h2>Bienvenido(a) a la Sesion Usuario Tipo 1</h2>
        </div>
      </nav>
    </header>
    <section>
        <?php
        include("include/creacion_evento.php");
        ?>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
</body>