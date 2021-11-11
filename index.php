
<!DOCTYPE html>
<html>
<?php
include("include/titulo.php");
?>
<body style=>
    <header>
      <nav class="navbar navbar-expand-lg" style="height:80px;">
      <img class="navbar-brand" src="img/logotipo_auna.png" alt="logotipo auna" width="85px">
      </nav>
    </header>
    <section>
        <div class="formulario">
            <h4>Ingrese Contraseña</h4>
            <form action="mostrar.php" method="post">
              <p class='form' id='dni'><br><input type="password" name="usuario" autocomplete="off" autofocus="autofocus" placeholder='Ingrese Contraseña'></p>
              <input class='form' id="boton-ingreso" type="submit" value="Ingresar" onclick="reenviar()">
              <input class='form' id="boton" type="button" value="Ingreso Manual" onclick="location='ingreso_manual.php'">
            </form>
        </div>
    </section>
 </body>
</html>