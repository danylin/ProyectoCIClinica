<div class="container-table">
    <div class="table__title">Eventos Actuales</div>
    <?php
    include("bd_usuario.php");
    $sql="SELECT*FROM evento_acc_db;";
    $resultado=mysqli_query($conexion,$sql);
    while($row=mysqli_fetch_array($resultado)){
        echo "<div class='table__item'>". $row['fecha']."</div>";
        echo "<div class='table__item'>". $row['fecha']."</div>";
        echo "<div class='table__item'>". $row['fecha']."</div>";
        echo "<div class='table__item'>". $row['fecha']."</div>";
    }
    ?>
</div>