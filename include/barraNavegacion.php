<?php
//En relacion a la barra de navegacion se visualizará ciertos apartados en funcion al tipo de usuario que inicio sesion.
if($_SESSION['tipousuario']==1){
    echo '<li class="nav-item active"><a class="nav-link" href="../usuario1.php" id="textoNavegador">Eventos <i class="fa fa-plus-square" aria-hidden="true"></i></a></li>
    <li class="nav-item"><a class="nav-link" href="../include/logout.php" id="textoNavegador">Salir <i class="fas fa-sign-out-alt"></i></a></li>';
} else{
    echo '<li class="nav-item active"><a class="nav-link" href="../usuario2.php" id="textoNavegador">Eventos <i class="fa fa-plus-square" aria-hidden="true"></i></a></li>
    <li class="nav-item"><a class="nav-link" href="../usuario/Usuarios.php" id="textoNavegador">Usuarios <i class="fa fa-user" aria-hidden="true"></i></a></li>
    <li class="nav-item"><a class="nav-link" href="../include/logout.php" id="textoNavegador">Salir <i class="fas fa-sign-out-alt"></i></a></li>';
}
?>