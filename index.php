
<!DOCTYPE html>
<html>
<?php
include("include/titulo.php");
?>
<body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <img class="navbar-brand" src="img/logotipo_auna.png" alt="logotipo auna">
      </nav>
    </header>
    <section>
        <div class="formulario">
            <h4>Iniciar Sesion</h2>
            <form action="mostrar.php" method="post">
              <p class='form' id='dni'>ID <br><input type="text" name="usuario" autocomplete="off" autofocus="autofocus" ></p>
              <input class='form' id="boton-ingreso" type="submit" value="Ingresar" onclick="reenviar()">
              <input class='form' id="boton" type="button" value="Ingreso Manual" onclick="location='ingreso_manual.php'">
            </form>
        </div>
    </section>
 </body>
</html>