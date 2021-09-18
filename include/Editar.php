<?php
include("titulo.php");
?>
<link rel="stylesheet" href="../estilos.css">
<body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <img class="navbar-brand" src="../img/logotipo_auna.png" alt="logotipo auna">
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item active"><a class="nav-link" href="../usuario2.php">CREACION DE EVENTOS <i class="fa fa-plus-square" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="../Usuarios.php">CREACION DE USUARIO <i class="fa fa-user" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="#">DESPACHO <i class="fa fa-archive" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="#">REPORTES <i class="fa fa-file" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="include/logout.php">SALIR <i class="fas fa-sign-out-alt"></i></a></li>
          </ul>
        </div>
      </nav>
    </header>
    <div class="registro">
                
          <form class="formu-registro" action="Editar.php?dni= <?php echo $dniComparacion ?>" method="post">
              <div class="container" id='form-registro'>
                <h3>Edicion de Usuario</h3>
                <?php
                  include("bd_usuario.php"); 
                  $dniComparacion=$_GET['dni'];
                  $editUsuario="SELECT*from usuarios_db where dni=$dniComparacion ;";
                  $consultaUsuario=mysqli_query($conexion,$editUsuario);
                  $resultado=mysqli_fetch_array($consultaUsuario);
                ?>
                <div class='row'>
                  <p class='col-sm-6' id='dni'>DNI <br> <input type="text" name='dni' maxlength=8 value=<?php echo $resultado['dni']; ?>></p>
                  <p class='col-sm-6' id='usuario'>Usuario <br> <input type="text" name='usuario' value=<?php echo $resultado['usuario']; ?>></p>
                </div>
                <div class='row'>
                  <p class='col-sm-6' id='contraseña'>Contraseña <br> <input type="password" name='contraseña' value=<?php echo $resultado['clave']; ?>></p>
                  <p class='col-sm-6' id='nombre'>Nombre <br> <input type="text" name='nombre' value=<?php echo $resultado['nombre']; ?>></p>                
                </div>
                <div class="row">
                  <p class='col-sm-6' id='apellido'>Apellido <br> <input type="text" name='apellido' value=<?php echo $resultado['apellido']; ?>></p>
                <?php
                      
                      $sql="SELECT*FROM tipo_db;";
                      $tipoResultado=mysqli_query($conexion,$sql);
                      echo "<p class='col-sm-6'> Tipo de Usuario <br> <select name='cargo'";
                      while($row=mysqli_fetch_array($tipoResultado)){
                        if($row['id_tipo']==$resultado['id_tipo']){
                          echo "<option value=".$row['id_tipo']." selected>". $row['id_tipo'] ."</option>";
                        }
                        else{
                          echo "<option value=".$row['id_tipo'].">". $row['id_tipo'] ."</option>";
                        }
                      }
                      echo "</select> </p> </div>";
                      echo "<div class='row'>";
                      $sql="SELECT*FROM sede__db_area;";
                      $sedeResultado=mysqli_query($conexion,$sql);
                      echo "<p  class='col-sm-12'> Sede <br> <select name='sede'>";
                      while($row=mysqli_fetch_array($sedeResultado)){
                        if($row['id']==$resultado['id_sede']){
                          echo "<option value=".$row['id']." selected>". $row['sede'] ."</option>";
                        }
                        else{
                          echo "<option value=".$row['id'].">". $row['sede'] ."</option>";
                        }
                      }
                      echo "</select> </p> </div>";
              ?> 
                </div>      
            <input type="submit" id='boton' value="Editar" onclick="location.href='../Usuarios.php'">
            <input type="button" id='boton' value="Volver" onclick="location.href='../Usuarios.php'">
          </form>
          <?php
          $dni=$_POST['dni'];
          $nombre=$_POST['nombre'];
          $apellido=$_POST['apellido'];
          $usuario=$_POST['usuario'];
          $contraseña=$_POST['contraseña'];
          $tipo=$_POST['cargo'];	
          $sede=$_POST['sede'];
          $sqlEditar="UPDATE usuarios_db SET dni=$dni,nombre='$nombre',apellido='$apellido',usuario='$usuario',clave='$contraseña',id_sede=$sede,id_tipo=$tipo
          WHERE dni=$dniComparacion;";
          $consultaUsuario=mysqli_query($conexion,$sqlEditar);
          ?>
        </div>
</body>
