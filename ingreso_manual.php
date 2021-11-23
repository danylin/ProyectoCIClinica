<!DOCTYPE html>
<html>
<head>
<?php
include("include/titulo.php");
?>
</head>
<body>
<header>
      <nav>
         <img src="img/logotipo_auna.png" alt="logotipo auna" width="85px">
      </nav>
    </header>
    <section>
      <!-- El presente apartado permitira al usuario ingresar con una contraseña proporcionada por el encargado -->
        <div class="formulario">
            <h4>Iniciar Sesion</h2>
            <form action="mostrar.php"method="post">
              <p class='form' id='dni'>Usuario <br><input type="text" name="usuario" placeholder="Usuario" autocomplete="off"></p>
              <p class='form' id='dni'>Contraseña <br><input type="password" name="clave" placeholder="Contraseña" autocomplete="off"></p>
              <input class='form' id="boton" type="submit" value="Ingresar">
              <input class='form' id="boton" type="button" value="Ingreso por ID" onclick="location='index.php'">
            </form>
        </div>
    </section>
</body>
</html>