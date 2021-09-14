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
          <li><a href="registro.php">CREACION DE USUARIO</a></li>
          <li><a href="#">DESPACHO</a></li>
          <li><a href="#">REPORTES</a></li>
        </ul>
      </nav>
      <div class="formulario">
        <form action="registro.php" method="post">
            <h1>Registro</h1>
            <p class='form' id='dni'>DNI: <input type="text" name='dni'></p>
            <p class='form' id='usuario'>Usuario: <input type="text" name='usuario'></p>
            <p class='form' id='contraseña'>Contraseña: <input type="password" name='contraseña'></p>
            <p class='form' id='nombre'>Nombre: <input type="text" name='nombre'></p>
            <p class='form' id='apellido'>Apellido <input type="text" name='apellido'></p>
            <?php
                    include("include/bd_usuario.php"); 
                    error_reporting(0);
                    $sql="SELECT*FROM tipo_db;";
                    $resultado=mysqli_query($conexion,$sql);
                    echo "<p> Tipo: <select name='cargo'>";
                    while($row=mysqli_fetch_array($resultado)){
                      echo "<option value=".$row['id_tipo'].">". $row['id_tipo'] ."</option>";
                    }
                    echo "</select> </p>";
                    
                    $sql="SELECT*FROM sede__db_area;";
                    $resultado=mysqli_query($conexion,$sql);
                    echo "<p> Sede: <select name='sede'>";
                    while($row=mysqli_fetch_array($resultado)){
                      echo "<option value=".$row['id']." >". $row['sede'] ."</option>";
                    }
                    echo "</select> </p>";
            ?> 
          <input type="submit" id='boton' value="Registrar">
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
            $cargo=$_POST['cargo'];
            $sql="INSERT INTO usuarios_db values ($dni,'$usuario','$contraseña','$nombre','$apellido',$sede,$cargo);";
            $resultado=mysqli_query($conexion,$sql);          
          ?>
      </div>
    </header>