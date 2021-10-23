<?php
if($_SESSION['tipousuario']==1){
    echo '<li class="nav-item active"><a class="nav-link" href="../usuario1.php">EVENTOS <i class="fa fa-plus-square" aria-hidden="true"></i></a></li>
    <li class="nav-item"><a class="nav-link" href="../include/logout.php">SALIR <i class="fas fa-sign-out-alt"></i></a></li>';
} else{
    echo '<li class="nav-item active"><a class="nav-link" href="../usuario2.php">EVENTOS <i class="fa fa-plus-square" aria-hidden="true"></i></a></li>
    <li class="nav-item"><a class="nav-link" href="../usuario/Usuarios.php">USUARIOS <i class="fa fa-user" aria-hidden="true"></i></a></li>
    <li class="nav-item"><a class="nav-link" href="../include/logout.php">SALIR <i class="fas fa-sign-out-alt"></i></a></li>';
}
?>