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
      <div class="formulario">
        <form action="registro.php" method="post">
            <h1>Registro</h1>
            <p class='form' id='usuario'>DNI: <input type="text" name='dni'></p>
            <p class='form' id='usuario'>Usuario: <input type="text" name='usuario'></p>
            <p class='form' id='usuario'>Contraseña: <input type="text" name='contraseña'></p>
            <p class='form' id='usuario'>Nombre: <input type="text" name='nombre'></p>
            <p class='form' id='usuario'>Apellido <input type="text" name='apellido'></p>
            <p class='form' id='usuario'>Cargo <input type="number" name='cargo'></p>
            <?php
                    include("include/bd_usuario.php"); 
                    $sql="SELECT*FROM sede__db_area;";
                    $resultado=mysqli_query($conexion,$sql);
                    echo "<select name='sede'>";
                    while($row=mysqli_fetch_array($resultado)){
                      echo "Sede: <option value=".$row['id']." >". $row['sede'] ."</option>";
                    }
                    echo "</select>";
            ?> 
               <?php
                    include("include/bd_usuario.php"); 
                    $sql="SELECT*FROM eventos;";
                    $resultado=mysqli_query($conexion,$sql);
                    echo "<select name='evento'>Sede";
                    while($row=mysqli_fetch_array($resultado)){
                      echo "<option value=".$row['idevento'].">". $row['nombre'] ."</option>";
                    }
                    echo "</select>";
            ?> 
            <p><input type="submit" value="Registrar"></p>
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
            $sql="INSERT INTO usuarios_db values ($dni,'$usuario','$contraseña','$nombre','$apellido',$sede,$cargo,$evento);";
            $resultado=mysqli_query($conexion,$sql);          
          ?>
        </form>
      </div>
    </header>