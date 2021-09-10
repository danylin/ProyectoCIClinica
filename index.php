
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Control de Inventarios</title>
</head>
<body>
    <header>
      <nav>
        <div class="logotipo">
          <img src="img/logotipo_auna.png" alt="logotipo auna">
        </div>
      </nav>
    </header>
    <section>
        <div class="formulario">
            <h4>Iniciar Sesion</h2>
            <form action="mostrar.php"method="post">
              <p class='form' id='usuario'>Usuario <br><input type="text" name="usuario"></p>
              <p class="form" id='contraseña'> Contraseña <br> <input type="password" name="clave"></p>
              <p>
                    <?php
                    include("include/bd_usuario.php"); 
                    $sql="SELECT*FROM eventos;";
                    $resultado=mysqli_query($conexion,$sql);
                    echo "<select>";
                    while($row=mysqli_fetch_array($resultado)){
                      echo "<option>". $row['nombre'] ."</option>";
                    }
                    echo "</select>";
                  ?> 
              </p>
              <input class='form' id="boton" type="submit" value="Ingresar">
              <input class='form' id="boton" type="button" value="Registrar"  onclick="location.href='registro.php'">
            </form>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
</body>
</html>