
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
            <form action="mostrar.php" method="post">
              <p class='form' id='dni'>ID <br><input type="text" name="usuario" autocomplete="off" ></p>
              <input class='form' id="boton" type="submit" value="Ingresar">
              <input class='form' id="boton" type="button" value="Ingreso Manual" onclick="location='ingreso_manual.php'">
            </form>
        </div>
    </section>
 </body>
</html>