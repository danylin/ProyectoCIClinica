<!DOCTYPE html>
<html >
<head>
    <?php
    include("../include/titulo.php")
    ?>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <img class="navbar-brand" src="../img/logotipo_auna.png" alt="logotipo auna">
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item active"><a class="nav-link" href="../usuario2.php">CREACION DE EVENTOS <i class="fa fa-plus-square" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="../usuario/Usuarios.php">CREACION DE USUARIO <i class="fa fa-user" aria-hidden="true"></i></a></li>
            <li class="nav-item"><a class="nav-link" href="../include/logout.php">SALIR <i class="fas fa-sign-out-alt"></i></a></li>
          </ul>
        </div>
      </nav>
    </header>
    <section>
        <?php
        include("../include/bd_usuario.php");
        
        ?>
        <div id="titulo_reporte">
            <h3>Reporte de Evento</h3>
        </div>
        <div id="informacio-general">
            <p>Nro de Encuentro</p>
            <p>Fecha</p>
            <p>Paciente</p>
            <p>Procedimiento</p>
            <p>Cirujano Principal</p>
        </div>
        <div>
            <table>
                <thead>
                    <th>Codigo de Material</th>
                    <th>Cantidad</th>
                    <th>Descripcion del Material</th>
                    <th>Tipo</th>
                </thead>
                <tbody>
                    <tr>
                        <td>10000</td>
                        <td>2</td>
                        <td>Hola</td>
                        <td>K</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>