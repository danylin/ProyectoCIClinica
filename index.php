
<!DOCTYPE html>
<html>
<?php
include("include/titulo.php");
?>
<body>
    <header>
      <nav>
          <li><img src="img/logotipo_auna.png" alt="logotipo auna"></li>
      </nav>
    </header>
    <section>
        <div class="formulario">
            <h4>Iniciar Sesion</h2>
            <form action="mostrar.php"method="post">
              <p class='form' id='usuario'>Usuario <br><input type="text" name="usuario"></p>
              <p class="form" id='contraseña'> Contraseña <br> <input type="password" name="clave"></p>
              <input class='form' id="boton" type="submit" value="Ingresar">
            </form>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
</body>
</html>