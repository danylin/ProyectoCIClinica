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
        <ul>
          <li><img src="img/logotipo_auna.png" alt="logotipo auna"></li>
          <li><a href="index.php">Control de Inventarios</a></li>
        </ul>
      </nav>
      <div class="formulario">
        <form action="registro.php" method="post">
            <h1>Registro</h1>
            <p class='form' id='dni'>DNI: <input type="text" name='dni'></p>
            <p class='form' id='usuario'>Usuario: <input type="text" name='usuario'></p>
            <p class='form' id='contraseña'>Contraseña: <input type="text" name='contraseña'></p>
            <p class='form' id='nombre'>Nombre: <input type="text" name='nombre'></p>
            <p class='form' id='apellido'>Apellido <input type="text" name='apellido'></p>
            <p class='form' id='cargo'>Cargo <input type="number" name='cargo'></p>
            <?php
                    error_reporting(0);
                    include("include/bd_usuario.php"); 
                    $sql="SELECT*FROM sede__db_area;";
                    $resultado=mysqli_query($conexion,$sql);
                    echo "Sede: <select name='sede'>";
                    while($row=mysqli_fetch_array($resultado)){
                      echo "<option value=".$row['id']." >". $row['sede'] ."</option>";
                    }
                    echo "</select>";
                    $sql="SELECT*FROM eventos_db;";
                    $resultado=mysqli_query($conexion,$sql);
                    echo "<br> Evento: <select name='evento'>Sede";
                    while($row=mysqli_fetch_array($resultado)){
                      echo "<option value=".$row['idevento'].">". $row['nombre'] ."</option>";
                    }
                    echo "</select> <br>";
            ?> 
          <input type="submit" id='boton' value="Registrar" onclick="location.href='index.php'">
          <input type="button" id='boton' value="Volver" onclick="location.href='index.php'">
        </form>
        <?php
            include("include/bd_usuario.php"); 
            $dni=$_POST['dni'];
            $usuario=$_POST['usuario'];
            $contraseña=$_POST['contraseña'];
            $nombre=$_POST['nombre'];
            $apellido=$_POST['apellido'];
            $sede=$_POST['sede'];
            $evento=$_POST['evento'];
            $cargo=$_POST['cargo'];
            $sql="INSERT INTO usuario values ($dni,'$usuario','$contraseña','$nombre','$apellido',$sede,$cargo,$evento);";
            $resultado=mysqli_query($conexion,$sql);          
          ?>
      </div>
    </header>